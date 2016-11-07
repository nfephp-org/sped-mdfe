<?php

namespace NFePHP\MDFe\XsdType\Rodo\Rodo\VeicTracaoType;

/**
 * Class representing CondutorType
 */
class CondutorType
{

    /**
     * Nome do Condutor
     *
     * @property string $xNome
     */
    private $xNome = null;

    /**
     * CPF do Condutor
     *
     * @property string $CPF
     */
    private $CPF = null;

    /**
     * Gets as xNome
     *
     * Nome do Condutor
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
     * Nome do Condutor
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
     * Gets as CPF
     *
     * CPF do Condutor
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
     * CPF do Condutor
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
