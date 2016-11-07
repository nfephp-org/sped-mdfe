<?php

namespace NFePHP\MDFe\XsdType\MDFe;

/**
 * Class representing KeyInfoTypeType
 *
 *
 * XSD Type: KeyInfoType
 */
class KeyInfoTypeType
{

    /**
     * @property string $Id
     */
    private $Id = null;

    /**
     * @property \NFePHP\MDFe\XsdType\MDFe\X509DataTypeType $X509Data
     */
    private $X509Data = null;

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
     * Gets as X509Data
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\X509DataTypeType
     */
    public function getX509Data()
    {
        return $this->X509Data;
    }

    /**
     * Sets a new X509Data
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\X509DataTypeType $X509Data
     * @return self
     */
    public function setX509Data(\NFePHP\MDFe\XsdType\MDFe\X509DataTypeType $X509Data)
    {
        $this->X509Data = $X509Data;
        return $this;
    }
}
