<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\IdeType;

/**
 * Class representing InfMunCarregaType
 */
class InfMunCarregaType
{

    /**
     * Código do Município de Carregamento
     *
     * @property string $cMunCarrega
     */
    private $cMunCarrega = null;

    /**
     * Nome do Município de Carregamento
     *
     * @property string $xMunCarrega
     */
    private $xMunCarrega = null;

    /**
     * Gets as cMunCarrega
     *
     * Código do Município de Carregamento
     *
     * @return string
     */
    public function getCMunCarrega()
    {
        return $this->cMunCarrega;
    }

    /**
     * Sets a new cMunCarrega
     *
     * Código do Município de Carregamento
     *
     * @param string $cMunCarrega
     * @return self
     */
    public function setCMunCarrega($cMunCarrega)
    {
        $this->cMunCarrega = $cMunCarrega;
        return $this;
    }

    /**
     * Gets as xMunCarrega
     *
     * Nome do Município de Carregamento
     *
     * @return string
     */
    public function getXMunCarrega()
    {
        return $this->xMunCarrega;
    }

    /**
     * Sets a new xMunCarrega
     *
     * Nome do Município de Carregamento
     *
     * @param string $xMunCarrega
     * @return self
     */
    public function setXMunCarrega($xMunCarrega)
    {
        $this->xMunCarrega = $xMunCarrega;
        return $this;
    }
}
