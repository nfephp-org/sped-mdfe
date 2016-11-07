<?php

namespace NFePHP\MDFe\XsdType\MDFe\TNFeNFType\InfNFType;

/**
 * Class representing DestType
 */
class DestType
{

    /**
     * CNPJ do DestinatárioInformar o CNPJ ou o CPF do destinatário, preenchendo os
     * zeros não significativos.
     * Não informar o conteúdo da TAG se a operação for realizada com o Exterior.
     *
     * @property string $CNPJ
     */
    private $CNPJ = null;

    /**
     * CPF do DestinatárioInformar os zeros não significativos.
     *
     * @property string $CPF
     */
    private $CPF = null;

    /**
     * Razão Social ou Nome
     *
     * @property string $xNome
     */
    private $xNome = null;

    /**
     * UF do DestinatárioInformar 'EX' para operações com o exterior.
     *
     * @property string $UF
     */
    private $UF = null;

    /**
     * Gets as CNPJ
     *
     * CNPJ do DestinatárioInformar o CNPJ ou o CPF do destinatário, preenchendo os
     * zeros não significativos.
     * Não informar o conteúdo da TAG se a operação for realizada com o Exterior.
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
     * CNPJ do DestinatárioInformar o CNPJ ou o CPF do destinatário, preenchendo os
     * zeros não significativos.
     * Não informar o conteúdo da TAG se a operação for realizada com o Exterior.
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
     * CPF do DestinatárioInformar os zeros não significativos.
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
     * CPF do DestinatárioInformar os zeros não significativos.
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
     * Gets as xNome
     *
     * Razão Social ou Nome
     *
     * @return string
     */
    public function getXNome()
    {
        return $this->xNome;
    }

    /**
     * Sets a new xNome
     *
     * Razão Social ou Nome
     *
     * @param string $xNome
     * @return self
     */
    public function setXNome($xNome)
    {
        $this->xNome = $xNome;
        return $this;
    }

    /**
     * Gets as UF
     *
     * UF do DestinatárioInformar 'EX' para operações com o exterior.
     *
     * @return string
     */
    public function getUF()
    {
        return $this->UF;
    }

    /**
     * Sets a new UF
     *
     * UF do DestinatárioInformar 'EX' para operações com o exterior.
     *
     * @param string $UF
     * @return self
     */
    public function setUF($UF)
    {
        $this->UF = $UF;
        return $this;
    }
}
