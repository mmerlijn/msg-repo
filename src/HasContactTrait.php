<?php

namespace mmerlijn\msgRepo;

trait HasContactTrait
{
    public function setContact(Contact $contact = new Contact()): self
    {
        $this->contact = $contact;
        return $this;
    }
}