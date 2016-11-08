<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType;

use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfCTeType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfMDFeTranspType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfNFeType;

/**
 * Class representing InfMunDescargaType
 */
class InfMunDescargaType
{

    /**
     * Código do Município de Descarregamento
     *
     * @property string $cMunDescarga
     */
    private $cMunDescarga = null;

    /**
     * Nome do Município de Descarregamento
     *
     * @property string $xMunDescarga
     */
    private $xMunDescarga = null;

    /**
     * Conhecimentos de Tranporte - usar este grupo quando for prestador de serviço de
     * transporte
     *
     * @property InfCTeType[] $infCTe
     */
    private $infCTe = null;

    /**
     * Nota Fiscal Eletronica
     *
     * @property InfNFeType[] $infNFe
     */
    private $infNFe = null;

    /**
     * Manifesto Eletrônico de Documentos Fiscais. Somente para modal Aquaviário
     * (vide regras MOC)
     *
     * @property InfMDFeTranspType[] $infMDFeTransp
     */
    private $infMDFeTransp = null;

    /**
     * Gets as cMunDescarga
     *
     * Código do Município de Descarregamento
     *
     * @return string
     */
    public function getCMunDescarga()
    {
        return $this->cMunDescarga;
    }

    /**
     * Sets a new cMunDescarga
     *
     * Código do Município de Descarregamento
     *
     * @param string $cMunDescarga
     * @return self
     */
    public function setCMunDescarga($cMunDescarga)
    {
        $this->cMunDescarga = $cMunDescarga;
        return $this;
    }

    /**
     * Gets as xMunDescarga
     *
     * Nome do Município de Descarregamento
     *
     * @return string
     */
    public function getXMunDescarga()
    {
        return $this->xMunDescarga;
    }

    /**
     * Sets a new xMunDescarga
     *
     * Nome do Município de Descarregamento
     *
     * @param string $xMunDescarga
     * @return self
     */
    public function setXMunDescarga($xMunDescarga)
    {
        $this->xMunDescarga = $xMunDescarga;
        return $this;
    }

    /**
     * Adds as infCTe
     *
     * Conhecimentos de Tranporte - usar este grupo quando for prestador de serviço de
     * transporte
     *
     * @return self
     * @param InfCTeType $infCTe
     */
    public function addToInfCTe(InfCTeType $infCTe)
    {
        $this->infCTe[] = $infCTe;
        return $this;
    }

    /**
     * isset infCTe
     *
     * Conhecimentos de Tranporte - usar este grupo quando for prestador de serviço de
     * transporte
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetInfCTe($index)
    {
        return isset($this->infCTe[$index]);
    }

    /**
     * unset infCTe
     *
     * Conhecimentos de Tranporte - usar este grupo quando for prestador de serviço de
     * transporte
     *
     * @param scalar $index
     * @return void
     */
    public function unsetInfCTe($index)
    {
        unset($this->infCTe[$index]);
    }

    /**
     * Gets as infCTe
     *
     * Conhecimentos de Tranporte - usar este grupo quando for prestador de serviço de
     * transporte
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfCTeType[]
     */
    public function getInfCTe()
    {
        return $this->infCTe;
    }

    /**
     * Sets a new infCTe
     *
     * Conhecimentos de Tranporte - usar este grupo quando for prestador de serviço de
     * transporte
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfCTeType[] $infCTe
     * @return self
     */
    public function setInfCTe(array $infCTe)
    {
        $this->infCTe = $infCTe;
        return $this;
    }

    /**
     * Adds as infNFe
     *
     * Nota Fiscal Eletronica
     *
     * @return self
     * @param InfNFeType $infNFe
     */
    public function addToInfNFe(InfNFeType $infNFe)
    {
        $this->infNFe[] = $infNFe;
        return $this;
    }

    /**
     * isset infNFe
     *
     * Nota Fiscal Eletronica
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetInfNFe($index)
    {
        return isset($this->infNFe[$index]);
    }

    /**
     * unset infNFe
     *
     * Nota Fiscal Eletronica
     *
     * @param scalar $index
     * @return void
     */
    public function unsetInfNFe($index)
    {
        unset($this->infNFe[$index]);
    }

    /**
     * Gets as infNFe
     *
     * Nota Fiscal Eletronica
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfNFeType[]
     */
    public function getInfNFe()
    {
        return $this->infNFe;
    }

    /**
     * Sets a new infNFe
     *
     * Nota Fiscal Eletronica
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\InfDocType\InfMunDescargaType\InfNFeType[] $infNFe
     * @return self
     */
    public function setInfNFe(array $infNFe)
    {
        $this->infNFe = $infNFe;
        return $this;
    }

    /**
     * Adds as infMDFeTransp
     *
     * Manifesto Eletrônico de Documentos Fiscais. Somente para modal Aquaviário
     * (vide regras MOC)
     *
     * @return self
     * @param InfMDFeTranspType $infMDFeTransp
     */
    public function addToInfMDFeTransp(InfMDFeTranspType $infMDFeTransp)
    {
        $this->infMDFeTransp[] = $infMDFeTransp;
        return $this;
    }

    /**
     * isset infMDFeTransp
     *
     * Manifesto Eletrônico de Documentos Fiscais. Somente para modal Aquaviário
     * (vide regras MOC)
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetInfMDFeTransp($index)
    {
        return isset($this->infMDFeTransp[$index]);
    }

    /**
     * unset infMDFeTransp
     *
     * Manifesto Eletrônico de Documentos Fiscais. Somente para modal Aquaviário
     * (vide regras MOC)
     *
     * @param scalar $index
     * @return void
     */
    public function unsetInfMDFeTransp($index)
    {
        unset($this->infMDFeTransp[$index]);
    }

    /**
     * Gets as infMDFeTransp
     *
     * Manifesto Eletrônico de Documentos Fiscais. Somente para modal Aquaviário
     * (vide regras MOC)
     *
     * @return InfMDFeTranspType[]
     */
    public function getInfMDFeTransp()
    {
        return $this->infMDFeTransp;
    }

    /**
     * Sets a new infMDFeTransp
     *
     * Manifesto Eletrônico de Documentos Fiscais. Somente para modal Aquaviário
     * (vide regras MOC)
     *
     * @param InfMDFeTranspType[] $infMDFeTransp
     * @return self
     */
    public function setInfMDFeTransp(array $infMDFeTransp)
    {
        $this->infMDFeTransp = $infMDFeTransp;
        return $this;
    }
}
