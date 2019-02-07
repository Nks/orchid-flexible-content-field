<?php

declare(strict_types=1);

namespace Orchid\Press\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PostBlocks.
 */
class PostBlock extends Model
{
    /**
     * @var string
     */
    protected $table = 'post_blocks';

    /**
     * @var array
     */
    protected $fillable = [
        'post_id',
        'lang',
        'sort',
        'layout',
        'content',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'content' => 'array',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
