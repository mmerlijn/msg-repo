<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;
use mmerlijn\msgRepo\Enums\PatientSexEnum;

class Patient implements RepositoryInterface
{

    use HasAddressTrait, HasNameTrait;


    /**
     * @param PatientSexEnum $sex
     * @param Name $name
     * @param Carbon|null $dob
     * @param string $bsn
     * @param Address $address
     * @param Address|null $address2
     * @param array $phones
     * @param Insurance|null $insurance
     * @param array $ids
     * @param string|null $last_requester
     */
    public function __construct(
        public PatientSexEnum $sex = PatientSexEnum::EMPTY,
        public Name           $name = new Name,
        public ?Carbon        $dob = null,
        public string         $bsn = "",
        public Address        $address = new Address,
        public ?Address       $address2 = null,
        public array          $phones = [],
        public ?Insurance     $insurance = null,
        public array          $ids = [],
        public ?string        $last_requester = null,
    )
    {
    }

    /**
     * Dump state
     *
     * @return array
     */
    public function toArray(): array
    {
        $ids_array = [];
        foreach ($this->ids as $id) {
            $ids_array[] = $id->toArray();
        }
        $phone_array = [];
        foreach ($this->phones as $phone) {
            $phone_array[] = $phone->number;
        }
        return [
            'sex' => $this->sex->value,
            'name' => $this->name->toArray(),
            'dob' => $this->dob?->format('Y-m-d'),
            'bsn' => $this->bsn,
            'address' => $this->address->toArray(),
            'address2' => $this->address2?->toArray(),
            'phones' => $phone_array,
            'insurance' => $this->insurance?->toArray(),
            'ids' => $ids_array,
            'last_requester' => $this->last_requester ?? "",
        ];
    }

    public function fromArray(array $data): self
    {
        $this->setSex($data['sex']);
        $this->setName($data['name']);
        $this->setDob($data['dob']);
        $this->setBsn($data['bsn']);
        $this->setAddress($data['address']);
        if (!empty($data['address2'])) {
            $this->setAddress2($data['address2']);
        }

        foreach ($data['phones'] as $phone) {
            $this->addPhone($phone);
        }
        if (!empty($data['insurance'])) {
            $this->setInsurance($data['insurance']);
        }
        foreach ($data['ids'] as $id) {
            $this->addId(new Id(...$id));
        }
        $this->last_requester = $data['last_requester'];

        return $this;
    }

    /**
     * Add id to objects id array
     * @param Id $id
     * @return $this
     */
    public function addId(Id $id): self
    {
        $overwrite = false;
        foreach ($this->ids as $k => $v) {
            if ($v->type == $id->type or $v->authority == $id->authority or $v->code == $id->code) {
                $this->ids[$k] = $id; //overwrite
                $overwrite = true;
            }
        }
        if (!$overwrite) {
            $this->ids[] = $id;
        }
        $this->setBsnFirst();
        return $this;
    }


    /**
     * Get bsn out of ids
     *
     * @return string
     */
    public function getBsn(): string
    {
        if ($this->bsn) {
            return $this->bsn;
        }
        foreach ($this->ids as $id) {
            if ($id->authority == "NLMINBIZA" or $id->type == 'bsn') {
                return $id->id;
            }
        }
        return "";
    }


    /**
     * add BSN to ids array
     * @param $bsn
     * @return $this
     */
    public function setBsn($bsn): self
    {
        if ($bsn) {
            $this->addId(new Id(id: $bsn, type: 'bsn'));
            $this->bsn = $bsn;
            $this->setBsnFirst();
        }
        return $this;
    }


    /**
     * Add phone number to phones array
     *
     * @param Phone|string $phone
     * @return $this
     */
    public function addPhone(Phone|string $phone): self
    {
        if (gettype($phone) == "string") {
            $phone = new Phone($phone);
        }
        if (!$this->phoneExist($phone->number)) {
            $this->phones[] = $phone;
        }
        return $this;
    }


    /**
     * check for dubbel phone numbers in phone array
     *
     * @param $value
     * @return bool
     */
    private function phoneExist($value): bool
    {
        if (!$value) {
            return true;
        }
        foreach ($this->phones as $p) {
            if ($p->number == $value)
                return true;
        }
        return false;
    }


    /**
     * set insurance to patient object
     * @param Insurance $insurance
     * @return $this
     */
    public function setInsurance(array|Insurance $insurance = new Insurance()): self
    {
        if (gettype($insurance) == 'array') {
            $this->insurance = (new Insurance())->fromArray($insurance);
        } else {
            $this->insurance = $insurance;
        }
        return $this;
    }


    /**
     * set second address for patient
     *
     * @param Address $address
     * @return $this
     */
    public function setAddress2(array|Address $address = new Address()): self
    {
        if (gettype($address) == 'array') {
            $this->address2 = new Address(...$address);
        } else {
            $this->address2 = $address;
        }

        return $this;
    }


    /**
     * set patients dob
     *
     * @param string|Carbon $dob
     * @return $this
     */
    public function setDob(string|Carbon $dob): self
    {
        if ($dob) {
            if (gettype($dob) == "string") {
                $this->dob = Carbon::create($dob);
            } else {
                $this->dob = $dob;
            }
        }
        return $this;
    }

    /**
     * set patient sex
     *
     * @param string $sex
     * @return $this
     */
    public function setSex(PatientSexEnum|string $sex): self
    {
        if (gettype($sex) == "string") {
            $this->sex = PatientSexEnum::set($sex);
        } else {
            $this->sex = $sex;
        }
        return $this;
    }

    /**
     * Internal helper function to set BSN as first ID
     *
     * @return void
     */
    private function setBsnFirst()
    {
        $deleted = false;
        foreach ($this->ids as $k => $id) {
            if ($id->authority == "NLMINBIZA" or $id->type == 'bsn') {
                $this->bsn = $id->id;
                $bsn = $id;
                if ($k != 0) {
                    unset($this->ids[$k]);
                    $deleted = true;
                }
            }
        }
        if ($bsn ?? false and $deleted) {
            array_splice($this->ids, 0, 0, [$bsn]);
        }
    }
}