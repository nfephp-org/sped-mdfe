<?php

namespace NFePHP\MDFe\XsdType\Rodo\Rodo\VeicReboqueType;

/**
 * Class representing PropType
 */
class PropType
{

    /**
     * Número do CPFInformar os zeros não significativos.
     *
     * @property string $CPF
     */
    private $CPF = null;

    /**
     * Número do CNPJInformar os zeros não significativos.
     *
     * @property string $CNPJ
     */
    private $CNPJ = null;

    /**
     * Registro Nacional dos Transportadores Rodoviários de CargaRegistro obrigatório
     * do proprietário, co-proprietário ou arrendatário do veículo junto à ANTT
     * para exercer a atividade de transportador rodoviário de cargas por conta de
     * terceiros e mediante remuneração.
     *
     * @property string $RNTRC
     */
    private $RNTRC = null;

    /**
     * Razão Social ou Nome do proprietário
     *
     * @property string $xNome
     */
    private $xNome = null;

    /**
     * Inscrição Estadual
     *
     * @property string $IE
     */
    private $IE = null;

    /**
     * UF
     *
     * @property string $UF
     */
    private $UF = null;

    /**
     * Tipo ProprietárioPreencher com:
     *  0-TAC – Agregado;
     *  1-TAC Independente; ou
     *  2 – Outros.
     *
     * @property string $tpProp
     */
    private $tpProp = null;

    /**
     * Gets as CPF
     *
     * Número do CPFInformar os zeros não significativos.
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
     * Número do CPFInformar os zeros não significativos.
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
     * Número do CNPJInformar os zeros não significativos.
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
     * Número do CNPJInformar os zeros não significativos.
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
     * Gets as RNTRC
     *
     * Registro Nacional dos Transportadores Rodoviários de CargaRegistro obrigatório
     * do proprietário, co-proprietário ou arrendatário do veículo junto à ANTT
     * para exercer a atividade de transportador rodoviário de cargas por conta de
     * terceiros e mediante remuneração.
     *
     * @return string
     */
    public function getRNTRC()
    {
        return $this->RNTRC;
    }

    /**
     * Sets a new RNTRC
     *
     * Registro Nacional dos Transportadores Rodoviários de CargaRegistro obrigatório
     * do proprietário, co-proprietário ou arrendatário do veículo junto à ANTT
     * para exercer a atividade de transportador rodoviário de cargas por conta de
     * terceiros e mediante remuneração.
     *
     * @param string $RNTRC
     * @return self
     */
    public function setRNTRC($RNTRC)
    {
        $this->RNTRC = $RNTRC;
        return $this;
    }

    /**
     * Gets as xNome
     *
     * Razão Social ou Nome do proprietário
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
     * Razão Social ou Nome do proprietário
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
     * Gets as IE
     *
     * Inscrição Estadual
     *
     * @return string
     */
    public function getIE()
    {
        return $this->IE;
    }

    /**
     * Sets a new IE
     *
     * Inscrição Estadual
     *
     * @param string $IE
     * @return self
     */
    public function setIE($IE)
    {
        $this->IE = $IE;
        return $this;
    }

    /**
     * Gets as UF
     *
     * UF
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
     * UF
     *
     * @param string $UF
     * @return self
     */
    public function setUF($UF)
    {
        $this->UF = $UF;
        return $this;
    }

    /**
     * Gets as tpProp
     *
     * Tipo ProprietárioPreencher com:
     *  0-TAC – Agregado;
     *  1-TAC Independente; ou
     *  2 – Outros.
     *
     * @return string
     */
    public function getTpProp()
    {
        return $this->tpProp;
    }

    /**
     * Sets a new tpProp
     *
     * Tipo ProprietárioPreencher com:
     *  0-TAC – Agregado;
     *  1-TAC Independente; ou
     *  2 – Outros.
     *
     * @param string $tpProp
     * @return self
     */
    public function setTpProp($tpProp)
    {
        $this->tpProp = $tpProp;
        return $this;
    }
}
