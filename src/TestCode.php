<?php

namespace mmerlijn\msgRepo;

class TestCode implements RepositoryInterface
{
    use CompactTrait;

    /**
     * @param string $code
     * @param string $name
     * @param string $source
     */
    public function __construct(
        public string $code,
        public string $name = "",
        public string $source = "",
    )
    {

    }

    /**
     * dump state
     *
     * @param bool $compact
     * @return array
     */
    public function toArray(bool $compact = false): array
    {
        return $this->compact([
            "code" => $this->code,
            "name" => $this->name,
            "source" => $this->source,
        ], $compact);
    }



}