<?php

namespace NFePHP\MDFe\XsdType\Rodo;

/**
 * Class representing Rodo
 */
class Rodo
{

    /**
     * Grupo de informações para Agência Reguladora
     *
     * @property \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType $infANTT
     */
    private $infANTT = null;

    /**
     * Dados do Veículo com a Tração
     *
     * @property \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType $veicTracao
     */
    private $veicTracao = null;

    /**
     * Dados dos reboques
     *
     * @property \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicReboqueType[] $veicReboque
     */
    private $veicReboque = null;

    /**
     * Código de Agendamento no porto
     *
     * @property string $codAgPorto
     */
    private $codAgPorto = null;

    /**
     * Lacres
     *
     * @property \NFePHP\MDFe\XsdType\Rodo\Rodo\LacRodoType[] $lacRodo
     */
    private $lacRodo = null;

    /**
     * Gets as infANTT
     *
     * Grupo de informações para Agência Reguladora
     *
     * @return \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType
     */
    public function getInfANTT()
    {
        return $this->infANTT;
    }

    /**
     * Sets a new infANTT
     *
     * Grupo de informações para Agência Reguladora
     *
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType $infANTT
     * @return self
     */
    public function setInfANTT(\NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType $infANTT)
    {
        $this->infANTT = $infANTT;
        return $this;
    }

    /**
     * Gets as veicTracao
     *
     * Dados do Veículo com a Tração
     *
     * @return \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType
     */
    public function getVeicTracao()
    {
        return $this->veicTracao;
    }

    /**
     * Sets a new veicTracao
     *
     * Dados do Veículo com a Tração
     *
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType $veicTracao
     * @return self
     */
    public function setVeicTracao(\NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType $veicTracao)
    {
        $this->veicTracao = $veicTracao;
        return $this;
    }

    /**
     * Adds as veicReboque
     *
     * Dados dos reboques
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicReboqueType $veicReboque
     */
    public function addToVeicReboque(\NFePHP\MDFe\XsdType\Rodo\Rodo\VeicReboqueType $veicReboque)
    {
        $this->veicReboque[] = $veicReboque;
        return $this;
    }

    /**
     * isset veicReboque
     *
     * Dados dos reboques
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetVeicReboque($index)
    {
        return isset($this->veicReboque[$index]);
    }

    /**
     * unset veicReboque
     *
     * Dados dos reboques
     *
     * @param scalar $index
     * @return void
     */
    public function unsetVeicReboque($index)
    {
        unset($this->veicReboque[$index]);
    }

    /**
     * Gets as veicReboque
     *
     * Dados dos reboques
     *
     * @return \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicReboqueType[]
     */
    public function getVeicReboque()
    {
        return $this->veicReboque;
    }

    /**
     * Sets a new veicReboque
     *
     * Dados dos reboques
     *
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicReboqueType[] $veicReboque
     * @return self
     */
    public function setVeicReboque(array $veicReboque)
    {
        $this->veicReboque = $veicReboque;
        return $this;
    }

    /**
     * Gets as codAgPorto
     *
     * Código de Agendamento no porto
     *
     * @return string
     */
    public function getCodAgPorto()
    {
        return $this->codAgPorto;
    }

    /**
     * Sets a new codAgPorto
     *
     * Código de Agendamento no porto
     *
     * @param string $codAgPorto
     * @return self
     */
    public function setCodAgPorto($codAgPorto)
    {
        $this->codAgPorto = $codAgPorto;
        return $this;
    }

    /**
     * Adds as lacRodo
     *
     * Lacres
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\LacRodoType $lacRodo
     */
    public function addToLacRodo(\NFePHP\MDFe\XsdType\Rodo\Rodo\LacRodoType $lacRodo)
    {
        $this->lacRodo[] = $lacRodo;
        return $this;
    }

    /**
     * isset lacRodo
     *
     * Lacres
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetLacRodo($index)
    {
        return isset($this->lacRodo[$index]);
    }

    /**
     * unset lacRodo
     *
     * Lacres
     *
     * @param scalar $index
     * @return void
     */
    public function unsetLacRodo($index)
    {
        unset($this->lacRodo[$index]);
    }

    /**
     * Gets as lacRodo
     *
     * Lacres
     *
     * @return \NFePHP\MDFe\XsdType\Rodo\Rodo\LacRodoType[]
     */
    public function getLacRodo()
    {
        return $this->lacRodo;
    }

    /**
     * Sets a new lacRodo
     *
     * Lacres
     *
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\LacRodoType[] $lacRodo
     * @return self
     */
    public function setLacRodo(array $lacRodo)
    {
        $this->lacRodo = $lacRodo;
        return $this;
    }
}
