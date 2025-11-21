<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\StripUnwanted;

trait HasCommentsTrait
{

    /**
     * add comment to comments array for current object
     *
     * @param Comment|array|string $comment
     * @return Msg|HasCommentsTrait|Order|Request|Observation
     */
    public function addComment(Comment|array|string $comment): self
    {
        if (is_array($comment)) {
            $comment = new Comment(...$comment);
        } elseif (is_string($comment)) {
            $comment = new Comment(text: $comment);
        }
        $comment->text = trim(StripUnwanted::format($comment->text, 'comment'));
        $this->comments[] = $comment;
        return $this;
    }

    /**
     * Reset/clear all comments
     *
     * @return void
     */
    public function resetComments(): void
    {
        $this->comments = [];
    }

    /**
     * Check if there are comments
     *
     * @return bool
     */
    public function hasComments(): bool
    {
        return !empty($this->comments);
    }
}