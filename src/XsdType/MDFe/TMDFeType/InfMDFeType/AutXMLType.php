<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType;

/**
 * Class representing AutXMLType
 */
class AutXMLType
{

    /**
     * CNPJ do autorizadoInformar zeros não significativos
     *
     * @property string $CNPJ
     */
    private $CNPJ = null;

    /**
     * CPF do autorizadoInformar zeros não significativos
     *
     * @property string $CPF
     */
    private $CPF = null;

    /**
     * Gets as CNPJ
     *
     * CNPJ do autorizadoInformar zeros não significativos
     *
     * @return string
     */
    public function getCNPJ()
    {
        return $this->CNPJ;
    }

    /**
     * Sets a new CNPJ
     *
     * CNPJ do autorizadoInformar zeros não significativos
     *
     * @param string $CNPJ
     * @return self
     */
    public function setCNPJ($CNPJ)
    {
        $this->CNPJ = $CNPJ;
        return $this;
    }

    /**
     * Gets as CPF
     *
     * CPF do autorizadoInformar zeros não significativos
     *
     * @return string
     */
    public function getCPF()
    {
        return $this->CPF;
    }

    /**
     * Sets a new CPF
     *
     * CPF do autorizadoInformar zeros não significativos
     *
     * @param string $CPF
     * @return self
     */
    public function setCPF($CPF)
    {
        $this->CPF = $CPF;
        return $this;
    }
}
