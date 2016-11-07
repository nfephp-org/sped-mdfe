<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\SegType;

/**
 * Class representing InfSegType
 */
class InfSegType
{

    /**
     * Nome da Seguradora
     *
     * @property string $xSeg
     */
    private $xSeg = null;

    /**
     * Número do CNPJ da seguradoraObrigatório apenas se responsável pelo seguro for
     * (2) responsável pela contratação do transporte - pessoa jurídica
     *
     * @property string $CNPJ
     */
    private $CNPJ = null;

    /**
     * Gets as xSeg
     *
     * Nome da Seguradora
     *
     * @return string
     */
    public function getXSeg()
    {
        return $this->xSeg;
    }

    /**
     * Sets a new xSeg
     *
     * Nome da Seguradora
     *
     * @param string $xSeg
     * @return self
     */
    public function setXSeg($xSeg)
    {
        $this->xSeg = $xSeg;
        return $this;
    }

    /**
     * Gets as CNPJ
     *
     * Número do CNPJ da seguradoraObrigatório apenas se responsável pelo seguro for
     * (2) responsável pela contratação do transporte - pessoa jurídica
     *
     * @return string
     */
    public function getCNPJ()
    {
        return $this->CNPJ;
    }

    /**
     * Sets a new CNPJ
     *
     * Número do CNPJ da seguradoraObrigatório apenas se responsável pelo seguro for
     * (2) responsável pela contratação do transporte - pessoa jurídica
     *
     * @param string $CNPJ
     * @return self
     */
    public function setCNPJ($CNPJ)
    {
        $this->CNPJ = $CNPJ;
        return $this;
    }
}
