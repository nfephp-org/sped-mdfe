<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType;

use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfNFeType\PeriType;

/**
 * Class representing InfNFeType
 */
class InfNFeType
{

    /**
     * Nota Fiscal Eletrônica
     *
     * @property string $chNFe
     */
    private $chNFe = null;

    /**
     * Segundo código de barras
     *
     * @property string $SegCodBarra
     */
    private $SegCodBarra = null;

    /**
     * Indicador de Reentrega
     *
     * @property string $indReentrega
     */
    private $indReentrega = null;

    /**
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Deve ser
     * preenchido com as informações das unidades de transporte utilizadas.
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TUnidadeTranspType[] $infUnidTransp
     */
    private $infUnidTransp = null;

    /**
     * Preenchido quando for transporte de produtos classificados pela ONU como
     * perigosos.
     *
     * @property PeriType[] $peri
     */
    private $peri = null;

    /**
     * Gets as chNFe
     *
     * Nota Fiscal Eletrônica
     *
     * @return string
     */
    public function getChNFe()
    {
        return $this->chNFe;
    }

    /**
     * Sets a new chNFe
     *
     * Nota Fiscal Eletrônica
     *
     * @param string $chNFe
     * @return self
     */
    public function setChNFe($chNFe)
    {
        $this->chNFe = $chNFe;
        return $this;
    }

    /**
     * Gets as SegCodBarra
     *
     * Segundo código de barras
     *
     * @return string
     */
    public function getSegCodBarra()
    {
        return $this->SegCodBarra;
    }

    /**
     * Sets a new SegCodBarra
     *
     * Segundo código de barras
     *
     * @param string $SegCodBarra
     * @return self
     */
    public function setSegCodBarra($SegCodBarra)
    {
        $this->SegCodBarra = $SegCodBarra;
        return $this;
    }

    /**
     * Gets as indReentrega
     *
     * Indicador de Reentrega
     *
     * @return string
     */
    public function getIndReentrega()
    {
        return $this->indReentrega;
    }

    /**
     * Sets a new indReentrega
     *
     * Indicador de Reentrega
     *
     * @param string $indReentrega
     * @return self
     */
    public function setIndReentrega($indReentrega)
    {
        $this->indReentrega = $indReentrega;
        return $this;
    }

    /**
     * Adds as infUnidTransp
     *
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Deve ser
     * preenchido com as informações das unidades de transporte utilizadas.
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\MDFe\TUnidadeTranspType $infUnidTransp
     */
    public function addToInfUnidTransp(\NFePHP\MDFe\XsdType\MDFe\TUnidadeTranspType $infUnidTransp)
    {
        $this->infUnidTransp[] = $infUnidTransp;
        return $this;
    }

    /**
     * isset infUnidTransp
     *
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Deve ser
     * preenchido com as informações das unidades de transporte utilizadas.
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetInfUnidTransp($index)
    {
        return isset($this->infUnidTransp[$index]);
    }

    /**
     * unset infUnidTransp
     *
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Deve ser
     * preenchido com as informações das unidades de transporte utilizadas.
     *
     * @param scalar $index
     * @return void
     */
    public function unsetInfUnidTransp($index)
    {
        unset($this->infUnidTransp[$index]);
    }

    /**
     * Gets as infUnidTransp
     *
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Deve ser
     * preenchido com as informações das unidades de transporte utilizadas.
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TUnidadeTranspType[]
     */
    public function getInfUnidTransp()
    {
        return $this->infUnidTransp;
    }

    /**
     * Sets a new infUnidTransp
     *
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Deve ser
     * preenchido com as informações das unidades de transporte utilizadas.
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TUnidadeTranspType[] $infUnidTransp
     * @return self
     */
    public function setInfUnidTransp(array $infUnidTransp)
    {
        $this->infUnidTransp = $infUnidTransp;
        return $this;
    }

    /**
     * Adds as peri
     *
     * Preenchido quando for transporte de produtos classificados pela ONU como
     * perigosos.
     *
     * @return self
     * @param PeriType $peri
     */
    public function addToPeri(PeriType $peri)
    {
        $this->peri[] = $peri;
        return $this;
    }

    /**
     * isset peri
     *
     * Preenchido quando for transporte de produtos classificados pela ONU como
     * perigosos.
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetPeri($index)
    {
        return isset($this->peri[$index]);
    }

    /**
     * unset peri
     *
     * Preenchido quando for transporte de produtos classificados pela ONU como
     * perigosos.
     *
     * @param scalar $index
     * @return void
     */
    public function unsetPeri($index)
    {
        unset($this->peri[$index]);
    }

    /**
     * Gets as peri
     *
     * Preenchido quando for transporte de produtos classificados pela ONU como
     * perigosos.
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfNFeType\PeriType[]
     */
    public function getPeri()
    {
        return $this->peri;
    }

    /**
     * Sets a new peri
     *
     * Preenchido quando for transporte de produtos classificados pela ONU como
     * perigosos.
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfNFeType\PeriType[] $peri
     * @return self
     */
    public function setPeri(array $peri)
    {
        $this->peri = $peri;
        return $this;
    }
}
