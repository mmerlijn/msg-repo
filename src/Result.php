<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Enums\ResultFlagEnum;
use mmerlijn\msgRepo\Helpers\StripUnwanted;

class Result implements RepositoryInterface
{

    use HasCommentsTrait, CompactTrait;

    /**
     * @param string $type_of_value
     * @param string|float|int $value
     * @param string $test_code
     * @param string $test_name
     * @param string $test_source
     * @param TestCode|null $test
     * @param string $other_test_code
     * @param string $other_test_name
     * @param string $other_test_source
     * @param TestCode|null $otherTest
     * @param string $units
     * @param string $quantity
     * @param string $reference_range
     * @param ResultFlagEnum|string $abnormal_flag H = high, L = low
     * @param array $comments
     * @param bool $done item is processed
     * @param bool $change item is changed
     * @param string $only_for_request_test_code code of the request this result belongs to
     * @param array $options
     */
    public function __construct(
        public string                $type_of_value = "",
        public string|float|int      $value = "",
        public string                $test_code = "",
        public string                $test_name = "",
        public string                $test_source = '',
        public ?TestCode             $test = null,
        public string                $other_test_code = '',
        public string                $other_test_name = '',
        public string                $other_test_source = '',
        public ?TestCode             $otherTest = null,
        public string                $units = "",
        public string                $quantity = "",
        public string                $reference_range = "",
        public ResultFlagEnum|string $abnormal_flag = ResultFlagEnum::EMPTY,
        public array                 $comments = [],
        public bool                  $done = true,
        public bool                  $change = false,
        public string                $only_for_request_test_code = '',
        public array                 $options = [],
    )
    {
        $this->value = StripUnwanted::format($value, 'comment');
        if (is_string($this->abnormal_flag)) $this->abnormal_flag = ResultFlagEnum::set($this->abnormal_flag);
        $this->options = [];
        foreach ($options as $option) {
            if (is_array($option)) $option = new Request(...$option);
            $this->addOption($option);
        }
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
            'value' => $this->value,
            'type_of_value' => $this->type_of_value,
            'units' => $this->units,
            'test_code' => $this->test_code,
            'test_name' => $this->test_name,
            'test_source' => $this->test_source,
            'test' => $this->testCode?->toArray($compact),
            'other_test_code' => $this->other_test_code,
            'other_test_name' => $this->other_test_name,
            'other_test_source' => $this->other_test_source,
            'other_test' => $this->otherTestCode?->toArray($compact),
            'quantity' => $this->quantity,
            'reference_range' => $this->reference_range,
            'abnormal_flag' => $this->abnormal_flag->value,
            'comments' => $this->comments,
            'done' => $this->done,
            'change' => $this->change,
            'options' => array_map(fn($value) => $value->toArray($compact), $this->options),
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): Result
    {
        return new Result(...$data);
    }

    public function addOption(Option|array $option = new Option()): self
    {
        if (is_array($option)) $option = new Result(...$option);
        foreach ($this->options as $r) {
            if ($option->label == $r->label) {
                return $this;
            }
        }
        $this->options[] = $option;
        return $this;
    }

    public function setTest(TestCode|array $test): void
    {
        if (is_array($test)) {
            $this->test = new TestCode(...$test);
        } else {
            $this->test = $test;
        }
    }

    public function setOtherTest(TestCode|array $test): void
    {
        if (is_array($test)) {
            $this->other_test = new TestCode(...$test);
        } else {
            $this->other_test = $test;
        }
    }
}