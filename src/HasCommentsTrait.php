<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\StripUnwanted;

trait HasCommentsTrait
{

    /**
     * add comment to comments array for current object
     *
     * @param string $comment
     * @return $this
     */
    public function addComment(string $comment): self
    {
        $this->comments[] = trim(StripUnwanted::format($comment, 'comment'));
        return $this;
    }


    /**
     * Reset/clear all comments
     *
     * @return void
     */
    public function resetComments()
    {
        $this->comments = [];
    }
}