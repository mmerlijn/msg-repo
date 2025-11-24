<?php

namespace mmerlijn\msgRepo;

use mmerlijn\msgRepo\Enums\ResultFlagEnum;
use mmerlijn\msgRepo\Enums\ValueTypeEnum;
use mmerlijn\msgRepo\Helpers\StripUnwanted;


/*
 * Observation / Result of a test
 *
 *
 */
class Observation implements RepositoryInterface
{

    use HasCommentsTrait, CompactTrait;

    /**
     * @param string|ValueTypeEnum $type
     * @param string|float|int $value
     * @param array|TestCode $test
     * @param string $units
     * @param string $quantity
     * @param string $reference_range
     * @param ResultFlagEnum|string $abnormal_flag H = high, L = low
     * @param array $comments
     * @param bool $done item is processed
     * @param bool $change item is changed
     * @param array $values
     */
    public function __construct(
        public string|ValueTypeEnum  $type="",
        public string|float|int      $value = "",
        public array|TestCode        $test = new TestCode,
        public string                $units = "",
        public string                $quantity = "",
        public string                $reference_range = "",
        public ResultFlagEnum|string $abnormal_flag = ResultFlagEnum::EMPTY,
        public array                 $comments = [],
        public bool                  $done = true,
        public bool                  $change = false,
        public array                 $values = [], //multiple values for this result
    )
    {
        $this->setTest($test);
        $this->value = StripUnwanted::format($value, 'comment');
        $this->abnormal_flag = ResultFlagEnum::set($this->abnormal_flag);
        $this->values = [];
        foreach ($values as $v) {
            $this->addValue($v);
        }
        $this->comments =[];
        foreach ($comments as $c) {
            $this->addComment($c);
        }
        $this->type = ValueTypeEnum::isValueType($value, $this->values, $this->type);
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
            'type' => $this->type->value,
            'value' => $this->value,
            'test' => $this->test->toArray($compact),
            'units' => $this->units,
            'quantity' => $this->quantity,
            'reference_range' => $this->reference_range,
            'abnormal_flag' => $this->abnormal_flag->value,
            'comments' => array_map(fn($value) => $value->toArray($compact), $this->comments),
            'done' => $this->done,
            'change' => $this->change,
            'values' => array_map(fn($value) => $value->toArray($compact), $this->values),
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): Observation
    {
        return new Observation(...$data);
    }

    public function addValue(TestCode|array $value = new TestCode()): self
    {
        if (is_array($value)) $value = new TestCode(...$value);
        $value->value = StripUnwanted::format($value->value, 'comment');
        foreach ($this->values as $r) {
            if ($value->code and $value->code == $r->code) {
                return $this;
            }
        }
        $this->values[] = $value;
        if($this->hasValues()){
            $this->type = ValueTypeEnum::CE;
        }
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

    public function hasValues(): bool
    {
        return !empty($this->values);
    }
}