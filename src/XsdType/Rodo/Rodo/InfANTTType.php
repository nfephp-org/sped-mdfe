<?php

namespace NFePHP\MDFe\XsdType\Rodo\Rodo;

/**
 * Class representing InfANTTType
 */
class InfANTTType
{

    /**
     * Registro Nacional de Transportadores Rodoviários de CargaRegistro obrigatório
     * do emitente do MDF-e junto à ANTT para exercer a atividade de transportador
     * rodoviário de cargas por conta de terceiros e mediante remuneração.
     *
     * @property string $RNTRC
     */
    private $RNTRC = null;

    /**
     * Dados do CIOT
     *
     * @property \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\InfCIOTType[] $infCIOT
     */
    private $infCIOT = null;

    /**
     * Informações de Vale PedágioOutras informações sobre Vale-Pedágio
     * obrigatório que não tenham campos específicos devem ser informadas no campo
     * de observações gerais de uso livre pelo contribuinte, visando atender as
     * determinações legais vigentes.
     *
     * @property \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\ValePedType\DispType[]
     * $valePed
     */
    private $valePed = null;

    /**
     * Grupo de informações dos contratantes do serviço de transporte
     *
     * @property \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\InfContratanteType[]
     * $infContratante
     */
    private $infContratante = null;

    /**
     * Gets as RNTRC
     *
     * Registro Nacional de Transportadores Rodoviários de CargaRegistro obrigatório
     * do emitente do MDF-e junto à ANTT para exercer a atividade de transportador
     * rodoviário de cargas por conta de terceiros e mediante remuneração.
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
     * Registro Nacional de Transportadores Rodoviários de CargaRegistro obrigatório
     * do emitente do MDF-e junto à ANTT para exercer a atividade de transportador
     * rodoviário de cargas por conta de terceiros e mediante remuneração.
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
     * Adds as infCIOT
     *
     * Dados do CIOT
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\InfCIOTType $infCIOT
     */
    public function addToInfCIOT(\NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\InfCIOTType $infCIOT)
    {
        $this->infCIOT[] = $infCIOT;
        return $this;
    }

    /**
     * isset infCIOT
     *
     * Dados do CIOT
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetInfCIOT($index)
    {
        return isset($this->infCIOT[$index]);
    }

    /**
     * unset infCIOT
     *
     * Dados do CIOT
     *
     * @param scalar $index
     * @return void
     */
    public function unsetInfCIOT($index)
    {
        unset($this->infCIOT[$index]);
    }

    /**
     * Gets as infCIOT
     *
     * Dados do CIOT
     *
     * @return \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\InfCIOTType[]
     */
    public function getInfCIOT()
    {
        return $this->infCIOT;
    }

    /**
     * Sets a new infCIOT
     *
     * Dados do CIOT
     *
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\InfCIOTType[] $infCIOT
     * @return self
     */
    public function setInfCIOT(array $infCIOT)
    {
        $this->infCIOT = $infCIOT;
        return $this;
    }

    /**
     * Adds as disp
     *
     * Informações de Vale PedágioOutras informações sobre Vale-Pedágio
     * obrigatório que não tenham campos específicos devem ser informadas no campo
     * de observações gerais de uso livre pelo contribuinte, visando atender as
     * determinações legais vigentes.
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\ValePedType\DispType $disp
     */
    public function addToValePed(\NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\ValePedType\DispType $disp)
    {
        $this->valePed[] = $disp;
        return $this;
    }

    /**
     * isset valePed
     *
     * Informações de Vale PedágioOutras informações sobre Vale-Pedágio
     * obrigatório que não tenham campos específicos devem ser informadas no campo
     * de observações gerais de uso livre pelo contribuinte, visando atender as
     * determinações legais vigentes.
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetValePed($index)
    {
        return isset($this->valePed[$index]);
    }

    /**
     * unset valePed
     *
     * Informações de Vale PedágioOutras informações sobre Vale-Pedágio
     * obrigatório que não tenham campos específicos devem ser informadas no campo
     * de observações gerais de uso livre pelo contribuinte, visando atender as
     * determinações legais vigentes.
     *
     * @param scalar $index
     * @return void
     */
    public function unsetValePed($index)
    {
        unset($this->valePed[$index]);
    }

    /**
     * Gets as valePed
     *
     * Informações de Vale PedágioOutras informações sobre Vale-Pedágio
     * obrigatório que não tenham campos específicos devem ser informadas no campo
     * de observações gerais de uso livre pelo contribuinte, visando atender as
     * determinações legais vigentes.
     *
     * @return \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\ValePedType\DispType[]
     */
    public function getValePed()
    {
        return $this->valePed;
    }

    /**
     * Sets a new valePed
     *
     * Informações de Vale PedágioOutras informações sobre Vale-Pedágio
     * obrigatório que não tenham campos específicos devem ser informadas no campo
     * de observações gerais de uso livre pelo contribuinte, visando atender as
     * determinações legais vigentes.
     *
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\ValePedType\DispType[]
     * $valePed
     * @return self
     */
    public function setValePed(array $valePed)
    {
        $this->valePed = $valePed;
        return $this;
    }

    /**
     * Adds as infContratante
     *
     * Grupo de informações dos contratantes do serviço de transporte
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\InfContratanteType
     * $infContratante
     */
    public function addToInfContratante(\NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\InfContratanteType $infContratante)
    {
        $this->infContratante[] = $infContratante;
        return $this;
    }

    /**
     * isset infContratante
     *
     * Grupo de informações dos contratantes do serviço de transporte
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetInfContratante($index)
    {
        return isset($this->infContratante[$index]);
    }

    /**
     * unset infContratante
     *
     * Grupo de informações dos contratantes do serviço de transporte
     *
     * @param scalar $index
     * @return void
     */
    public function unsetInfContratante($index)
    {
        unset($this->infContratante[$index]);
    }

    /**
     * Gets as infContratante
     *
     * Grupo de informações dos contratantes do serviço de transporte
     *
     * @return \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\InfContratanteType[]
     */
    public function getInfContratante()
    {
        return $this->infContratante;
    }

    /**
     * Sets a new infContratante
     *
     * Grupo de informações dos contratantes do serviço de transporte
     *
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\InfContratanteType[]
     * $infContratante
     * @return self
     */
    public function setInfContratante(array $infContratante)
    {
        $this->infContratante = $infContratante;
        return $this;
    }
}
