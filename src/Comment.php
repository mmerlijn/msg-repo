<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Helpers\StripUnwanted;

class Comment implements RepositoryInterface
{
    use CompactTrait;

    /**
     * @param string $text
     * @param string $source
     * @param array|TestCode $type
     */
    public function __construct(
        public string $text = "",
        public string $source = "",
        public array|TestCode $type = new TestCode,
    )
    {
        $this->text = StripUnwanted::format($text);
        $this->setType($type);
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
            "text" => $this->text,
            "source" => $this->source,
            "type" => $this->type->toArray($compact),
        ], $compact);
    }

    /**
     * restore state from array
     *
     * @param array $data
     * @return Comment
     */
    public function fromArray(array $data): Comment
    {
        return new Comment(...$data);
    }

    /**
     * @param array|TestCode $type
     * @return void
     */
    public function setType(array|TestCode $type): void
    {
        if (is_array($type)) {
            $this->type = new TestCode(...$type);
        } else {
            $this->type = $type;
        }
    }
}