<?php

namespace mmerlijn\msgRepo;

class Request implements RepositoryInterface
{

    use HasCommentsTrait, CompactTrait, HasResultsTrait;

    /**
     * @param array|TestCode $test
     * @param array|TestCode $other_test
     * @param string $id
     * @param array|TestCode $container
     * @param array $comments array of strings
     * @param bool $change
     * @param array $results
     */
    public function __construct(

        public array|TestCode $test = new TestCode,
        public array|TestCode $other_test = new TestCode,
        public array|TestCode $container = new TestCode,
        public array    $comments = [],
        public bool     $change = false,
        public string   $id = "",
        public array    $results = [],
    )
    {
        $this->setTest($test);
        $this->setOtherTest($other_test);
        $this->setContainer($container);
        $this->results = [];
        foreach ($results as $result) {
            $this->addResult($result);
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
            'container' => $this->container?->toArray($compact),
            'comments' => array_map(fn($value) => $value->toArray($compact), $this->comments),
            'change' => $this->change,
            'id' => $this->id,
            'results' => array_map(fn($value) => $value->toArray($compact), $this->results),
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

    public function setContainer(TestCode|array $container): void
    {
        if (is_array($container)) {
            $this->container = new TestCode(...$container);
        } else {
            $this->container = $container;
        }
    }
}