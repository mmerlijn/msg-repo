<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;
use mmerlijn\msgRepo\Enums\OrderControlEnum;
use mmerlijn\msgRepo\Enums\OrderStatusEnum;
use mmerlijn\msgRepo\Enums\OrderWhereEnum;

class Order implements RepositoryInterface
{

    use HasCommentsTrait, CompactTrait, HasResultsTrait, HasOrganisationTrait, HasDateTrait;

    /**
     * @param string|OrderControlEnum $control N=new, C=Cancel
     * @param string $request_nr
     * @param string|int $lab_nr
     * @param bool $complete
     * @param bool $priority
     * @param Carbon|string|null $start_date
     * @param string|OrderStatusEnum $order_status
     * @param string|OrderWhereEnum $where home , other
     * @param array|Contact $requester
     * @param array|Contact $copy_to
     * @param array|Contact $entered_by
     * @param array|Organisation $organisation
     * @param Carbon|string|null $dt_of_request dt of execution time
     * @param Carbon|string|null $dt_of_observation
     * @param Carbon|string|null $dt_of_observation_end
     * @param Carbon|string|null $dt_of_analysis
     * @param string $admit_reason_code
     * @param string $admit_reason_name
     * @param array $results array if Results
     * @param array $requests array of Requests
     * @param array $comments array of strings
     */
    public function __construct(
        public string|OrderControlEnum $control = OrderControlEnum::NEW,
        public string                  $request_nr = "", //AB12341234
        public string|int              $lab_nr = "", //internal processing nr
        public bool                    $complete = true,
        public bool                    $priority = false,
        public Carbon|string|null      $start_date = null,
        public string|OrderStatusEnum  $order_status = OrderStatusEnum::FINAL,
        public string|OrderWhereEnum   $where = OrderWhereEnum::EMPTY,
        public array|Contact           $requester = new Contact,
        public array|Contact           $copy_to = new Contact,
        public array|Contact           $entered_by = new Contact,
        public array|Organisation      $organisation = new Organisation,
        public Carbon|string|null      $dt_of_request = null,
        public Carbon|string|null      $dt_of_observation = null,
        public Carbon|string|null      $dt_of_observation_end = null,
        public Carbon|string|null      $dt_of_analysis = null,
        public array                   $results = [],
        public array                   $requests = [],
        public array                   $comments = [],
        public array|Testcode          $admit_reason = new TestCode,
    )
    {
        if (is_array($requester)) $this->requester = new Contact(...$requester);
        if (is_array($copy_to)) $this->copy_to = new Contact(...$copy_to);
        if (is_array($entered_by)) $this->entered_by = new Contact(...$entered_by);
        $this->setOrganisation($organisation);
        $this->start_date = $this->formatDate($start_date);
        $this->dt_of_request = $this->formatDate($dt_of_request);
        $this->dt_of_observation = $this->formatDate($dt_of_observation);
        $this->dt_of_observation_end = $this->formatDate($dt_of_observation_end);
        $this->dt_of_analysis = $this->formatDate($dt_of_analysis);
        $this->order_status = OrderStatusEnum::set($order_status);
        $this->where = OrderWhereEnum::set($where);
        $this->control = OrderControlEnum::set($control);
        $this->results = [];
        foreach ($results as $result) {
            $this->addResult($result);
        }
        $this->requests = [];
        foreach ($requests as $request) {
            $this->addRequest($request);
        }
        $this->comments =[];
        foreach ($comments as $comment) {
            $this->addComment($comment);
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
            //'result_status' => $this->result_status,
            'where' => $this->where->value,
            'requester' => $this->requester->toArray($compact),
            'copy_to' => $this->copy_to->toArray($compact),
            'entered_by' => $this->entered_by->toArray($compact),
            'organisation' => $this->organisation->toArray($compact),
            //'material' => $this->material,
            //'volume' => $this->volume,
            'dt_of_request' => $this->dt_of_request?->format("Y-m-d H:i:s"),
            'dt_of_observation' => $this->dt_of_observation?->format("Y-m-d H:i:s"),
            'dt_of_observation_end' => $this->dt_of_observation_end?->format("Y-m-d H:i:s"),
            'dt_of_analysis' => $this->dt_of_analysis?->format("Y-m-d H:i:s"),
            'results' => array_map(fn($value) => $value->toArray($compact), $this->results),
            'requests' => array_map(fn($value) => $value->toArray($compact), $this->requests),
            'comments' => array_map(fn($value) => $value->toArray($compact), $this->comments),
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
     * Filter out unwanted testcodes
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
            }
        }

        foreach ($this->results as $k => $result) {
            if (in_array($result->test->code, $filter)) {
                unset($this->results[$k]);
            }
        }
        $this->results = array_values($this->results);
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

    public function getResultByTestcode(string $test_code): ?Result
    {
        foreach ($this->results as $result) {
            if ($result->test->code == $test_code) {
                return $result;
            }
        }
        return null;
    }




    //backwards compatibility
    public function fromArray(array $data): Order
    {
        return new Order(...$data);
    }

    public function setAdmitReason(array|Testcode $admit_reason): self
    {
        if (is_array($admit_reason)) {
            $admit_reason = new Testcode(...$admit_reason);
        }
        $this->admit_reason = $admit_reason;
        return $this;
    }

    public function hasRequests(): bool
    {
        return !empty($this->requests);
    }
}