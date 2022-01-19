<?php

namespace mmerlijn\msgRepo;

trait HasCommentsTrait
{
    public function addComment(string $comment): self
    {
        $this->comments[] = $comment;
        return $this;
    }

    public function resetComments()
    {
        $this->comments = [];
    }
}