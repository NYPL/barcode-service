<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;
use NYPL\Starter\Model\LocalDateTime;
use NYPL\Starter\Model\ModelTrait\TranslateTrait;

abstract class BasePatron extends DataModel
{
    use TranslateTrait;

    /**
     * @SWG\Property(example="5852922")
     * @var string
     */
    public $id;

    /**
     * @SWG\Property(example="2016-01-07T02:32:51Z", type="string")
     * @var LocalDateTime
     */
    public $updatedDate;

    /**
     * @SWG\Property(example="2008-12-24T03:16:00Z", type="string")
     * @var LocalDateTime
     */
    public $createdDate;

    /**
     * @SWG\Property(example="2008-12-24", type="string")
     * @var LocalDateTime
     */
    public $deletedDate;

    /**
     * @SWG\Property(example=false)
     * @var bool
     */
    public $deleted;

    /**
     * @SWG\Property(example=false)
     * @var bool
     */
    public $suppressed;

    /**
     * @SWG\Property()
     * @var string[]
     */
    public $names;

    /**
     * @SWG\Property()
     * @var string[]
     */
    public $barCodes = [];

    /**
     * @SWG\Property(example="2017-08-20", type="string")
     * @var LocalDateTime
     */
    public $expirationDate;

    /**
     * @SWG\Property(example="lb", type="string")
     * @var string
     */
    public $homeLibraryCode;

    /**
     * @SWG\Property(example="1978-10-15", type="string")
     * @var LocalDateTime
     */
    public $birthDate;

    /**
     * @SWG\Property()
     * @var string[]
     */
    public $emails;

    /**
     * @SWG\Property()
     * @var FixedField[]
     */
    public $fixedFields;

    /**
     * @SWG\Property()
     * @var VarField[]
     */
    public $varFields;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = (string) $id;
    }

    /**
     * @return LocalDateTime
     */
    public function getUpdatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * @param LocalDateTime $updatedDate
     */
    public function setUpdatedDate(LocalDateTime $updatedDate)
    {
        $this->updatedDate = $updatedDate;
    }

    /**
     * @param string $updatedDate
     *
     * @return LocalDateTime
     */
    public function translateUpdatedDate($updatedDate = '')
    {
        return new LocalDateTime(LocalDateTime::FORMAT_DATE_TIME_RFC, $updatedDate);
    }

    /**
     * @return LocalDateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @param LocalDateTime $createdDate
     */
    public function setCreatedDate(LocalDateTime $createdDate)
    {
        $this->createdDate = $createdDate;
    }

    /**
     * @param string $createdDate
     *
     * @return LocalDateTime
     */
    public function translateCreatedDate($createdDate = '')
    {
        return new LocalDateTime(LocalDateTime::FORMAT_DATE_TIME_RFC, $createdDate);
    }

    /**
     * @return LocalDateTime
     */
    public function getDeletedDate()
    {
        return $this->deletedDate;
    }

    /**
     * @param LocalDateTime $deletedDate
     */
    public function setDeletedDate($deletedDate)
    {
        $this->deletedDate = $deletedDate;
    }

    /**
     * @param string $deletedDate
     *
     * @return LocalDateTime
     */
    public function translateDeletedDate($deletedDate = '')
    {
        return new LocalDateTime(LocalDateTime::FORMAT_DATE, $deletedDate);
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = boolval($deleted);
    }

    /**
     * @return boolean
     */
    public function isSuppressed()
    {
        return $this->suppressed;
    }

    /**
     * @param boolean $suppressed
     */
    public function setSuppressed($suppressed)
    {
        $this->suppressed = boolval($suppressed);
    }

    /**
     * @return \string[]
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * @param \string[] $names
     */
    public function setNames($names)
    {
        if (is_string($names)) {
            $names = json_decode($names, true);
        }

        $this->names = $names;
    }

    /**
     * @return \string[]
     */
    public function getBarCodes()
    {
        return $this->barCodes;
    }

    /**
     * @param \string[] $barCodes
     */
    public function setBarCodes($barCodes)
    {
        if (is_string($barCodes)) {
            $barCodes = json_decode($barCodes, true);
        }

        $this->barCodes = $barCodes;
    }

    /**
     * @return LocalDateTime
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param LocalDateTime $expirationDate
     */
    public function setExpirationDate($expirationDate)
    {
        $this->expirationDate = $expirationDate;
    }

    /**
     * @param string $expirationDate
     *
     * @return LocalDateTime
     */
    public function translateExpirationDate($expirationDate = '')
    {
        return new LocalDateTime(LocalDateTime::FORMAT_DATE, $expirationDate);
    }

    /**
     * @return LocalDateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param LocalDateTime $birthDate
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @param string $birthDate
     *
     * @return LocalDateTime
     */
    public function translateBirthDate($birthDate = '')
    {
        return new LocalDateTime(LocalDateTime::FORMAT_DATE, $birthDate);
    }

    /**
     * @return \string[]
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @param \string[] $emails
     */
    public function setEmails($emails)
    {
        if (is_string($emails)) {
            $emails = json_decode($emails, true);
        }

        $this->emails = $emails;
    }

    /**
     * @return string
     */
    public function getHomeLibraryCode()
    {
        return $this->homeLibraryCode;
    }

    /**
     * @param string $homeLibraryCode
     */
    public function setHomeLibraryCode($homeLibraryCode)
    {
        $this->homeLibraryCode = $homeLibraryCode;
    }

    /**
     * @return FixedField[]
     */
    public function getFixedFields()
    {
        return $this->fixedFields;
    }

    /**
     * @param FixedField[] $fixedFields
     */
    public function setFixedFields($fixedFields)
    {
        $this->fixedFields = $fixedFields;
    }

    /**
     * @param array|string $data
     *
     * @return FixedField[]
     */
    public function translateFixedFields($data)
    {
        return $this->translateArray($data, new FixedField(), true);
    }

    /**
     * @return VarField[]
     */
    public function getVarFields()
    {
        return $this->varFields;
    }

    /**
     * @param VarField[] $varFields
     */
    public function setVarFields($varFields)
    {
        $this->varFields = $varFields;
    }

    /**
     * @param array|string $data
     *
     * @return VarField[]
     */
    public function translateVarFields($data)
    {
        return $this->translateArray($data, new VarField(), true);
    }

    /**
     * @return string
     */
    public function getPrimaryBarcode()
    {
        return (string) current($this->getBarCodes());
    }

    /**
     * @return string
     */
    public function getPrimaryName()
    {
        return (string) current($this->getNames());
    }

    /**
     * @return bool
     */
    public function isTemporary()
    {
        return strlen($this->getPrimaryBarcode()) > 10;
    }
}
