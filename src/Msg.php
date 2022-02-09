<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;

class Msg implements RepositoryInterface
{
    use HasCommentsTrait;

    public function __construct(
        public Patient $patient = new Patient,
        public Order   $order = new Order,
        public Contact $sender = new Contact(),
        public Contact $receiver = new Contact(),
        public Carbon  $datetime = new Carbon,
        public MsgType $msgType = new MsgType,
        public string  $id = "",
        public string  $security_id = "",
        public string  $processing_id = "",
        public array   $comments = [],
    )
    {
    }

    public function toArray(): array
    {
        return [
            'patient' => $this->patient->toArray(),
            'order' => $this->order->toArray(),
            'sender' => $this->sender->toArray(),
            'receiver' => $this->receiver->toArray(),
            'datetime' => $this->datetime->format('Y-m-d H:i:s'),
            'msgType' => $this->msgType->toArray(),
            'id' => $this->id,
            'security_id' => $this->security_id,
            'processing_id' => $this->processing_id,
            'comments' => $this->comments,
        ];
    }

    public function setPatient(Patient $patient): self
    {
        $this->patient = $patient;
        return $this;
    }

    public function setOrder(Order $order): self
    {
        $this->order = $order;
        return $this;
    }

    public function setSender(Contact $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function setReceiver(Contact $receiver): self
    {
        $this->receiver = $receiver;
        return $this;
    }

    public function setMsgType(MsgType $msgType): self
    {
        $this->msgType = $msgType;
        return $this;
    }
}