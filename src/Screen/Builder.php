<?php

namespace Nakukryskin\OrchidFlexibleContentField\Screen;

use Orchid\Screen\Repository;

/**
 * Rendering the flexible content form.
 *
 * Class Builder
 * @package Nakukryskin\OrchidFlexibleContentField\Screen
 */
class Builder extends \Orchid\Screen\Builder
{
    /**
     * Builder constructor.
     *
     * @param string $prefix
     * @param \Orchid\Screen\Contracts\FieldContract[] $fields
     * @param Repository $data
     */
    public function __construct(string $prefix, array $fields, $data)
    {
        $this->prefix = $prefix;
        parent::__construct($fields, $data);
    }

}