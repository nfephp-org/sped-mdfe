<?php

namespace NFePHP\MDFe\XsdType\MDFe;

use NFePHP\MDFe\XsdType\MDFe\ReferenceTypeType\DigestMethodType;

/**
 * Class representing ReferenceTypeType
 *
 *
 * XSD Type: ReferenceType
 */
class ReferenceTypeType
{

    /**
     * @property string $Id
     */
    private $Id = null;

    /**
     * @property string $URI
     */
    private $URI = null;

    /**
     * @property string $Type
     */
    private $Type = null;

    /**
     * @property \NFePHP\MDFe\XsdType\MDFe\TransformTypeType[] $Transforms
     */
    private $Transforms = null;

    /**
     * @property DigestMethodType
     * $DigestMethod
     */
    private $DigestMethod = null;

    /**
     * @property mixed $DigestValue
     */
    private $DigestValue = null;

    /**
     * Gets as Id
     *
     * @return string
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * Sets a new Id
     *
     * @param string $Id
     * @return self
     */
    public function setId($Id)
    {
        $this->Id = $Id;
        return $this;
    }

    /**
     * Gets as URI
     *
     * @return string
     */
    public function getURI()
    {
        return $this->URI;
    }

    /**
     * Sets a new URI
     *
     * @param string $URI
     * @return self
     */
    public function setURI($URI)
    {
        $this->URI = $URI;
        return $this;
    }

    /**
     * Gets as Type
     *
     * @return string
     */
    public function getType()
    {
        return $this->Type;
    }

    /**
     * Sets a new Type
     *
     * @param string $Type
     * @return self
     */
    public function setType($Type)
    {
        $this->Type = $Type;
        return $this;
    }

    /**
     * Adds as Transform
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\MDFe\TransformTypeType $Transform
     */
    public function addToTransforms(\NFePHP\MDFe\XsdType\MDFe\TransformTypeType $Transform)
    {
        $this->Transforms[] = $Transform;
        return $this;
    }

    /**
     * isset Transforms
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetTransforms($index)
    {
        return isset($this->Transforms[$index]);
    }

    /**
     * unset Transforms
     *
     * @param scalar $index
     * @return void
     */
    public function unsetTransforms($index)
    {
        unset($this->Transforms[$index]);
    }

    /**
     * Gets as Transforms
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TransformTypeType[]
     */
    public function getTransforms()
    {
        return $this->Transforms;
    }

    /**
     * Sets a new Transforms
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TransformTypeType[] $Transforms
     * @return self
     */
    public function setTransforms(array $Transforms)
    {
        $this->Transforms = $Transforms;
        return $this;
    }

    /**
     * Gets as DigestMethod
     *
     * @return DigestMethodType
     */
    public function getDigestMethod()
    {
        return $this->DigestMethod;
    }

    /**
     * Sets a new DigestMethod
     *
     * @param DigestMethodType $DigestMethod
     * @return self
     */
    public function setDigestMethod(DigestMethodType $DigestMethod)
    {
        $this->DigestMethod = $DigestMethod;
        return $this;
    }

    /**
     * Gets as DigestValue
     *
     * @return mixed
     */
    public function getDigestValue()
    {
        return $this->DigestValue;
    }

    /**
     * Sets a new DigestValue
     *
     * @param mixed $DigestValue
     * @return self
     */
    public function setDigestValue($DigestValue)
    {
        $this->DigestValue = $DigestValue;
        return $this;
    }
}
