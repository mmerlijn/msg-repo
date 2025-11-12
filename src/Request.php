<?php

namespace mmerlijn\msgRepo;

class Request implements RepositoryInterface
{

    use HasCommentsTrait, CompactTrait;

    /**
     * @param string $test_code
     * @param string $test_name
     * @param string $test_source
     * @param string $other_test_code
     * @param string $other_test_name
     * @param string $other_test_source
     * @param string $id
     * @param array $comments array of strings
     * @param bool $change
     */
    public function __construct(

        public string $test_code = "", //deprecated
        public string $test_name = "", //deprecated
        public string $test_source = '', //deprecated
        public ?TestCode $test=null,

        public string $other_test_code = '', //deprecated
        public string $other_test_name = '', //deprecated
        public string $other_test_source = '', //deprecated
        public ?TestCode $other_test=null,

        public string $id = "",
        public ?TestCode $container = null,

        //public string           $units = "",
        //public string           $quantity = "",
        public array  $comments = [],
        public bool   $change = false,
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
            'test_code' => $this->test_code,
            'test_name' => $this->test_name,
            'test_source' => $this->test_source,
            'other_test_code' => $this->other_test_code,
            'other_test_name' => $this->other_test_name,
            'other_test_source' => $this->other_test_source,
            'comments' => $this->comments,
            'change' => $this->change,
            'id' => $this->id,
            'container' => $this->container?->toArray($compact),
            'test' => $this->test?->toArray($compact),
            'other_test' => $this->other_test?->toArray($compact),
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
        }else{
            $this->test = $test;
        }
    }
    public function setOtherTest(TestCode|array $test): void
    {
        if (is_array($test)) {
            $this->other_test = new TestCode(...$test);
        }else{
            $this->other_test = $test;
        }
    }
    public function setContainer(TestCode|array $container): void
    {
        if (is_array($container)) {
            $this->container = new TestCode(...$container);
        }else{
            $this->container = $container;
        }
    }
}