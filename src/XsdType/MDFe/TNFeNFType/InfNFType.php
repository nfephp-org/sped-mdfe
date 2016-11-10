<?php

namespace NFePHP\MDFe\XsdType\MDFe\TNFeNFType;

/**
 * Class representing InfNFType
 */
class InfNFType
{

    /**
     * Informações do Emitente da NF
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType\EmiType $emi
     */
    private $emi = null;

    /**
     * Informações do Destinatário da NF
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType\DestType $dest
     */
    private $dest = null;

    /**
     * Série
     *
     * @property string $serie
     */
    private $serie = null;

    /**
     * Número
     *
     * @property string $nNF
     */
    private $nNF = null;

    /**
     * Data de EmissãoFormato AAAA-MM-DD
     *
     * @property string $dEmi
     */
    private $dEmi = null;

    /**
     * Valor Total da NF
     *
     * @property string $vNF
     */
    private $vNF = null;

    /**
     * PIN SUFRAMAPIN atribuído pela SUFRAMA para a operação.
     *
     * @property string $PIN
     */
    private $PIN = null;

    /**
     * Gets as emi
     *
     * Informações do Emitente da NF
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType\EmiType
     */
    public function getEmi()
    {
        return $this->emi;
    }

    /**
     * Sets a new emi
     *
     * Informações do Emitente da NF
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType\EmiType $emi
     * @return self
     */
    public function setEmi(\NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType\EmiType $emi)
    {
        $this->emi = $emi;
        return $this;
    }

    /**
     * Gets as dest
     *
     * Informações do Destinatário da NF
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType\DestType
     */
    public function getDest()
    {
        return $this->dest;
    }

    /**
     * Sets a new dest
     *
     * Informações do Destinatário da NF
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType\DestType $dest
     * @return self
     */
    public function setDest(\NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType\DestType $dest)
    {
        $this->dest = $dest;
        return $this;
    }

    /**
     * Gets as serie
     *
     * Série
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Sets a new serie
     *
     * Série
     *
     * @param string $serie
     * @return self
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * Gets as nNF
     *
     * Número
     *
     * @return string
     */
    public function getNNF()
    {
        return $this->nNF;
    }

    /**
     * Sets a new nNF
     *
     * Número
     *
     * @param string $nNF
     * @return self
     */
    public function setNNF($nNF)
    {
        $this->nNF = $nNF;
        return $this;
    }

    /**
     * Gets as dEmi
     *
     * Data de EmissãoFormato AAAA-MM-DD
     *
     * @return string
     */
    public function getDEmi()
    {
        return $this->dEmi;
    }

    /**
     * Sets a new dEmi
     *
     * Data de EmissãoFormato AAAA-MM-DD
     *
     * @param string $dEmi
     * @return self
     */
    public function setDEmi($dEmi)
    {
        $this->dEmi = $dEmi;
        return $this;
    }

    /**
     * Gets as vNF
     *
     * Valor Total da NF
     *
     * @return string
     */
    public function getVNF()
    {
        return $this->vNF;
    }

    /**
     * Sets a new vNF
     *
     * Valor Total da NF
     *
     * @param string $vNF
     * @return self
     */
    public function setVNF($vNF)
    {
        $this->vNF = $vNF;
        return $this;
    }

    /**
     * Gets as PIN
     *
     * PIN SUFRAMAPIN atribuído pela SUFRAMA para a operação.
     *
     * @return string
     */
    public function getPIN()
    {
        return $this->PIN;
    }

    /**
     * Sets a new PIN
     *
     * PIN SUFRAMAPIN atribuído pela SUFRAMA para a operação.
     *
     * @param string $PIN
     * @return self
     */
    public function setPIN($PIN)
    {
        $this->PIN = $PIN;
        return $this;
    }
}
