<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType;

/**
 * Class representing InfAdicType
 */
class InfAdicType
{

    /**
     * Informações adicionais de interesse do FiscoNorma referenciada, informações
     * complementares, etc
     *
     * @property string $infAdFisco
     */
    private $infAdFisco = null;

    /**
     * Informações complementares de interesse do Contribuinte
     *
     * @property string $infCpl
     */
    private $infCpl = null;

    /**
     * Gets as infAdFisco
     *
     * Informações adicionais de interesse do FiscoNorma referenciada, informações
     * complementares, etc
     *
     * @return string
     */
    public function getInfAdFisco()
    {
        return $this->infAdFisco;
    }

    /**
     * Sets a new infAdFisco
     *
     * Informações adicionais de interesse do FiscoNorma referenciada, informações
     * complementares, etc
     *
     * @param string $infAdFisco
     * @return self
     */
    public function setInfAdFisco($infAdFisco)
    {
        $this->infAdFisco = $infAdFisco;
        return $this;
    }

    /**
     * Gets as infCpl
     *
     * Informações complementares de interesse do Contribuinte
     *
     * @return string
     */
    public function getInfCpl()
    {
        return $this->infCpl;
    }

    /**
     * Sets a new infCpl
     *
     * Informações complementares de interesse do Contribuinte
     *
     * @param string $infCpl
     * @return self
     */
    public function setInfCpl($infCpl)
    {
        $this->infCpl = $infCpl;
        return $this;
    }
}
