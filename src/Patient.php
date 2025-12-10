<?php

namespace mmerlijn\msgRepo;

use Carbon\Carbon;
use mmerlijn\msgRepo\Enums\PatientSexEnum;
use mmerlijn\msgRepo\Helpers\AgbcodeValidator;

class Patient implements RepositoryInterface
{

    use HasAddressTrait, HasNameTrait, CompactTrait, HasDateTrait, HasCommentsTrait;


    /**
     * @param PatientSexEnum|string $sex
     * @param Name|array $name
     * @param Carbon|string|null $dob
     * @param string $bsn
     * @param Address|array $address
     * @param Address|array|null $address2
     * @param array|null $phones
     * @param Insurance|array $insurance
     * @param array|null $ids
     * @param string|null $last_requester
     * @param string|null $email
     * @param string|null $last_organisation
     * @param array $comments
     */
    public function __construct(
        public PatientSexEnum|string $sex = PatientSexEnum::EMPTY,
        public Name|array            $name = new Name,
        public Carbon|string|null    $dob = null,
        public string                $bsn = "",
        public Address|array         $address = new Address,
        public Address|array|null    $address2 = null,
        public ?array                $phones = [],
        public Insurance|array       $insurance = new Insurance,
        public ?array                $ids = [],
        public ?string               $last_requester = null,
        public ?string               $email = null,
        public ?string               $last_organisation = null,
        public array                 $comments = [],
    )
    {
        $this->sex = PatientSexEnum::set($sex);
        $this->dob = $this->formatDate($dob);
        $this->setName($name);
        $this->setAddress($address);
        if (is_array($address2)) $this->address2 = new Address(...$address2);
        $this->setInsurance($insurance);
        $this->ids = [];
        if (is_array($ids)) {
            foreach ($ids as $id) {
                if (is_array($id)) {
                    $this->addId(new Id(...$id));
                    continue;
                }
                if ($id instanceof Id) {
                    $this->addId($id);
                }
            }
        }
        if ($bsn) $this->setBsn($bsn);
        $this->phones = [];
        if (is_array($phones)) {
            foreach ($phones as $phone) {
                $this->addPhone($phone);
            }
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = null;
        }
        $this->comments = [];
        foreach ($comments as $comment) {
            $this->addComment($comment);
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
            'phones' => array_map(fn($value) => $value->number, $this->phones),
            'insurance' => $this->insurance->toArray($compact),
            'ids' => array_map(fn($value) => $value->toArray($compact), $this->ids),
            'last_requester' => $this->last_requester ?? "",
            'email' => $this->email,
            'last_organisation' => $this->last_organisation ?? "",
            'comments' => array_map(fn($value) => $value->toArray($compact), $this->comments),

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
            if (($v->type == $id->type and $v->type) or $v->authority == $id->authority or $v->code == $id->code) {
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

    public function removeIdByAuthority(string $authority): self
    {
        foreach ($this->ids as $k => $v) {
            if ($v->authority == $authority) {
                unset($this->ids[$k]);
            }
        }
        $this->ids = array_values($this->ids); //reindex array
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

    public function getPhone(): string
    {
        return $this->phones[0]->number ?? "";
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
     * @param PatientSexEnum|string $sex
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
    private function setBsnFirst(): void
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
    public function hasValidBsn(): bool
    {
        return AgbcodeValidator::validate($this->getBsn());
    }

    public function hasData():bool
    {
        return $this->name->hasData() ||
            $this->dob ||
            $this->bsn ||
            $this->address->hasData() ||
            !empty($this->ids);
    }
}