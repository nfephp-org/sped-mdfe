<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType;

use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\SegType\InfRespType;
use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\SegType\InfSegType;

/**
 * Class representing SegType
 */
class SegType
{

    /**
     * Informações do responsável pelo seguro da carga
     *
     * @property InfRespType
     * $infResp
     */
    private $infResp = null;

    /**
     * Informações da seguradora
     *
     * @property InfSegType
     * $infSeg
     */
    private $infSeg = null;

    /**
     * Número da ApóliceObrigatório pela lei 11.442/07 (RCTRC)
     *
     * @property string $nApol
     */
    private $nApol = null;

    /**
     * Número da AverbaçãoInformar as averbações do seguro
     *
     * @property string[] $nAver
     */
    private $nAver = null;

    /**
     * Gets as infResp
     *
     * Informações do responsável pelo seguro da carga
     *
     * @return InfRespType
     */
    public function getInfResp()
    {
        return $this->infResp;
    }

    /**
     * Sets a new infResp
     *
     * Informações do responsável pelo seguro da carga
     *
     * @param InfRespType $infResp
     * @return self
     */
    public function setInfResp(InfRespType $infResp)
    {
        $this->infResp = $infResp;
        return $this;
    }

    /**
     * Gets as infSeg
     *
     * Informações da seguradora
     *
     * @return InfSegType
     */
    public function getInfSeg()
    {
        return $this->infSeg;
    }

    /**
     * Sets a new infSeg
     *
     * Informações da seguradora
     *
     * @param InfSegType $infSeg
     * @return self
     */
    public function setInfSeg(InfSegType $infSeg)
    {
        $this->infSeg = $infSeg;
        return $this;
    }

    /**
     * Gets as nApol
     *
     * Número da ApóliceObrigatório pela lei 11.442/07 (RCTRC)
     *
     * @return string
     */
    public function getNApol()
    {
        return $this->nApol;
    }

    /**
     * Sets a new nApol
     *
     * Número da ApóliceObrigatório pela lei 11.442/07 (RCTRC)
     *
     * @param string $nApol
     * @return self
     */
    public function setNApol($nApol)
    {
        $this->nApol = $nApol;
        return $this;
    }

    /**
     * Adds as nAver
     *
     * Número da AverbaçãoInformar as averbações do seguro
     *
     * @return self
     * @param string $nAver
     */
    public function addToNAver($nAver)
    {
        $this->nAver[] = $nAver;
        return $this;
    }

    /**
     * isset nAver
     *
     * Número da AverbaçãoInformar as averbações do seguro
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetNAver($index)
    {
        return isset($this->nAver[$index]);
    }

    /**
     * unset nAver
     *
     * Número da AverbaçãoInformar as averbações do seguro
     *
     * @param scalar $index
     * @return void
     */
    public function unsetNAver($index)
    {
        unset($this->nAver[$index]);
    }

    /**
     * Gets as nAver
     *
     * Número da AverbaçãoInformar as averbações do seguro
     *
     * @return string[]
     */
    public function getNAver()
    {
        return $this->nAver;
    }

    /**
     * Sets a new nAver
     *
     * Número da AverbaçãoInformar as averbações do seguro
     *
     * @param string $nAver
     * @return self
     */
    public function setNAver(array $nAver)
    {
        $this->nAver = $nAver;
        return $this;
    }
}
