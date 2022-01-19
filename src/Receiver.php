<?php

namespace mmerlijn\msgRepo;

class Receiver implements RepositoryInterface
{
    public function __construct(
        public string $name = "",
        public string $application = "",
        public string $facility = "",
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'application' => $this->application,
            'facility' => $this->facility,
        ];
    }
}