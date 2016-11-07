<?php

namespace NFePHP\MDFe\XsdType\MDFe;

/**
 * Class representing TransformTypeType
 *
 *
 * XSD Type: TransformType
 */
class TransformTypeType
{

    /**
     * @property string $Algorithm
     */
    private $Algorithm = null;

    /**
     * @property string[] $XPath
     */
    private $XPath = null;

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

    /**
     * Adds as XPath
     *
     * @return self
     * @param string $XPath
     */
    public function addToXPath($XPath)
    {
        $this->XPath[] = $XPath;
        return $this;
    }

    /**
     * isset XPath
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetXPath($index)
    {
        return isset($this->XPath[$index]);
    }

    /**
     * unset XPath
     *
     * @param scalar $index
     * @return void
     */
    public function unsetXPath($index)
    {
        unset($this->XPath[$index]);
    }

    /**
     * Gets as XPath
     *
     * @return string[]
     */
    public function getXPath()
    {
        return $this->XPath;
    }

    /**
     * Sets a new XPath
     *
     * @param string[] $XPath
     * @return self
     */
    public function setXPath(array $XPath)
    {
        $this->XPath = $XPath;
        return $this;
    }
}
