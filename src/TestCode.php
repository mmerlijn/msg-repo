<?php

namespace mmerlijn\msgRepo;


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
        public string $a_code = "",
        public string $a_value = "",
        public string $a_source = "",
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
            "value" => $this->value,
            "source" => $this->source,
            "a_code" => $this->a_code,
            "a_value" => $this->a_value,
            "a_source" => $this->a_source,
        ], $compact);
    }

    public function fromArray(array $data): TestCode
    {
        return new TestCode(...$data);
    }


}