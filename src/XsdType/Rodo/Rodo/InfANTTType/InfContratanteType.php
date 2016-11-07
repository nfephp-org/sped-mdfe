<?php

namespace NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType;

/**
 * Class representing InfContratanteType
 */
class InfContratanteType
{

    /**
     * Número do CPF do contratente do serviçoInformar os zeros não significativos.
     *
     * @property string $CPF
     */
    private $CPF = null;

    /**
     * Número do CNPJ do contratante do serviçoInformar os zeros não significativos.
     *
     * @property string $CNPJ
     */
    private $CNPJ = null;

    /**
     * Gets as CPF
     *
     * Número do CPF do contratente do serviçoInformar os zeros não significativos.
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
     * Número do CPF do contratente do serviçoInformar os zeros não significativos.
     *
     * @param string $CPF
     * @return self
     */
    public function setCPF($CPF)
    {
        $this->CPF = $CPF;
        return $this;
    }

    /**
     * Gets as CNPJ
     *
     * Número do CNPJ do contratante do serviçoInformar os zeros não significativos.
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
     * Número do CNPJ do contratante do serviçoInformar os zeros não significativos.
     *
     * @param string $CNPJ
     * @return self
     */
    public function setCNPJ($CNPJ)
    {
        $this->CNPJ = $CNPJ;
        return $this;
    }
}
