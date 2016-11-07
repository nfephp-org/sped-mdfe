<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType;

/**
 * Class representing EmitType
 */
class EmitType
{

    /**
     * CNPJ do emitenteInformar zeros não significativos
     *
     * @property string $CNPJ
     */
    private $CNPJ = null;

    /**
     * Inscrição Estadual do emitemte
     *
     * @property string $IE
     */
    private $IE = null;

    /**
     * Razão social ou Nome do emitente
     *
     * @property string $xNome
     */
    private $xNome = null;

    /**
     * Nome fantasia do emitente
     *
     * @property string $xFant
     */
    private $xFant = null;

    /**
     * Endereço do emitente
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TEndeEmiType $enderEmit
     */
    private $enderEmit = null;

    /**
     * Gets as CNPJ
     *
     * CNPJ do emitenteInformar zeros não significativos
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
     * CNPJ do emitenteInformar zeros não significativos
     *
     * @param string $CNPJ
     * @return self
     */
    public function setCNPJ($CNPJ)
    {
        $this->CNPJ = $CNPJ;
        return $this;
    }

    /**
     * Gets as IE
     *
     * Inscrição Estadual do emitemte
     *
     * @return string
     */
    public function getIE()
    {
        return $this->IE;
    }

    /**
     * Sets a new IE
     *
     * Inscrição Estadual do emitemte
     *
     * @param string $IE
     * @return self
     */
    public function setIE($IE)
    {
        $this->IE = $IE;
        return $this;
    }

    /**
     * Gets as xNome
     *
     * Razão social ou Nome do emitente
     *
     * @return string
     */
    public function getXNome()
    {
        return $this->xNome;
    }

    /**
     * Sets a new xNome
     *
     * Razão social ou Nome do emitente
     *
     * @param string $xNome
     * @return self
     */
    public function setXNome($xNome)
    {
        $this->xNome = $xNome;
        return $this;
    }

    /**
     * Gets as xFant
     *
     * Nome fantasia do emitente
     *
     * @return string
     */
    public function getXFant()
    {
        return $this->xFant;
    }

    /**
     * Sets a new xFant
     *
     * Nome fantasia do emitente
     *
     * @param string $xFant
     * @return self
     */
    public function setXFant($xFant)
    {
        $this->xFant = $xFant;
        return $this;
    }

    /**
     * Gets as enderEmit
     *
     * Endereço do emitente
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TEndeEmiType
     */
    public function getEnderEmit()
    {
        return $this->enderEmit;
    }

    /**
     * Sets a new enderEmit
     *
     * Endereço do emitente
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TEndeEmiType $enderEmit
     * @return self
     */
    public function setEnderEmit(\NFePHP\MDFe\XsdType\MDFe\TEndeEmiType $enderEmit)
    {
        $this->enderEmit = $enderEmit;
        return $this;
    }
}
