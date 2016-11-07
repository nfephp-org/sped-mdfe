<?php

namespace NFePHP\MDFe\XsdType\MDFe;

/**
 * Class representing X509DataTypeType
 *
 *
 * XSD Type: X509DataType
 */
class X509DataTypeType
{

    /**
     * @property mixed $X509Certificate
     */
    private $X509Certificate = null;

    /**
     * Gets as X509Certificate
     *
     * @return mixed
     */
    public function getX509Certificate()
    {
        return $this->X509Certificate;
    }

    /**
     * Sets a new X509Certificate
     *
     * @param mixed $X509Certificate
     * @return self
     */
    public function setX509Certificate($X509Certificate)
    {
        $this->X509Certificate = $X509Certificate;
        return $this;
    }
}
