<?php

declare(strict_types=1);

namespace Nakukryskin\OrchidFlexibleContentField\Screen\Layouts;

use Orchid\Screen\Repository;
use Orchid\Screen\Layouts\Base;
use Nakukryskin\OrchidFlexibleContentField\Screen\Builder;
use Nakukryskin\OrchidFlexibleContentField\Screen\Fields\FlexibleContentField;

/**
 * Class FlexibleContentLayout.
 */
abstract class FlexibleContentLayout extends Base
{
    const BLOCK_TEMPLATE = 'platform::partials.fields.flexible_content_block';
    /**
     * Current template.
     *
     * @var string
     */
    public $template = 'platform::container.layouts.flexible_content_row';

    /**
     * @var Repository
     */
    public $query;

    /**
     * Original flexible content field.
     *
     * @var FlexibleContentField
     */
    public $field;

    /**
     * Pre-generated field index.
     *
     * @var string
     */
    public $fieldIndex;

    /**
     * Minimum layouts.
     *
     * @var int
     */
    public $min;

    /**
     * Maximum layouts.
     *
     * @var int
     */
    public $max;

    public function __construct(FlexibleContentField $field)
    {
        $this->field = $field;
        $this->setFieldIndex(':flexibleindex_'.sha1(serialize($this->field)));
    }

    /**
     * Building the form based on configuration.
     *
     * @param \Orchid\Screen\Repository $query
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function build(Repository $query)
    {
        $this->query = $query;
        $form = new Builder($this->fields(), $query);

        $form->setPrefix($this->getFormPrefix());

        return view($this->template, [
            'name' => $this->name(),
            'form' => $form->generateForm(),
        ]);
    }

    /**
     * Return name of the layout such a 'gallery'.
     *
     * @return string
     */
    abstract public function name(): string;

    /**
     * Return title of layout such a "Gallery".
     *
     * @return string
     */
    abstract public function title(): string;

    /**
     * Return array of the fields.
     *
     * @return array
     */
    abstract public function fields(): array;

    /**
     * Set the field index for the javascript replacement.
     * @param string $index
     * @return FlexibleContentLayout
     */
    public function setFieldIndex($index = null): self
    {
        $this->fieldIndex = $index;

        return $this;
    }

    /**
     * Return full prefix for the flexible content fields.
     *
     * @return string
     */
    public function getFormPrefix()
    {
        return $this->field->get('name').'['.$this->fieldIndex.']['.$this->name().']';
    }
}
