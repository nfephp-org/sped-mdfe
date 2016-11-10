<?php

namespace NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType;

/**
 * Class representing InfCIOTType
 */
class InfCIOTType
{

    /**
     * Código Identificador da Operação de TransporteTambém Conhecido como conta
     * frete
     *
     * @property string $CIOT
     */
    private $CIOT = null;

    /**
     * Número do CPF responsável pela geração do CIOTInformar os zeros não
     * significativos.
     *
     * @property string $CPF
     */
    private $CPF = null;

    /**
     * Número do CNPJ responsável pela geração do CIOTInformar os zeros não
     * significativos.
     *
     * @property string $CNPJ
     */
    private $CNPJ = null;

    /**
     * Gets as CIOT
     *
     * Código Identificador da Operação de TransporteTambém Conhecido como conta
     * frete
     *
     * @return string
     */
    public function getCIOT()
    {
        return $this->CIOT;
    }

    /**
     * Sets a new CIOT
     *
     * Código Identificador da Operação de TransporteTambém Conhecido como conta
     * frete
     *
     * @param string $CIOT
     * @return self
     */
    public function setCIOT($CIOT)
    {
        $this->CIOT = $CIOT;
        return $this;
    }

    /**
     * Gets as CPF
     *
     * Número do CPF responsável pela geração do CIOTInformar os zeros não
     * significativos.
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
     * Número do CPF responsável pela geração do CIOTInformar os zeros não
     * significativos.
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
     * Número do CNPJ responsável pela geração do CIOTInformar os zeros não
     * significativos.
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
     * Número do CNPJ responsável pela geração do CIOTInformar os zeros não
     * significativos.
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
