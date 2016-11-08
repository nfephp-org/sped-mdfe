<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType;

use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfMDFeTranspType\PeriType;

/**
 * Class representing InfMDFeTranspType
 */
class InfMDFeTranspType
{

    /**
     * Manifesto Eletrônico de Documentos Fiscais
     *
     * @property string $chMDFe
     */
    private $chMDFe = null;

    /**
     * Indicador de Reentrega
     *
     * @property string $indReentrega
     */
    private $indReentrega = null;

    /**
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Dispositivo de
     * carga utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de
     * carga, vagão, contêiner de avião, palete de aeronave com rede ou palete de
     * aeronave com rede sobre um iglu.
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
     * Gets as chMDFe
     *
     * Manifesto Eletrônico de Documentos Fiscais
     *
     * @return string
     */
    public function getChMDFe()
    {
        return $this->chMDFe;
    }

    /**
     * Sets a new chMDFe
     *
     * Manifesto Eletrônico de Documentos Fiscais
     *
     * @param string $chMDFe
     * @return self
     */
    public function setChMDFe($chMDFe)
    {
        $this->chMDFe = $chMDFe;
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
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Dispositivo de
     * carga utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de
     * carga, vagão, contêiner de avião, palete de aeronave com rede ou palete de
     * aeronave com rede sobre um iglu.
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
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Dispositivo de
     * carga utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de
     * carga, vagão, contêiner de avião, palete de aeronave com rede ou palete de
     * aeronave com rede sobre um iglu.
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
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Dispositivo de
     * carga utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de
     * carga, vagão, contêiner de avião, palete de aeronave com rede ou palete de
     * aeronave com rede sobre um iglu.
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
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Dispositivo de
     * carga utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de
     * carga, vagão, contêiner de avião, palete de aeronave com rede ou palete de
     * aeronave com rede sobre um iglu.
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
     * Informações das Unidades de Transporte (Carreta/Reboque/Vagão)Dispositivo de
     * carga utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de
     * carga, vagão, contêiner de avião, palete de aeronave com rede ou palete de
     * aeronave com rede sobre um iglu.
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
     * @return PeriType[]
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
     * @param PeriType[] $peri
     * @return self
     */
    public function setPeri(array $peri)
    {
        $this->peri = $peri;
        return $this;
    }
}
