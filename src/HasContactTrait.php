<?php

namespace mmerlijn\msgRepo;

trait HasContactTrait
{

    /**
     * Set contact object for current object
     *
     * @param Contact $contact
     * @return $this
     */
    public function setContact(Contact $contact = new Contact()): self
    {
        $this->contact = $contact;
        return $this;
    }
}