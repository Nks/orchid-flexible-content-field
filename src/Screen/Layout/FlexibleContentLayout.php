<?php

namespace Nakukryskin\OrchidFlexibleContentField\Screen\Layouts;

use Nakukryskin\OrchidFlexibleContentField\Screen\Fields\FlexibleContentField;
use Orchid\Screen\Builder;
use Orchid\Screen\Layouts\Base;
use Orchid\Screen\Repository;

abstract class FlexibleContentLayout extends Base
{
    /**
     * Current template
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
     * Minimum layouts.
     *
     * @var integer
     */
    public $min;

    /**
     * Maximum layouts.
     *
     * @var integer
     */
    public $max;

    public function __construct(FlexibleContentField $field)
    {
        $this->field = $field;
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
     * Return full prefix for the flexible content fields.
     *
     * @return string
     */
    private function getFormPrefix()
    {

        return $this->field->get('name').'[:flexibleindex]['.$this->name().']';
    }
}
