<?php

namespace mmerlijn\msgRepo;

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
        $this->comments[] = trim($comment);
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