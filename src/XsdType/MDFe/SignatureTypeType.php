<?php

namespace NFePHP\MDFe\XsdType\MDFe;

/**
 * Class representing SignatureTypeType
 *
 *
 * XSD Type: SignatureType
 */
class SignatureTypeType
{

    /**
     * @property string $Id
     */
    private $Id = null;

    /**
     * @property \NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType $SignedInfo
     */
    private $SignedInfo = null;

    /**
     * @property \NFePHP\MDFe\XsdType\MDFe\SignatureValueTypeType $SignatureValue
     */
    private $SignatureValue = null;

    /**
     * @property \NFePHP\MDFe\XsdType\MDFe\KeyInfoTypeType $KeyInfo
     */
    private $KeyInfo = null;

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
     * Gets as SignedInfo
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType
     */
    public function getSignedInfo()
    {
        return $this->SignedInfo;
    }

    /**
     * Sets a new SignedInfo
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType $SignedInfo
     * @return self
     */
    public function setSignedInfo(\NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType $SignedInfo)
    {
        $this->SignedInfo = $SignedInfo;
        return $this;
    }

    /**
     * Gets as SignatureValue
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\SignatureValueTypeType
     */
    public function getSignatureValue()
    {
        return $this->SignatureValue;
    }

    /**
     * Sets a new SignatureValue
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\SignatureValueTypeType $SignatureValue
     * @return self
     */
    public function setSignatureValue(\NFePHP\MDFe\XsdType\MDFe\SignatureValueTypeType $SignatureValue)
    {
        $this->SignatureValue = $SignatureValue;
        return $this;
    }

    /**
     * Gets as KeyInfo
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\KeyInfoTypeType
     */
    public function getKeyInfo()
    {
        return $this->KeyInfo;
    }

    /**
     * Sets a new KeyInfo
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\KeyInfoTypeType $KeyInfo
     * @return self
     */
    public function setKeyInfo(\NFePHP\MDFe\XsdType\MDFe\KeyInfoTypeType $KeyInfo)
    {
        $this->KeyInfo = $KeyInfo;
        return $this;
    }
}
