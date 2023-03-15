<?php

namespace mmerlijn\msgRepo;

class MsgType implements RepositoryInterface
{
    /**
     * @param string $type
     * @param string $trigger
     * @param string $structure
     * @param string $version
     * @param string $charset
     */
    public function __construct(
        public string $type = "",
        public string $trigger = "",
        public string $structure = "",
        public string $version = "",
        public string $charset = "",
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
            'charset' => $this->charset,
        ];
    }

    public function fromArray(array $data): MsgType
    {
        $this->type = $data['type'];
        $this->trigger = $data['trigger'];
        $this->structure = $data['structure'];
        $this->version = $data['version'];
        $this->charset = $data['charset'];
        return $this;
    }
}