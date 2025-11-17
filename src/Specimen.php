<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;
use mmerlijn\msgRepo\Enums\ResultFlagEnum;
use mmerlijn\msgRepo\Enums\ValueTypeEnum;
use mmerlijn\msgRepo\Helpers\StripUnwanted;

class Specimen implements RepositoryInterface
{

    use HasObservationsTrait, CompactTrait;

    /**
     * @param string $id
     * @param array|TestCode $test
     * @param bool|null $available
     * @param Testcode|array $container
     * @param array $observations
     * @param string $location
     */
    public function __construct(
        public string         $id = "",
        public Testcode|array $test = new TestCode(),
        public bool|null      $available = null,
        public Testcode|array $container = new TestCode(),
        public array          $observations = [],
        public string         $location = "",
    )
    {
        $this->setTest($test);
        $this->setContainer($container);
        $this->observations = [];
        foreach ($observations as $c) {
            $this->addObservation($c);
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
            'id' => $this->id,
            'test' => $this->test->toArray($compact),
            'available' => $this->available,
            'container' => $this->container->toArray($compact),
            'observations' => array_map(fn($value) => $value->toArray($compact), $this->observations),
            'location' => $this->location,
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): Specimen
    {
        return new Specimen(...$data);
    }


    public function setTest(TestCode|array $test): void
    {
        if (is_array($test)) {
            $this->test = new TestCode(...$test);
        } else {
            $this->test = $test;
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

    public function hasContainer(): bool
    {
        return $this->container->code or $this->container->value;
    }

}