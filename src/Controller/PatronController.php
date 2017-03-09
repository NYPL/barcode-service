<?php
namespace NYPL\Services\Controller;

use NYPL\Starter\Controller;
use NYPL\Starter\Filter;
use NYPL\Services\Model\DataModel\BasePatron\Patron;
use Zend\Barcode\Barcode;

final class PatronController extends Controller
{
    const BARCODE_PREFIX = 'A';
    const BARCODE_SUFFIX = 'B';

    /**
     * @param string $id
     *
     * @return Patron
     */
    protected function getPatron($id = '')
    {
        $patron = new Patron();

        $filter = new Filter();
        $filter->setId($id);

        $patron->addFilter($filter);

        $patron->read();

        return $patron;
    }

    /**
     * @param Patron $patron
     *
     * @return \Zend\Barcode\Renderer\RendererInterface
     */
    protected function getBarcodeRenderer(Patron $patron)
    {
        $barcodeRenderer = Barcode::factory(
            'codabar',
            'image'
        );

        $barcodeRenderer->getBarcode()->setText(
            self::BARCODE_PREFIX .
            $patron->getPrimaryBarcode() .
            self::BARCODE_SUFFIX
        );

        $barcodeRenderer->getBarcode()->setDrawText(false);

        if ($height = $this->getRequest()->getQueryParam('height')) {
            $barcodeRenderer->getBarcode()->setBarHeight($height);
        }

        return $barcodeRenderer;
    }

    /**
     * @param Patron $patron
     *
     * @return string
     */
    protected function getBarcodeAsText(Patron $patron)
    {
        return base64_encode(
            $this->bufferOutput(function () use ($patron) {
                imagepng($this->getBarcodeRenderer($patron)->draw());
            })
        );
    }

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
        $this->checkAccess($id);

        return $this->getBarcodeAsText($this->getPatron($id));
    }
}
