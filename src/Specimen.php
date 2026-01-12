<?php

namespace mmerlijn\msgRepo;

class Specimen implements RepositoryInterface
{

    use HasObservationsTrait, CompactTrait;

    /**
     * @param string $id
     * @param Testcode $type
     * @param bool|null $available
     * @param Testcode $container
     * @param Observation[] $observations
     * @param string $location
     * @param string $collection_method
     * @param string $collection_source
     * @param string $collection_source_modifier
     */
    public function __construct(
        public string         $id = "",
        public Testcode|array $type = new TestCode(),
        public bool|null      $available = null,
        public Testcode|array $container = new TestCode(),
        public array          $observations = [],
        public string         $location = "",
        public string         $collection_method = "", //spm7.1
        public string         $collection_source = "", //spm8.1
        public string         $collection_source_modifier = "", //spm9.1

    )
    {
        $this->setTest($type);
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
            'type' => $this->type->toArray($compact),
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


    public function setTest(TestCode|array $type): void
    {
        if (is_array($type)) {
            $this->type = new TestCode(...$type);
        } else {
            $this->type = $type;
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