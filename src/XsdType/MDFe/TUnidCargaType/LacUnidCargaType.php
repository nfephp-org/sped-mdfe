<?php

namespace NFePHP\MDFe\XsdType\MDFe\TUnidCargaType;

/**
 * Class representing LacUnidCargaType
 */
class LacUnidCargaType
{

    /**
     * Número do lacre
     *
     * @property string $nLacre
     */
    private $nLacre = null;

    /**
     * Gets as nLacre
     *
     * Número do lacre
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
     * Número do lacre
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
