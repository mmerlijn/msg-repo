<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;

class Msg implements RepositoryInterface
{

    use HasCommentsTrait;

    /**
     * @param Patient $patient
     * @param Order $order
     * @param Contact $sender
     * @param Contact $receiver
     * @param Carbon $datetime
     * @param MsgType $msgType
     * @param string $id
     * @param string $security_id
     * @param string $processing_id
     * @param array $comments
     */
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

    /**
     * dump state
     *
     * @return array
     */
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

    public function fromArray(array $data): self
    {
        $this->setPatient($data['patient']);
        $this->order = (new Order())->fromArray($data['order']);
        $this->sender = (new Contact())->fromArray($data['sender']);
        $this->receiver = (new Contact())->fromArray($data['receiver']);
        $this->datetime = Carbon::create($data['datetime']);
        $this->msgType = new MsgType(...$data['msgType']);
        $this->id = $data['id'];
        $this->security_id = $data['security_id'];
        $this->processing_id = $data['processing_id'];
        $this->comments = $data['comments'];
        return $this;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    public function fromJson(string $json): Msg
    {
        return $this->fromArray(json_decode($json, true));
    }

    /**
     * set patient to msg object
     *
     * @param Patient $patient
     * @return $this
     */
    public function setPatient(array|Patient $patient): self
    {
        if (gettype($patient) == 'array') {
            $this->patient = (new Patient())->fromArray($patient);
        } else {
            $this->patient = $patient;
        }
        return $this;
    }


    /**
     * Set order details to msg object
     *
     * @param Order $order
     * @return $this
     */
    public function setOrder(Order $order): self
    {
        $this->order = $order;
        return $this;
    }


    /**
     * Set the msg sender
     *
     * @param Contact $sender
     * @return $this
     */
    public function setSender(Contact $sender): self
    {
        $this->sender = $sender;
        return $this;
    }


    /**
     * Set the msg receiver
     *
     * @param Contact $receiver
     * @return $this
     */
    public function setReceiver(Contact $receiver): self
    {
        $this->receiver = $receiver;
        return $this;
    }


    /**
     * Set message type
     *
     * @param MsgType $msgType
     * @return $this
     */
    public function setMsgType(MsgType $msgType): self
    {
        $this->msgType = $msgType;
        return $this;
    }
}