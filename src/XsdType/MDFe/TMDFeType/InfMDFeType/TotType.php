<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType;

/**
 * Class representing TotType
 */
class TotType
{

    /**
     * Quantidade total de CT-e relacionados no Manifesto
     *
     * @property string $qCTe
     */
    private $qCTe = null;

    /**
     * Quantidade total de NF-e relacionadas no Manifesto
     *
     * @property string $qNFe
     */
    private $qNFe = null;

    /**
     * Quantidade total de MDF-e relacionados no Manifesto Aquaviário
     *
     * @property string $qMDFe
     */
    private $qMDFe = null;

    /**
     * Valor total da carga / mercadorias transportadas
     *
     * @property string $vCarga
     */
    private $vCarga = null;

    /**
     * Codigo da unidade de medida do Peso Bruto da Carga / Mercadorias transportadas01
     * – KG; 02 - TON
     *
     * @property string $cUnid
     */
    private $cUnid = null;

    /**
     * Peso Bruto Total da Carga / Mercadorias transportadas
     *
     * @property string $qCarga
     */
    private $qCarga = null;

    /**
     * Gets as qCTe
     *
     * Quantidade total de CT-e relacionados no Manifesto
     *
     * @return string
     */
    public function getQCTe()
    {
        return $this->qCTe;
    }

    /**
     * Sets a new qCTe
     *
     * Quantidade total de CT-e relacionados no Manifesto
     *
     * @param string $qCTe
     * @return self
     */
    public function setQCTe($qCTe)
    {
        $this->qCTe = $qCTe;
        return $this;
    }

    /**
     * Gets as qNFe
     *
     * Quantidade total de NF-e relacionadas no Manifesto
     *
     * @return string
     */
    public function getQNFe()
    {
        return $this->qNFe;
    }

    /**
     * Sets a new qNFe
     *
     * Quantidade total de NF-e relacionadas no Manifesto
     *
     * @param string $qNFe
     * @return self
     */
    public function setQNFe($qNFe)
    {
        $this->qNFe = $qNFe;
        return $this;
    }

    /**
     * Gets as qMDFe
     *
     * Quantidade total de MDF-e relacionados no Manifesto Aquaviário
     *
     * @return string
     */
    public function getQMDFe()
    {
        return $this->qMDFe;
    }

    /**
     * Sets a new qMDFe
     *
     * Quantidade total de MDF-e relacionados no Manifesto Aquaviário
     *
     * @param string $qMDFe
     * @return self
     */
    public function setQMDFe($qMDFe)
    {
        $this->qMDFe = $qMDFe;
        return $this;
    }

    /**
     * Gets as vCarga
     *
     * Valor total da carga / mercadorias transportadas
     *
     * @return string
     */
    public function getVCarga()
    {
        return $this->vCarga;
    }

    /**
     * Sets a new vCarga
     *
     * Valor total da carga / mercadorias transportadas
     *
     * @param string $vCarga
     * @return self
     */
    public function setVCarga($vCarga)
    {
        $this->vCarga = $vCarga;
        return $this;
    }

    /**
     * Gets as cUnid
     *
     * Codigo da unidade de medida do Peso Bruto da Carga / Mercadorias transportadas01
     * – KG; 02 - TON
     *
     * @return string
     */
    public function getCUnid()
    {
        return $this->cUnid;
    }

    /**
     * Sets a new cUnid
     *
     * Codigo da unidade de medida do Peso Bruto da Carga / Mercadorias transportadas01
     * – KG; 02 - TON
     *
     * @param string $cUnid
     * @return self
     */
    public function setCUnid($cUnid)
    {
        $this->cUnid = $cUnid;
        return $this;
    }

    /**
     * Gets as qCarga
     *
     * Peso Bruto Total da Carga / Mercadorias transportadas
     *
     * @return string
     */
    public function getQCarga()
    {
        return $this->qCarga;
    }

    /**
     * Sets a new qCarga
     *
     * Peso Bruto Total da Carga / Mercadorias transportadas
     *
     * @param string $qCarga
     * @return self
     */
    public function setQCarga($qCarga)
    {
        $this->qCarga = $qCarga;
        return $this;
    }
}
