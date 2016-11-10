<?php

namespace NFePHP\MDFe\XsdType\MDFe\TMDFeType\InfMDFeType;

/**
 * Class representing InfModalType
 */
class InfModalType
{

    /**
     * Versão do leiaute específico para o Modal
     *
     * @property string $versaoModal
     */
    private $versaoModal = null;

    /**
     * Informações do modal Rodoviário
     *
     * @property \NFePHP\MDFe\XsdType\Rodo\Rodo $rodo
     */
    private $rodo = null;

    /**
     * Gets as versaoModal
     *
     * Versão do leiaute específico para o Modal
     *
     * @return string
     */
    public function getVersaoModal()
    {
        return $this->versaoModal;
    }

    /**
     * Sets a new versaoModal
     *
     * Versão do leiaute específico para o Modal
     *
     * @param string $versaoModal
     * @return self
     */
    public function setVersaoModal($versaoModal)
    {
        $this->versaoModal = $versaoModal;
        return $this;
    }

    /**
     * Gets as Rodo
     *
     * Informações do modal Rodoviário
     *
     * @return \NFePHP\MDFe\XsdType\Rodo\Rodo
     */
    public function getRodo()
    {
        return $this->rodo;
    }

    /**
     * Sets a new rodo
     *
     * Informações do modal Rodoviário
     *
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo $rodo
     * @return self
     */
    public function setRodo(\NFePHP\MDFe\XsdType\Rodo\Rodo $rodo)
    {
        $this->rodo = $rodo;
        return $this;
    }
}
