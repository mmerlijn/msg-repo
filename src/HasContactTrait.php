<?php

namespace mmerlijn\msgRepo;

trait HasContactTrait
{
    public function setContact(Contact $contact): self
    {
        $this->contact = $contact;
        return $this;
    }
}