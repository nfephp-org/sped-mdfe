<?php

namespace NFePHP\MDFe\XsdType\MDFe;

/**
 * Class representing SignedInfoTypeType
 *
 *
 * XSD Type: SignedInfoType
 */
class SignedInfoTypeType
{

    /**
     * @property string $Id
     */
    private $Id = null;

    /**
     * @property
     * \NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType\CanonicalizationMethodType
     * $CanonicalizationMethod
     */
    private $CanonicalizationMethod = null;

    /**
     * @property \NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType\SignatureMethodType
     * $SignatureMethod
     */
    private $SignatureMethod = null;

    /**
     * @property \NFePHP\MDFe\XsdType\MDFe\ReferenceTypeType $Reference
     */
    private $Reference = null;

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
     * Gets as CanonicalizationMethod
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType\CanonicalizationMethodType
     */
    public function getCanonicalizationMethod()
    {
        return $this->CanonicalizationMethod;
    }

    /**
     * Sets a new CanonicalizationMethod
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType\CanonicalizationMethodType
     * $CanonicalizationMethod
     * @return self
     */
    public function setCanonicalizationMethod(\NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType\CanonicalizationMethodType $CanonicalizationMethod)
    {
        $this->CanonicalizationMethod = $CanonicalizationMethod;
        return $this;
    }

    /**
     * Gets as SignatureMethod
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType\SignatureMethodType
     */
    public function getSignatureMethod()
    {
        return $this->SignatureMethod;
    }

    /**
     * Sets a new SignatureMethod
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType\SignatureMethodType
     * $SignatureMethod
     * @return self
     */
    public function setSignatureMethod(\NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType\SignatureMethodType $SignatureMethod)
    {
        $this->SignatureMethod = $SignatureMethod;
        return $this;
    }

    /**
     * Gets as Reference
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\ReferenceTypeType
     */
    public function getReference()
    {
        return $this->Reference;
    }

    /**
     * Sets a new Reference
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\ReferenceTypeType $Reference
     * @return self
     */
    public function setReference(\NFePHP\MDFe\XsdType\MDFe\ReferenceTypeType $Reference)
    {
        $this->Reference = $Reference;
        return $this;
    }


}

