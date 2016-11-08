<?php

namespace NFePHP\MDFe\XsdType\MDFe;

use NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType;

/**
 * Class representing TMDFeType
 *
 * Tipo Manifesto de Documentos Fiscais Eletrônicos
 * XSD Type: TMDFe
 */
class TMDFeType
{

    /**
     * Informações do MDF-e
     *
     * @property InfMDFeType $infMDFe
     */
    private $infMDFe = null;

    /**
     * @property \NFePHP\MDFe\XsdType\MDFe\Signature $Signature
     */
    private $Signature = null;

    /**
     * Gets as infMDFe
     *
     * Informações do MDF-e
     *
     * @return InfMDFeType
     */
    public function getInfMDFe()
    {
        return $this->infMDFe;
    }

    /**
     * Sets a new infMDFe
     *
     * Informações do MDF-e
     *
     * @param InfMDFeType $infMDFe
     * @return self
     */
    public function setInfMDFe(InfMDFeType $infMDFe)
    {
        $this->infMDFe = $infMDFe;
        return $this;
    }

    /**
     * Gets as Signature
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\Signature
     */
    public function getSignature()
    {
        return $this->Signature;
    }

    /**
     * Sets a new Signature
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\Signature $Signature
     * @return self
     */
    public function setSignature(\NFePHP\MDFe\XsdType\MDFe\Signature $Signature)
    {
        $this->Signature = $Signature;
        return $this;
    }
}
