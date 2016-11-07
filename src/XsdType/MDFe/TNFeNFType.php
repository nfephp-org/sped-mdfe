<?php

namespace NFePHP\MDFe\XsdType\MDFe;

/**
 * Class representing TNFeNFType
 *
 * Tipo de Dados das Notas Fiscais Papel e Eletrônica
 * XSD Type: TNFeNF
 */
class TNFeNFType
{

    /**
     * Informações da NF-e
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFeType $infNFe
     */
    private $infNFe = null;

    /**
     * Informações da NF mod 1 e 1A
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType $infNF
     */
    private $infNF = null;

    /**
     * Gets as infNFe
     *
     * Informações da NF-e
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFeType
     */
    public function getInfNFe()
    {
        return $this->infNFe;
    }

    /**
     * Sets a new infNFe
     *
     * Informações da NF-e
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFeType $infNFe
     * @return self
     */
    public function setInfNFe(\NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFeType $infNFe)
    {
        $this->infNFe = $infNFe;
        return $this;
    }

    /**
     * Gets as infNF
     *
     * Informações da NF mod 1 e 1A
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType
     */
    public function getInfNF()
    {
        return $this->infNF;
    }

    /**
     * Sets a new infNF
     *
     * Informações da NF mod 1 e 1A
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType $infNF
     * @return self
     */
    public function setInfNF(\NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType $infNF)
    {
        $this->infNF = $infNF;
        return $this;
    }
}
