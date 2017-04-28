<?php
namespace NYPL\Services\Model\Response\SuccessResponse;

use NYPL\Services\Model\DataModel\PatronBarcode;
use NYPL\Starter\Model\Response\SuccessResponse;

/**
 * @SWG\Definition(title="BarcodeResponse", type="object")
 */
class BarcodeResponse extends SuccessResponse
{
    /**
     * @SWG\Property
     * @var PatronBarcode
     */
    public $data;
}
