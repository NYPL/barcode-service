<?php
namespace NYPL\Services\Model\DataModel\BasePatron;

use NYPL\Services\Model\DataModel\BasePatron;
use NYPL\Starter\Model\ModelInterface\ReadInterface;
use NYPL\Starter\Model\ModelTrait\SierraTrait\SierraReadTrait;

/**
 * @SWG\Definition(title="Patron", type="object", required={"id"})
 */
class Patron extends BasePatron implements ReadInterface
{
    const FIELDS = "id,updatedDate,createdDate,deletedDate,deleted,suppressed,names,barcodes,expirationDate,birthDate,emails,patronType,patronCodes,homeLibraryCode,message,blockInfo,addresses,phones,moneyOwed,fixedFields,varFields";

    use SierraReadTrait;

    /**
     * @param string|null $id
     *
     * @return string
     */
    public function getSierraPath($id = null)
    {
        return "patrons/{$this->getSierraId($id)}?" . http_build_query(["fields" => self::FIELDS]);
    }

    public function getIdFields()
    {
        return ["id"];
    }
}
