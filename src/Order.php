<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;
use mmerlijn\msgRepo\Enums\OrderControlEnum;
use mmerlijn\msgRepo\Enums\OrderStatusEnum;
use mmerlijn\msgRepo\Enums\OrderWhereEnum;

class Order implements RepositoryInterface
{

    use  CompactTrait, HasOrganisationTrait, HasDateTrait;

    /**
     * @param string|OrderControlEnum $control N=new, C=Cancel
     * @param string $request_nr
     * @param string|int $lab_nr
     * @param bool $complete
     * @param null|bool $priority
     * @param Carbon|string|null $start_date
     * @param string|OrderStatusEnum $order_status
     * @param string|OrderWhereEnum $where home , other
     * @param array|Contact $requester
     * @param array|Contact $copy_to
     * @param array|Contact $entered_by
     * @param array|Organisation $organisation
     * @param Carbon|string|null $request_at dt of execution time
     * @param Carbon|string|null $observation_at
     * @param Carbon|string|null $observation_end_at
     * @param Carbon|string|null $analysis_at
     * @param array $requests array of Requests
     * @param array|Testcode $admit_reason
     */
    public function __construct(
        public string|OrderControlEnum $control = OrderControlEnum::NEW,
        public string                  $request_nr = "", //AB12341234
        public string|int              $lab_nr = "", //internal processing nr
        public bool                    $complete = true,
        public null|bool               $priority = null,
        public Carbon|string|null      $start_date = null,
        public string|OrderStatusEnum  $order_status = OrderStatusEnum::FINAL,
        public string|OrderWhereEnum   $where = OrderWhereEnum::EMPTY,
        public array|Contact           $requester = new Contact,
        public array|Contact           $copy_to = new Contact,
        public array|Contact           $entered_by = new Contact,
        public array|Organisation      $organisation = new Organisation,
        public Carbon|string|null      $request_at = null,
        public Carbon|string|null      $observation_at = null,
        public Carbon|string|null      $observation_end_at = null,
        public Carbon|string|null      $analysis_at = null,
        public array                   $requests = [],
        public array|Testcode          $admit_reason = new TestCode,
    )
    {
        if (is_array($requester)) $this->requester = new Contact(...$requester);
        if (is_array($copy_to)) $this->copy_to = new Contact(...$copy_to);
        if (is_array($entered_by)) $this->entered_by = new Contact(...$entered_by);
        $this->setOrganisation($organisation);
        $this->start_date = $this->formatDate($start_date);
        $this->request_at = $this->formatDate($request_at);
        $this->observation_at = $this->formatDate($observation_at);
        $this->observation_end_at = $this->formatDate($observation_end_at);
        $this->analysis_at = $this->formatDate($analysis_at);
        $this->order_status = OrderStatusEnum::set($order_status);
        $this->where = OrderWhereEnum::set($where);
        $this->control = OrderControlEnum::set($control);
        $this->requests = [];
        foreach ($requests as $request) {
            $this->addRequest($request);
        }
        $this->setAdmitReason($admit_reason);
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
            'control' => $this->control->value,
            'request_nr' => $this->request_nr,
            'lab_nr' => $this->lab_nr,
            'complete' => $this->complete,
            'priority' => $this->priority,
            'start_date' => $this->start_date?->format("Y-m-d"),
            'order_status' => $this->order_status->value,
            'where' => $this->where->value,
            'requester' => $this->requester->toArray($compact),
            'copy_to' => $this->copy_to->toArray($compact),
            'entered_by' => $this->entered_by->toArray($compact),
            'organisation' => $this->organisation->toArray($compact),
            'request_at' => $this->request_at?->format("Y-m-d H:i:s"),
            'observation_at' => $this->observation_at?->format("Y-m-d H:i:s"),
            'observation_end_at' => $this->observation_end_at?->format("Y-m-d H:i:s"),
            'analysis_at' => $this->analysis_at?->format("Y-m-d H:i:s"),
            'requests' => array_map(fn($value) => $value->toArray($compact), $this->requests),
            'admit_reason' => $this->admit_reason->toArray($compact),
        ], $compact);
    }


    /**
     * Add request to an order
     *
     * @param Request|array $request
     * @return $this
     */
    public function addRequest(Request|array $request = new Request()): self
    {
        if (is_array($request)) $request = new Request(...$request);
        foreach ($this->requests as $r) {
            if ($request->test->code == $r->test->code) {
                return $this;
            }
        }
        $this->requests[] = $request;
        return $this;
    }


    /**
     * Filter out unwanted testcodes and their observations/specimens
     *
     * @param array|string $filter
     * @return $this
     */
    public function filterTestCodes(array|string $filter): self
    {
        if (is_string($filter)) $filter = [$filter];
        foreach ($this->requests as $k => $request) {
            if (in_array($request->test->code, $filter)) {
                unset($this->requests[$k]);
            } else {
                //also remove from observations
                foreach ($request->observations as $k2 => $obs) {
                    if (in_array($obs->test->code, $filter)) {
                        unset($this->requests[$k]->observations[$k2]);
                    }
                }
                $this->requests[$k]->observations = array_values($this->requests[$k]->observations);
                // also remove from specimens
                foreach ($request->specimens as $k3 => $spec) {
                    if (in_array($spec->test->code, $filter)) {
                        unset($this->requests[$k]->specimens[$k3]);
                    }
                }
                $this->requests[$k]->specimens = array_values($this->requests[$k]->specimens);
            }
        }
        $this->requests = array_values($this->requests);
        return $this;
    }


    /**
     * Give all requested testcodes
     *
     * @param string|array $filter
     * @return array
     */
    public function getRequestedTestcodes(string|array $filter = []): array
    {
        if (is_string($filter)) $filter = [$filter];
        $testcodes = [];
        foreach ($this->requests as $request) {
            if (!in_array($request->test->code, $filter)) {
                $testcodes[] = $request->test->code;
            }

        }
        return $testcodes;
    }

    /**
     * Get observation by testcode
     *
     * @param string $test_code
     * @return Observation|null
     */
    public function getObservationByTestcode(string $test_code): ?Observation
    {
        foreach ($this->requests as $request) {
            foreach ($request->observations as $observation) {
                if ($observation->test->code == $test_code) {
                    return $observation;
                }
            }
        }
        return null;
    }

    /**
     * Get specimen by testcode
     *
     * @param string $test_code
     * @return Specimen|null
     */
    public function getSpecimenByTestcode(string $test_code): ?Specimen
    {
        foreach ($this->requests as $request) {
            foreach ($request->specimens as $specimen) {
                if ($specimen->test->code == $test_code) {
                    return $specimen;
                }
            }
        }
        return null;
    }

    /**
     * Give all observations as testcode=>value array
     *
     * @param string|array $filter
     * @return array
     */
    public function getAllObservations(string|array $filter = []): array
    {
        if (is_string($filter)) $filter = [$filter];
        $observations = [];
        foreach ($this->requests as $request) {
            foreach ($request->observations as $observation) {
                if (!in_array($observation->test->code, $filter)) {
                    $observations[$observation->test->code] = $observation->value;
                }
            }
        }
        return $observations;
    }

    /**
     * Remove all observations from all requests
     *
     * @return $this
     */
    public function removeAllObservations(): self
    {
        foreach ($this->requests as $k => $request) {
            $this->requests[$k]->observations = [];
        }
        return $this;
    }

    /**
     * Add observation to all requests or to a specific testcode request
     *
     * @param Observation $observation
     * @param string $to 'all' or specific request testcode
     * @return $this
     */
    public function addObservation(Observation $observation, string $to = 'all'): self
    {
        if ($to == 'all') {
            foreach ($this->requests as $k => $request) {
                $this->requests[$k]->addObservation($observation);
            }
        } else {
            foreach ($this->requests as $k => $request) {
                if ($request->test->code == $to) {
                    $this->requests[$k]->addObservation($observation);
                }
            }
        }
        return $this;
    }

    //backwards compatibility
    public function fromArray(array $data): Order
    {
        return new Order(...$data);
    }

    /**
     * @param array|Testcode $admit_reason
     * @return $this
     */
    public function setAdmitReason(array|Testcode $admit_reason): self
    {
        if (is_array($admit_reason)) {
            $admit_reason = new Testcode(...$admit_reason);
        }
        $this->admit_reason = $admit_reason;
        return $this;
    }

    /**
     * Check if order has requests
     *
     * @return bool
     */
    public function hasRequests(): bool
    {
        return !empty($this->requests);
    }

    public function getRequestByTestcode(string $testcode): ?Request
    {
        foreach ($this->requests as $request) {
            if ($request->test->code == $testcode) {
                return $request;
            }
        }
        return null;
    }

    /**
     * Count requests
     *
     * @return int
     */
    public function countRequests(): int
    {
        return count($this->requests);
    }
}