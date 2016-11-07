<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType;

/**
 * Class representing LacresType
 */
class LacresType
{

    /**
     * número do lacre
     *
     * @property string $nLacre
     */
    private $nLacre = null;

    /**
     * Gets as nLacre
     *
     * número do lacre
     *
     * @return string
     */
    public function getNLacre()
    {
        return $this->nLacre;
    }

    /**
     * Sets a new nLacre
     *
     * número do lacre
     *
     * @param string $nLacre
     * @return self
     */
    public function setNLacre($nLacre)
    {
        $this->nLacre = $nLacre;
        return $this;
    }
}
