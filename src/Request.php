<?php

namespace mmerlijn\msgRepo;

class Request implements RepositoryInterface
{

    use HasCommentsTrait, CompactTrait, HasObservationsTrait, HasSpecimensTrait;

    /**
     * @param array|TestCode $test
     * @param array|TestCode $other_test
     * @param bool $change
     * @param string $id
     * @param string $clinical_info
     * @param null|bool $priority
     * @param array $observations
     * @param array $specimens
     * @param array $comments array of strings
     */
    public function __construct(

        public array|TestCode $test = new TestCode,
        public array|TestCode $other_test = new TestCode,
        public bool           $change = false,
        public string         $id = "",
        public string         $clinical_info = "",
        public null|bool      $priority = null,
        public array          $observations = [],
        public array          $specimens = [],
        public array          $comments = [],
    )
    {
        $this->setTest($test);
        $this->setOtherTest($other_test);
        $this->observations = [];
        foreach ($observations as $result) {
            $this->addObservation($result);
        }
        $this->specimens = [];
        foreach ($specimens as $specimen) {
            $this->addSpecimen($specimen);
        }
        $this->comments = [];
        foreach ($comments as $comment) {
            $this->addComment($comment);
        }
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
            'test' => $this->test->toArray($compact),
            'other_test' => $this->other_test->toArray($compact),
            'change' => $this->change,
            'id' => $this->id,
            'clinical_info' => $this->clinical_info,
            'priority' => $this->priority,
            'observations' => array_map(fn($value) => $value->toArray($compact), $this->observations),
            'specimens' => array_map(fn($value) => $value->toArray($compact), $this->specimens),
            'comments' => array_map(fn($value) => $value->toArray($compact), $this->comments),
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): Request
    {
        return new Request(...$data);
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


    public function hasOtherTest(): bool
    {
        return $this->other_test->code or $this->other_test->value;
    }
}