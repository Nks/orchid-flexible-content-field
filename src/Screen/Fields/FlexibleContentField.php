<?php

declare(strict_types=1);

namespace Nakukryskin\OrchidFlexibleContentField\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Creating flexible content fields
 *
 * Class FlexibleContentField
 * @package Nakukryskin\OrchidFlexibleContentField
 *
 * @method $this required($value = true)
 * @method $this help(string $value = null)
 * @method $this name($value = true)
 * @method $this handler($value = true)
 */
class FlexibleContentField extends Field
{
    /**
     * View name
     *
     * @var string
     */
    public $view = 'platform::fields.flexible_content';


    protected $layout;

    /**
     * Required Attributes.
     *
     * @var array
     */
    public $required = [
        'name',
        'layouts'
    ];

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class' => 'form-control',
        'original_name' => null
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
        'required',
        'name'
    ];

    public function layouts(array $layouts): self
    {
        $this->set('layouts', collect(array_map(function () {

        }, $layouts)));

        return $this;
    }


    /**
     * Creating an instance of the repeater field
     *
     * @param string $name
     * @return FlexibleContentField
     */
    public static function make(string $name): self
    {
        return (new static)->name($name)->set('original_name', $name)->value([]);
    }
}