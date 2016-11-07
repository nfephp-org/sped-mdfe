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


}

