<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType\SegType;

/**
 * Class representing InfRespType
 */
class InfRespType
{

    /**
     * Responsável pelo seguroPreencher com:
     *  1- Emitente do MDF-e;
     *
     * 22 - Responsável pela contratação do serviço de transporte (contratante)
     *
     *
     * Dados obrigatórios apenas no modal Rodoviário, depois da lei 11.442/07. Para
     * os demais modais esta informação é opcional.
     *
     * @property string $respSeg
     */
    private $respSeg = null;

    /**
     * Número do CNPJ do responsável pelo seguroObrigatório apenas se responsável
     * pelo seguro for (2) responsável pela contratação do transporte - pessoa
     * jurídica
     *
     * @property string $CNPJ
     */
    private $CNPJ = null;

    /**
     * Número do CPF do responsável pelo seguroObrigatório apenas se responsável
     * pelo seguro for (2) responsável pela contratação do transporte - pessoa
     * física
     *
     * @property string $CPF
     */
    private $CPF = null;

    /**
     * Gets as respSeg
     *
     * Responsável pelo seguroPreencher com:
     *  1- Emitente do MDF-e;
     *
     * 22 - Responsável pela contratação do serviço de transporte (contratante)
     *
     *
     * Dados obrigatórios apenas no modal Rodoviário, depois da lei 11.442/07. Para
     * os demais modais esta informação é opcional.
     *
     * @return string
     */
    public function getRespSeg()
    {
        return $this->respSeg;
    }

    /**
     * Sets a new respSeg
     *
     * Responsável pelo seguroPreencher com:
     *  1- Emitente do MDF-e;
     *
     * 22 - Responsável pela contratação do serviço de transporte (contratante)
     *
     *
     * Dados obrigatórios apenas no modal Rodoviário, depois da lei 11.442/07. Para
     * os demais modais esta informação é opcional.
     *
     * @param string $respSeg
     * @return self
     */
    public function setRespSeg($respSeg)
    {
        $this->respSeg = $respSeg;
        return $this;
    }

    /**
     * Gets as CNPJ
     *
     * Número do CNPJ do responsável pelo seguroObrigatório apenas se responsável
     * pelo seguro for (2) responsável pela contratação do transporte - pessoa
     * jurídica
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
     * Número do CNPJ do responsável pelo seguroObrigatório apenas se responsável
     * pelo seguro for (2) responsável pela contratação do transporte - pessoa
     * jurídica
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
     * Número do CPF do responsável pelo seguroObrigatório apenas se responsável
     * pelo seguro for (2) responsável pela contratação do transporte - pessoa
     * física
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
     * Número do CPF do responsável pelo seguroObrigatório apenas se responsável
     * pelo seguro for (2) responsável pela contratação do transporte - pessoa
     * física
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
