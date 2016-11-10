<?php

namespace NFePHP\MDFe\XsdType\MDFe\SignedInfoTypeType;

/**
 * Class representing CanonicalizationMethodType
 */
class CanonicalizationMethodType
{

    /**
     * @property string $Algorithm
     */
    private $Algorithm = null;

    /**
     * Gets as Algorithm
     *
     * @return string
     */
    public function getAlgorithm()
    {
        return $this->Algorithm;
    }

    /**
     * Sets a new Algorithm
     *
     * @param string $Algorithm
     * @return self
     */
    public function setAlgorithm($Algorithm)
    {
        $this->Algorithm = $Algorithm;
        return $this;
    }
}
