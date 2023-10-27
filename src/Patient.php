<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;
use mmerlijn\msgRepo\Enums\PatientSexEnum;

class Patient implements RepositoryInterface
{

    use HasAddressTrait, HasNameTrait, CompactTrait;


    /**
     * @param PatientSexEnum|string $sex
     * @param Name|array $name
     * @param Carbon|string|null $dob
     * @param string $bsn
     * @param Address|array $address
     * @param Address|array|null $address2
     * @param array|null $phones
     * @param Insurance|array|null $insurance
     * @param array|null $ids
     * @param string|null $last_requester
     * @param string|null $email
     */
    public function __construct(
        public PatientSexEnum|string $sex = PatientSexEnum::EMPTY,
        public Name|array            $name = new Name,
        public Carbon|string|null    $dob = null,
        public string                $bsn = "",
        public Address|array         $address = new Address,
        public Address|array|null    $address2 = null,
        public ?array                $phones = [],
        public Insurance|array|null  $insurance = null,
        public ?array                $ids = [],
        public ?string               $last_requester = null,
        public ?string               $email = null,
    )
    {
        if (is_string($sex)) $this->sex = PatientSexEnum::set($sex);
        if (is_string($dob)) $this->dob = Carbon::create($dob);
        if (is_array($name)) $this->name = new Name(...$name);
        if (is_array($address)) $this->address = new Address(...$address);
        if (is_array($address2)) $this->address2 = new Address(...$address2);
        if (is_array($insurance)) $this->insurance = new Insurance(...$insurance);
        $this->ids = [];
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $this->addId(new Id(...$id));
            }
        }
        if ($bsn) $this->setBsn($bsn);
        $this->phones = [];
        if (is_array($phones)) {
            foreach ($phones as $phone) {
                $this->addPhone($phone);
            }
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
            'sex' => $this->sex->value,
            'name' => $this->name->toArray($compact),
            'dob' => $this->dob?->format('Y-m-d'),
            'bsn' => $this->bsn,
            'address' => $this->address->toArray($compact),
            'address2' => $this->address2?->toArray($compact),
            'insurance' => $this->insurance?->toArray($compact),
            'last_requester' => $this->last_requester ?? "",
            'email' => $this->email,
            'phones' => array_map(fn($value) => $value->number, $this->phones),
            'ids' => array_map(fn($value) => $value->toArray($compact), $this->ids),
        ], $compact);
    }

    //backwards compatibility
    public function fromArray(array $data): self
    {
        return new Patient(...$data);
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
            $this->addId(new Id(id: $bsn, authority: "NLMINBIZA", type: 'bsn'));
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
        if (is_string($phone)) $phone = new Phone($phone);
        if (!$this->phoneExist($phone->number)) {
            $this->phones[] = $phone;
        }
        return $this;
    }


    /**
     * check for dubbel phone numbers in phone array
     *
     * @param string $value
     * @return bool
     */
    private function phoneExist(string $value): bool
    {
        if (!$value) {
            return true;
        }
        foreach ($this->phones as $p) {
            if (str_replace([" ", '-', '(0)', '.'], "", $p->number) == str_replace([" ", '-', '(0)', '.'], "", $value))
                return true;
        }
        return false;
    }


    /**
     * set insurance to patient object
     * @param array|Insurance $insurance
     * @return $this
     */
    public function setInsurance(array|Insurance $insurance = new Insurance()): self
    {
        if (is_array($insurance)) $insurance = new Insurance(...$insurance);
        $this->insurance = $insurance;
        return $this;
    }


    /**
     * set second address for patient
     *
     * @param array|Address $address
     * @return $this
     */
    public function setAddress2(array|Address $address = new Address()): self
    {
        if (is_array($address)) $address = new Address(...$address);
        $this->address2 = $address;
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
        if (is_string($dob)) $dob = Carbon::create($dob);
        $this->dob = $dob;
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
        if (is_string($sex)) $sex = PatientSexEnum::set($sex);
        $this->sex = $sex;
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