<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType;

use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType;

/**
 * Class representing InfDocType
 */
class InfDocType
{

    /**
     * Informações dos Municípios de descarregamento
     *
     * @property InfMunDescargaType[] $infMunDescarga
     */
    private $infMunDescarga = null;

    /**
     * Adds as infMunDescarga
     *
     * Informações dos Municípios de descarregamento
     *
     * @return self
     * @param InfMunDescargaType $infMunDescarga
     */
    public function addToInfMunDescarga(InfMunDescargaType $infMunDescarga)
    {
        $this->infMunDescarga[] = $infMunDescarga;
        return $this;
    }

    /**
     * isset infMunDescarga
     *
     * Informações dos Municípios de descarregamento
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetInfMunDescarga($index)
    {
        return isset($this->infMunDescarga[$index]);
    }

    /**
     * unset infMunDescarga
     *
     * Informações dos Municípios de descarregamento
     *
     * @param scalar $index
     * @return void
     */
    public function unsetInfMunDescarga($index)
    {
        unset($this->infMunDescarga[$index]);
    }

    /**
     * Gets as infMunDescarga
     *
     * Informações dos Municípios de descarregamento
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType[]
     */
    public function getInfMunDescarga()
    {
        return $this->infMunDescarga;
    }

    /**
     * Sets a new infMunDescarga
     *
     * Informações dos Municípios de descarregamento
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType[] $infMunDescarga
     * @return self
     */
    public function setInfMunDescarga(array $infMunDescarga)
    {
        $this->infMunDescarga = $infMunDescarga;
        return $this;
    }
}
