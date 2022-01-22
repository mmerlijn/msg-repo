<?php

namespace mmerlijn\msgRepo;

class Receiver implements RepositoryInterface
{
    use HasContactTrait;

    public function __construct(
        public ?Contact $contact = null,
        public string   $application = "",
        public string   $device = "",
        public string   $facility = "", //????
    )
    {
    }

    public function toArray(): array
    {
        return [
            'contact' => $this->contact?->toArray(),
            'application' => $this->application,
            'device' => $this->device,
            'facility' => $this->facility,
        ];
    }
}