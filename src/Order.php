<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;

class Order
{
    use HasCommentsTrait;

    public function __construct(

        public string    $control = "NW", //NW=new, CA=Cancel
        public string    $request_nr = "",
        public string    $lab_nr = "",
        public bool      $complet = true,
        public ?Carbon   $request_date = null,
        public bool      $priority = false,
        public string    $order_status = "",
        public string    $result_status = "", //F=final, C=correction
        public string    $action_code = "",//at home => L, else O
        public Requester $requester = new Requester,
        public Requester $copy_to = new Requester,
        public array     $comments = [],
        public array     $orderItems = [],
    )
    {
    }

    public function addItem(OrderItem $orderItem): self
    {
        $this->orderItems[] = $orderItem;
        return $this;
    }

    public function toArray(): array
    {
        $orderItems = [];
        foreach ($this->orderItems as $orderItem) {
            $orderItems[] = $orderItem->toArray();
        }
        return [

            'control' => $this->control,
            'request_nr' => $this->request_nr,
            'lab_nr' => $this->lab_nr,
            'complet' => $this->complet,
            'request_date' => $this->request_date,
            'priority' => $this->priority,
            'order_status' => $this->order_status,
            'result_status' => $this->result_status,
            'action_code' => $this->action_code,
            'requester' => $this->requester->toArray(),
            'copy_to' => $this->copy_to->toArray(),
            'comments' => $this->comments,
            'orderItems' => $orderItems,
        ];
    }
}