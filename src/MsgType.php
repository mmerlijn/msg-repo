<?php

namespace mmerlijn\msgRepo;

class MsgType implements RepositoryInterface
{
    use CompactTrait;

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
     * @param bool $compact
     * @return array
     */
    public function toArray(bool $compact = false): array
    {
        return $this->compact([
            'type' => $this->type,
            'trigger' => $this->trigger,
            'structure' => $this->structure,
            'version' => $this->version,
            'charset' => $this->charset,
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): MsgType
    {
        return new MsgType(...$data);
    }
}