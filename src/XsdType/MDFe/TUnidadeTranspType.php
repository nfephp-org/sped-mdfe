<?php

namespace NFePHP\MDFe\XsdType\MDFe;

use NFePHP\MDFe\XsdType\MDFe\TUnidadeTranspType\LacUnidTranspType;

/**
 * Class representing TUnidadeTranspType
 *
 * Tipo Dados Unidade de Transporte
 * XSD Type: TUnidadeTransp
 */
class TUnidadeTranspType
{

    /**
     * Tipo da Unidade de Transporte1 - Rodoviário Tração;
     *
     * 2 - Rodoviário Reboque;
     *
     * 3 - Navio;
     *
     * 4 - Balsa;
     *
     * 5 - Aeronave;
     *
     * 6 - Vagão;
     *
     * 7 - Outros
     *
     * @property string $tpUnidTransp
     */
    private $tpUnidTransp = null;

    /**
     * Identificação da Unidade de TransporteInformar a identificação conforme o
     * tipo de unidade de transporte.
     * Por exemplo: para rodoviário tração ou reboque deverá preencher com a placa
     * do veículo.
     *
     * @property string $idUnidTransp
     */
    private $idUnidTransp = null;

    /**
     * Lacres das Unidades de Transporte
     *
     * @property LacUnidTranspType[]
     * $lacUnidTransp
     */
    private $lacUnidTransp = null;

    /**
     * Informações das Unidades de Carga (Containeres/ULD/Outros)Dispositivo de carga
     * utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de carga,
     * vagão, contêiner de avião, palete de aeronave com rede ou palete de aeronave
     * com rede sobre um iglu.
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TUnidCargaType[] $infUnidCarga
     */
    private $infUnidCarga = null;

    /**
     * Quantidade rateada (Peso,Volume)
     *
     * @property string $qtdRat
     */
    private $qtdRat = null;

    /**
     * Gets as tpUnidTransp
     *
     * Tipo da Unidade de Transporte1 - Rodoviário Tração;
     *
     * 2 - Rodoviário Reboque;
     *
     * 3 - Navio;
     *
     * 4 - Balsa;
     *
     * 5 - Aeronave;
     *
     * 6 - Vagão;
     *
     * 7 - Outros
     *
     * @return string
     */
    public function getTpUnidTransp()
    {
        return $this->tpUnidTransp;
    }

    /**
     * Sets a new tpUnidTransp
     *
     * Tipo da Unidade de Transporte1 - Rodoviário Tração;
     *
     * 2 - Rodoviário Reboque;
     *
     * 3 - Navio;
     *
     * 4 - Balsa;
     *
     * 5 - Aeronave;
     *
     * 6 - Vagão;
     *
     * 7 - Outros
     *
     * @param string $tpUnidTransp
     * @return self
     */
    public function setTpUnidTransp($tpUnidTransp)
    {
        $this->tpUnidTransp = $tpUnidTransp;
        return $this;
    }

    /**
     * Gets as idUnidTransp
     *
     * Identificação da Unidade de TransporteInformar a identificação conforme o
     * tipo de unidade de transporte.
     * Por exemplo: para rodoviário tração ou reboque deverá preencher com a placa
     * do veículo.
     *
     * @return string
     */
    public function getIdUnidTransp()
    {
        return $this->idUnidTransp;
    }

    /**
     * Sets a new idUnidTransp
     *
     * Identificação da Unidade de TransporteInformar a identificação conforme o
     * tipo de unidade de transporte.
     * Por exemplo: para rodoviário tração ou reboque deverá preencher com a placa
     * do veículo.
     *
     * @param string $idUnidTransp
     * @return self
     */
    public function setIdUnidTransp($idUnidTransp)
    {
        $this->idUnidTransp = $idUnidTransp;
        return $this;
    }

    /**
     * Adds as lacUnidTransp
     *
     * Lacres das Unidades de Transporte
     *
     * @return self
     * @param LacUnidTranspType $lacUnidTransp
     */
    public function addToLacUnidTransp(LacUnidTranspType $lacUnidTransp)
    {
        $this->lacUnidTransp[] = $lacUnidTransp;
        return $this;
    }

    /**
     * isset lacUnidTransp
     *
     * Lacres das Unidades de Transporte
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetLacUnidTransp($index)
    {
        return isset($this->lacUnidTransp[$index]);
    }

    /**
     * unset lacUnidTransp
     *
     * Lacres das Unidades de Transporte
     *
     * @param scalar $index
     * @return void
     */
    public function unsetLacUnidTransp($index)
    {
        unset($this->lacUnidTransp[$index]);
    }

    /**
     * Gets as lacUnidTransp
     *
     * Lacres das Unidades de Transporte
     *
     * @return LacUnidTranspType[]
     */
    public function getLacUnidTransp()
    {
        return $this->lacUnidTransp;
    }

    /**
     * Sets a new lacUnidTransp
     *
     * Lacres das Unidades de Transporte
     *
     * @param LacUnidTranspType[] $lacUnidTransp
     * @return self
     */
    public function setLacUnidTransp(array $lacUnidTransp)
    {
        $this->lacUnidTransp = $lacUnidTransp;
        return $this;
    }

    /**
     * Adds as infUnidCarga
     *
     * Informações das Unidades de Carga (Containeres/ULD/Outros)Dispositivo de carga
     * utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de carga,
     * vagão, contêiner de avião, palete de aeronave com rede ou palete de aeronave
     * com rede sobre um iglu.
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\MDFe\TUnidCargaType $infUnidCarga
     */
    public function addToInfUnidCarga(\NFePHP\MDFe\XsdType\MDFe\TUnidCargaType $infUnidCarga)
    {
        $this->infUnidCarga[] = $infUnidCarga;
        return $this;
    }

    /**
     * isset infUnidCarga
     *
     * Informações das Unidades de Carga (Containeres/ULD/Outros)Dispositivo de carga
     * utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de carga,
     * vagão, contêiner de avião, palete de aeronave com rede ou palete de aeronave
     * com rede sobre um iglu.
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetInfUnidCarga($index)
    {
        return isset($this->infUnidCarga[$index]);
    }

    /**
     * unset infUnidCarga
     *
     * Informações das Unidades de Carga (Containeres/ULD/Outros)Dispositivo de carga
     * utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de carga,
     * vagão, contêiner de avião, palete de aeronave com rede ou palete de aeronave
     * com rede sobre um iglu.
     *
     * @param scalar $index
     * @return void
     */
    public function unsetInfUnidCarga($index)
    {
        unset($this->infUnidCarga[$index]);
    }

    /**
     * Gets as infUnidCarga
     *
     * Informações das Unidades de Carga (Containeres/ULD/Outros)Dispositivo de carga
     * utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de carga,
     * vagão, contêiner de avião, palete de aeronave com rede ou palete de aeronave
     * com rede sobre um iglu.
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TUnidCargaType[]
     */
    public function getInfUnidCarga()
    {
        return $this->infUnidCarga;
    }

    /**
     * Sets a new infUnidCarga
     *
     * Informações das Unidades de Carga (Containeres/ULD/Outros)Dispositivo de carga
     * utilizada (Unit Load Device - ULD) significa todo tipo de contêiner de carga,
     * vagão, contêiner de avião, palete de aeronave com rede ou palete de aeronave
     * com rede sobre um iglu.
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TUnidCargaType[] $infUnidCarga
     * @return self
     */
    public function setInfUnidCarga(array $infUnidCarga)
    {
        $this->infUnidCarga = $infUnidCarga;
        return $this;
    }

    /**
     * Gets as qtdRat
     *
     * Quantidade rateada (Peso,Volume)
     *
     * @return string
     */
    public function getQtdRat()
    {
        return $this->qtdRat;
    }

    /**
     * Sets a new qtdRat
     *
     * Quantidade rateada (Peso,Volume)
     *
     * @param string $qtdRat
     * @return self
     */
    public function setQtdRat($qtdRat)
    {
        $this->qtdRat = $qtdRat;
        return $this;
    }
}
