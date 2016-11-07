<?php

namespace NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType;

/**
 * Class representing ValePedType
 */
class ValePedType
{

    /**
     * Informações dos dispositivos do Vale Pedágio
     *
     * @property \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\ValePedType\DispType[]
     * $disp
     */
    private $disp = null;

    /**
     * Adds as disp
     *
     * Informações dos dispositivos do Vale Pedágio
     *
     * @return self
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\ValePedType\DispType $disp
     */
    public function addToDisp(\NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\ValePedType\DispType $disp)
    {
        $this->disp[] = $disp;
        return $this;
    }

    /**
     * isset disp
     *
     * Informações dos dispositivos do Vale Pedágio
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetDisp($index)
    {
        return isset($this->disp[$index]);
    }

    /**
     * unset disp
     *
     * Informações dos dispositivos do Vale Pedágio
     *
     * @param scalar $index
     * @return void
     */
    public function unsetDisp($index)
    {
        unset($this->disp[$index]);
    }

    /**
     * Gets as disp
     *
     * Informações dos dispositivos do Vale Pedágio
     *
     * @return \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\ValePedType\DispType[]
     */
    public function getDisp()
    {
        return $this->disp;
    }

    /**
     * Sets a new disp
     *
     * Informações dos dispositivos do Vale Pedágio
     *
     * @param \NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\ValePedType\DispType[] $disp
     * @return self
     */
    public function setDisp(array $disp)
    {
        $this->disp = $disp;
        return $this;
    }
}
