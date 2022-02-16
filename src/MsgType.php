<?php

namespace mmerlijn\msgRepo;

class MsgType implements RepositoryInterface
{
    /**
     * @param string $type
     * @param string $trigger
     * @param string $structure
     * @param string $version
     */
    public function __construct(
        public string $type = "",
        public string $trigger = "",
        public string $structure = "",
        public string $version = "",
    )
    {
    }

    /**
     * Dump state
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'trigger' => $this->trigger,
            'structure' => $this->structure,
            'version' => $this->version,
        ];
    }
}