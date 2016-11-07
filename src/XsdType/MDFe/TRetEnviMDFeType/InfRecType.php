<?php

namespace NFePHP\MDFe\XsdType\MDFe\TRetEnviMDFeType;

/**
 * Class representing InfRecType
 */
class InfRecType
{

    /**
     * Número do Recibo
     *
     * @property string $nRec
     */
    private $nRec = null;

    /**
     * Data e hora do recebimento, no formato AAAA-MM-DDTHH:MM:SS
     *
     * @property \DateTime $dhRecbto
     */
    private $dhRecbto = null;

    /**
     * Tempo médio de resposta do serviço (em segundos) dos últimos 5 minutos
     *
     * @property integer $tMed
     */
    private $tMed = null;

    /**
     * Gets as nRec
     *
     * Número do Recibo
     *
     * @return string
     */
    public function getNRec()
    {
        return $this->nRec;
    }

    /**
     * Sets a new nRec
     *
     * Número do Recibo
     *
     * @param string $nRec
     * @return self
     */
    public function setNRec($nRec)
    {
        $this->nRec = $nRec;
        return $this;
    }

    /**
     * Gets as dhRecbto
     *
     * Data e hora do recebimento, no formato AAAA-MM-DDTHH:MM:SS
     *
     * @return \DateTime
     */
    public function getDhRecbto()
    {
        return $this->dhRecbto;
    }

    /**
     * Sets a new dhRecbto
     *
     * Data e hora do recebimento, no formato AAAA-MM-DDTHH:MM:SS
     *
     * @param \DateTime $dhRecbto
     * @return self
     */
    public function setDhRecbto(\DateTime $dhRecbto)
    {
        $this->dhRecbto = $dhRecbto;
        return $this;
    }

    /**
     * Gets as tMed
     *
     * Tempo médio de resposta do serviço (em segundos) dos últimos 5 minutos
     *
     * @return integer
     */
    public function getTMed()
    {
        return $this->tMed;
    }

    /**
     * Sets a new tMed
     *
     * Tempo médio de resposta do serviço (em segundos) dos últimos 5 minutos
     *
     * @param integer $tMed
     * @return self
     */
    public function setTMed($tMed)
    {
        $this->tMed = $tMed;
        return $this;
    }
}
