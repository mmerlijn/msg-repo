<?php

namespace mmerlijn\msgRepo;

trait HasCommentsTrait
{
    public function addComment(string $comment): self
    {
        $this->comments[] = trim($comment);
        return $this;
    }

    public function resetComments()
    {
        $this->comments = [];
    }
}