<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\StripUnwanted;

class TestCode implements RepositoryInterface
{
    use CompactTrait;

    /**
     * @param string $code
     * @param string $name
     * @param string $source
     */
    public function __construct(
        public string $code = "",
        public string $name = "",
        public string $source = "",
    )
    {
        $this->name = StripUnwanted::format($name);
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

    public function fromArray(array $data): TestCode
    {
        return new TestCode(...$data);
    }


}