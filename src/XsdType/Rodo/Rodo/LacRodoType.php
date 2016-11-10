<?php

namespace NFePHP\MDFe\XsdType\Rodo\Rodo;

/**
 * Class representing LacRodoType
 */
class LacRodoType
{

    /**
     * Número do Lacre
     *
     * @property string $nLacre
     */
    private $nLacre = null;

    /**
     * Gets as nLacre
     *
     * Número do Lacre
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
     * Número do Lacre
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
