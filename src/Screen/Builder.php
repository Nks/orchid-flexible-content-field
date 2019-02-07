<?php

declare(strict_types=1);

namespace Nakukryskin\OrchidFlexibleContentField\Screen;

use Orchid\Screen\Repository;
use Illuminate\Support\Collection;
use Nakukryskin\OrchidFlexibleContentField\Screen\Layouts\FlexibleContentLayout;

/**
 * Rendering the flexible content form.
 *
 * Class Builder
 */
class Builder extends \Orchid\Screen\Builder
{
    /**
     * Render form with the values.
     *
     * @param Collection $layouts
     * @param array $values
     * @return null|string
     * @throws \Throwable
     */
    public static function buildFlexibleLayout(Collection $layouts, $values = null)
    {
        if (! is_array($values)) {
            $values = array_wrap($values);
        }
        $form = '';

        foreach ($values as $index => $data) {
            if (! is_array($data)) {
                continue;
            }

            $layoutName = array_get($data, '_fc_layout');

            if (! $layoutName) {
                continue;
            }

            //skip not existing layouts
            if (! $layouts->has($layoutName)) {
                continue;
            }

            /** @var FlexibleContentLayout $layout */
            $layout = $layouts->get($layoutName);

            throw_if(! ($layout instanceof FlexibleContentLayout),
                new \Exception(sprintf('%s is not flexible content layout', class_basename($layout))));

            //bail the layout
            $layout = clone $layout;

            $layout->setFieldIndex($index);

            if ($data) {
                $data = new Repository(collect($data)->mapWithKeys(function ($item, $key) use ($layout) {
                    return [$layout->getFormPrefix().'.'.$key => $item];
                })->toArray());
            }

            $layout->template = FlexibleContentLayout::BLOCK_TEMPLATE;

            $form .= $layout->build($data, (string) $index);
        }

        return $form;
    }
}
