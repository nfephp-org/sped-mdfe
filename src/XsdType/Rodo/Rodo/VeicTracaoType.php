<?php

namespace NFePHP\MDFe\XsdType\Rodo\Rodo;

/**
 * Class representing VeicTracaoType
 */
class VeicTracaoType
{

    /**
     * Código interno do veículo
     *
     * @property string $cInt
     */
    private $cInt = null;

    /**
     * Placa do veículo
     *
     * @property string $placa
     */
    private $placa = null;

    /**
     * RENAVAM do veículo
     *
     * @property string $RENAVAM
     */
    private $RENAVAM = null;

    /**
     * Tara em KG
     *
     * @property string $tara
     */
    private $tara = null;

    /**
     * Capacidade em KG
     *
     * @property string $capKG
     */
    private $capKG = null;

    /**
     * Capacidade em M3
     *
     * @property string $capM3
     */
    private $capM3 = null;

    /**
     * Proprietários do Veículo.
     * Só preenchido quando o veículo não pertencer à empresa emitente do MDF-e
     *
     * @property \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType\PropType $prop
     */
    private $prop = null;

    /**
     * Informações do(s) Condutor(s) do veículo
     *
     * @property \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType\CondutorType[] $condutor
     */
    private $condutor = null;

    /**
     * Tipo de RodadoPreencher com:
     *  01 - Truck;
     *  02 - Toco;
     *  03 - Cavalo Mecânico;
     *  04 - VAN;
     *  05 - Utilitário;
     *  06 - Outros.
     *
     * @property string $tpRod
     */
    private $tpRod = null;

    /**
     * Tipo de CarroceriaPreencher com:
     *  00 - não aplicável;
     *  01 - Aberta;
     *  02 - Fechada/Baú;
     *  03 - Granelera;
     *  04 - Porta Container;
     *  05 - Sider
     *
     * @property string $tpCar
     */
    private $tpCar = null;

    /**
     * UF em que veículo está licenciadoSigla da UF de licenciamento do veículo.
     *
     * @property string $UF
     */
    private $UF = null;

    /**
     * Gets as cInt
     *
     * Código interno do veículo
     *
     * @return string
     */
    public function getCInt()
    {
        return $this->cInt;
    }

    /**
     * Sets a new cInt
     *
     * Código interno do veículo
     *
     * @param string $cInt
     * @return self
     */
    public function setCInt($cInt)
    {
        $this->cInt = $cInt;
        return $this;
    }

    /**
     * Gets as placa
     *
     * Placa do veículo
     *
     * @return string
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Sets a new placa
     *
     * Placa do veículo
     *
     * @param string $placa
     * @return self
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;
        return $this;
    }

    /**
     * Gets as RENAVAM
     *
     * RENAVAM do veículo
     *
     * @return string
     */
    public function getRENAVAM()
    {
        return $this->RENAVAM;
    }

    /**
     * Sets a new RENAVAM
     *
     * RENAVAM do veículo
     *
     * @param string $RENAVAM
     * @return self
     */
    public function setRENAVAM($RENAVAM)
    {
        $this->RENAVAM = $RENAVAM;
        return $this;
    }

    /**
     * Gets as tara
     *
     * Tara em KG
     *
     * @return string
     */
    public function getTara()
    {
        return $this->tara;
    }

    /**
     * Sets a new tara
     *
     * Tara em KG
     *
     * @param string $tara
     * @return self
     */
    public function setTara($tara)
    {
        $this->tara = $tara;
        return $this;
    }

    /**
     * Gets as capKG
     *
     * Capacidade em KG
     *
     * @return string
     */
    public function getCapKG()
    {
        return $this->capKG;
    }

    /**
     * Sets a new capKG
     *
     * Capacidade em KG
     *
     * @param string $capKG
     * @return self
     */
    public function setCapKG($capKG)
    {
        $this->capKG = $capKG;
        return $this;
    }

    /**
     * Gets as capM3
     *
     * Capacidade em M3
     *
     * @return string
     */
    public function getCapM3()
    {
        return $this->capM3;
    }

    /**
     * Sets a new capM3
     *
     * Capacidade em M3
     *
     * @param string $capM3
     * @return self
     */
    public function setCapM3($capM3)
    {
        $this->capM3 = $capM3;
        return $this;
    }

    /**
     * Gets as prop
     *
     * Proprietários do Veículo.
     * Só preenchido quando o veículo não pertencer à empresa emitente do MDF-e
     *
     * @return \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType\PropType
     */
    public function getProp()
    {
        return $this->prop;
    }

    /**
     * Sets a new prop
     *
     * Proprietários do Veículo.
     * Só preenchido quando o veículo não pertencer à empresa emitente do MDF-e
     *
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType\PropType $prop
     * @return self
     */
    public function setProp(\NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType\PropType $prop)
    {
        $this->prop = $prop;
        return $this;
    }

    /**
     * Adds as condutor
     *
     * Informações do(s) Condutor(s) do veículo
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType\CondutorType $condutor
     */
    public function addToCondutor(\NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType\CondutorType $condutor)
    {
        $this->condutor[] = $condutor;
        return $this;
    }

    /**
     * isset condutor
     *
     * Informações do(s) Condutor(s) do veículo
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetCondutor($index)
    {
        return isset($this->condutor[$index]);
    }

    /**
     * unset condutor
     *
     * Informações do(s) Condutor(s) do veículo
     *
     * @param scalar $index
     * @return void
     */
    public function unsetCondutor($index)
    {
        unset($this->condutor[$index]);
    }

    /**
     * Gets as condutor
     *
     * Informações do(s) Condutor(s) do veículo
     *
     * @return \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType\CondutorType[]
     */
    public function getCondutor()
    {
        return $this->condutor;
    }

    /**
     * Sets a new condutor
     *
     * Informações do(s) Condutor(s) do veículo
     *
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType\CondutorType[] $condutor
     * @return self
     */
    public function setCondutor(array $condutor)
    {
        $this->condutor = $condutor;
        return $this;
    }

    /**
     * Gets as tpRod
     *
     * Tipo de RodadoPreencher com:
     *  01 - Truck;
     *  02 - Toco;
     *  03 - Cavalo Mecânico;
     *  04 - VAN;
     *  05 - Utilitário;
     *  06 - Outros.
     *
     * @return string
     */
    public function getTpRod()
    {
        return $this->tpRod;
    }

    /**
     * Sets a new tpRod
     *
     * Tipo de RodadoPreencher com:
     *  01 - Truck;
     *  02 - Toco;
     *  03 - Cavalo Mecânico;
     *  04 - VAN;
     *  05 - Utilitário;
     *  06 - Outros.
     *
     * @param string $tpRod
     * @return self
     */
    public function setTpRod($tpRod)
    {
        $this->tpRod = $tpRod;
        return $this;
    }

    /**
     * Gets as tpCar
     *
     * Tipo de CarroceriaPreencher com:
     *  00 - não aplicável;
     *  01 - Aberta;
     *  02 - Fechada/Baú;
     *  03 - Granelera;
     *  04 - Porta Container;
     *  05 - Sider
     *
     * @return string
     */
    public function getTpCar()
    {
        return $this->tpCar;
    }

    /**
     * Sets a new tpCar
     *
     * Tipo de CarroceriaPreencher com:
     *  00 - não aplicável;
     *  01 - Aberta;
     *  02 - Fechada/Baú;
     *  03 - Granelera;
     *  04 - Porta Container;
     *  05 - Sider
     *
     * @param string $tpCar
     * @return self
     */
    public function setTpCar($tpCar)
    {
        $this->tpCar = $tpCar;
        return $this;
    }

    /**
     * Gets as UF
     *
     * UF em que veículo está licenciadoSigla da UF de licenciamento do veículo.
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
     * UF em que veículo está licenciadoSigla da UF de licenciamento do veículo.
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
