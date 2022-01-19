<?php

namespace mmerlijn\msgRepo;

class Sender implements RepositoryInterface
{
    public function __construct(
        public string $name = "",
        public string $application = "",
        public string $device = "",
        public string $facility = "",
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'application' => $this->application,
            'device' => $this->device,
            'facility' => $this->facility,
        ];
    }
}