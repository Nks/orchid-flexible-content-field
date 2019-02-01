<?php

namespace Nakukryskin\OrchidFlexibleContentField\Screen\Layouts;

use Orchid\Screen\Builder;
use Orchid\Screen\Repository;
use Orchid\Screen\Layouts\Base;

abstract class FlexibleContentLayout extends Base
{
    /**
     * @var string
     */
    public $template = 'platform::container.layouts.row';

    /**
     * @var Repository
     */
    public $query;

    /**
     * @param \Orchid\Screen\Repository $query
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function build(Repository $query)
    {
        $this->query = $query;
        $form = new Builder($this->fields(), $query);

        return view($this->template, [
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
}
