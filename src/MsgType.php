<?php

namespace mmerlijn\msgRepo;

class MsgType implements RepositoryInterface
{
    public function __construct(
        public string $type = "",
        public string $trigger = "",
        public string $structure = ""
    )
    {
    }

    public function toArray(): array
    {
        return [
            'type' => '',
            'trigger' => '',
            'structure' => ''
        ];
    }
}