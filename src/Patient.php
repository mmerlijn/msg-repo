<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;

class Patient implements RepositoryInterface
{
    use HasAddressTrait, HasNameTrait;

    public function __construct(
        public string     $sex = "",
        public Name       $name = new Name,
        public ?Carbon    $dob = null,
        public string     $bsn = "",
        public Address    $address = new Address,
        public ?Address   $address2 = null,
        public array      $phones = [],
        public ?Insurance $insurance = null,
        public array      $ids = [],
    )
    {
    }

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
            'sex' => $this->sex,
            'name' => $this->name->toArray(),
            'dob' => $this->dob?->format('Y-m-d'),
            'bsn' => $this->bsn,
            'address' => $this->address->toArray(),
            'address2' => $this->address2?->toArray(),
            'phones' => $phone_array,
            'insurance' => $this->insurance?->toArray(),
            'ids' => $ids_array,
        ];
    }

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
        return $this;
    }

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

    public function setBsn($bsn): self
    {
        $this->addId(new Id(id: $bsn, type: 'bsn'));
        $this->bsn = $bsn;
        return $this;
    }

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

    private function phoneExist($value): bool
    {
        foreach ($this->phones as $p) {
            if ($p->number == $value)
                return true;
        }
        return false;
    }

    public function setInsurance(Insurance $insurance): self
    {
        $this->insurance = $insurance;
        return $this;
    }

    public function setAddress2(Address $address): self
    {
        $this->address2 = $address;
        return $this;
    }

    public function setDob(string|Carbon $dob): self
    {
        if (gettype($dob) == "string") {
            $this->dob = Carbon::create($dob);
        } else {
            $this->dob = $dob;
        }
        return $this;
    }
}