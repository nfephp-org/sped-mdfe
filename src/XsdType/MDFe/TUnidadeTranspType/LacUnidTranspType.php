<?php

namespace NFePHP\MDFe\XsdType\MDFe\TUnidadeTranspType;

/**
 * Class representing LacUnidTranspType
 */
class LacUnidTranspType
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
