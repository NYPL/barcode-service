<?php
namespace NYPL\Services\Controller;

use NYPL\Starter\APIException;
use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Services\Model\DataModel\BasePatron\Patron;
use Zend\Barcode\Barcode;

final class PatronController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/v0.1/patrons/{id}/barcode",
     *     summary="Get a Patron's barcode in Base64 encoded PNG format",
     *     tags={"patrons"},
     *     operationId="getBarcode",
     *     consumes={"application/json"},
     *     produces={"text/plain"},
     *     @SWG\Parameter(
     *         description="ID of Patron",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="string",
     *         format="string"
     *     ),
     *     @SWG\Parameter(
     *         in="query",
     *         name="height",
     *         required=false,
     *         type="integer"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Not found",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     @SWG\Response(
     *         response="500",
     *         description="Generic server error",
     *         @SWG\Schema(ref="#/definitions/ErrorResponse")
     *     ),
     *     security={
     *         {
     *             "api_auth": {"openid offline_access api"}
     *         }
     *     }
     * )
     */
    public function getBarcode($id)
    {
        if ($this->getIdentity()->getSubject() != $id) {
            throw new APIException('You are not authorized to access this barcode', null, null, null, 403);
        }

        $patron = new Patron();

        $filter = new Filter();
        $filter->setId($id);

        $patron->addFilter($filter);

        $patron->read();


        $barcodeOptions = [];
        $rendererOptions = [];

        $barcode = Barcode::factory(
            'codabar',
            'image',
            $barcodeOptions,
            $rendererOptions
        );

        $barcode->getBarcode()->setText(current($patron->getBarCodes()));
        $barcode->getBarcode()->setDrawText(false);

        if ($height = $this->getRequest()->getQueryParam('height')) {
            $barcode->getBarcode()->setBarHeight($height);
        }

        $imageResource = $barcode->draw();

        ob_start();
        imagepng($imageResource);
        $imageData = base64_encode(ob_get_contents());
        ob_end_clean();

        return $imageData;
    }
}
