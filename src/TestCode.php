<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\StripUnwanted;

class TestCode implements RepositoryInterface
{
    use CompactTrait;

    /**
     * @param string $code
     * @param string $value
     * @param string $source
     */
    public function __construct(
        public string $code = "",
        public string $value = "",
        public string $source = "",
    )
    {
        $this->value = StripUnwanted::format($value);
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
            "value" => $this->value,
            "source" => $this->source,
        ], $compact);
    }

    public function fromArray(array $data): TestCode
    {
        return new TestCode(...$data);
    }


}