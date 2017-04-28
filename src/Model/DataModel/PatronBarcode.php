<?php
namespace NYPL\Services\Model\DataModel;

use NYPL\Services\Model\DataModel;

/**
 * @SWG\Definition(title="PatronBarcode", type="object")
 */
class PatronBarcode extends DataModel
{
    /**
     * @SWG\Property(example="25553095887111")
     * @var string
     */
    public $barCode;

    /**
     * @SWG\Property(example="DEWEY, MELVILE")
     * @var string
     */
    public $name;

    /**
     * @SWG\Property(example="iVBORw0KGgoAAAANSUhEUgAAALUAAAAyCAIAAACVhA2eAAAAuUlEQVR4nO3SMQ")
     * @var string
     */
    public $base64PngBarCode;

    /**
     * @SWG\Property(example=false)
     * @var bool
     */
    public $temporary = false;

    /**
     * @return string
     */
    public function getBase64PngBarCode()
    {
        return $this->base64PngBarCode;
    }

    /**
     * @param string $base64PngBarCode
     */
    public function setBase64PngBarCode($base64PngBarCode)
    {
        $this->base64PngBarCode = $base64PngBarCode;
    }

    /**
     * @return string
     */
    public function getBarCode()
    {
        return $this->barCode;
    }

    /**
     * @param string $barCode
     */
    public function setBarCode($barCode)
    {
        $this->barCode = $barCode;
    }

    /**
     * @return bool
     */
    public function isTemporary()
    {
        return $this->temporary;
    }

    /**
     * @param bool $temporary
     */
    public function setTemporary($temporary)
    {
        $this->temporary = (bool) $temporary;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
