<?php

declare(strict_types=1);

namespace Nakukryskin\OrchidFlexibleContentField\Observers;

use Orchid\Press\Models\Post;

/**
 * Class FlexibleContentObserver.
 */
class FlexibleContentObserver
{
    private $post;

    /**
     * Handle the User "created" event.
     *
     * @param Post $post
     * @return void
     */
    public function saving(Post $post)
    {
        $this->post = $post;
    }

    public function retrieved(Post $post)
    {
        $this->post = $post;
    }
}
