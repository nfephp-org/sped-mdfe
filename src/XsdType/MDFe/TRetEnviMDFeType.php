<?php

namespace NFePHP\MDFe\XsdType\MDFe;

/**
 * Class representing TRetEnviMDFeType
 *
 * Tipo Retorno do Pedido de Concessão de Autorização do MDF-e
 * XSD Type: TRetEnviMDFe
 */
class TRetEnviMDFeType
{

    /**
     * @property string $versao
     */
    private $versao = null;

    /**
     * Identificação do Ambiente:
     * 1 - Produção
     * 2 - Homologação
     *
     * @property mixed $tpAmb
     */
    private $tpAmb = null;

    /**
     * Identificação da UF
     *
     * @property string $cUF
     */
    private $cUF = null;

    /**
     * Versão do Aplicativo que recebeu o Arquivo.
     *
     * @property string $verAplic
     */
    private $verAplic = null;

    /**
     * Código do status da mensagem enviada.
     *
     * @property string $cStat
     */
    private $cStat = null;

    /**
     * Descrição literal do status do serviço solicitado.
     *
     * @property string $xMotivo
     */
    private $xMotivo = null;

    /**
     * Dados do Recibo do Arquivo
     *
     * @property \NFePHP\MDFe\XsdType\MDFe\TRetEnviMDFeType\InfRecType $infRec
     */
    private $infRec = null;

    /**
     * Gets as versao
     *
     * @return string
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Sets a new versao
     *
     * @param string $versao
     * @return self
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;
        return $this;
    }

    /**
     * Gets as tpAmb
     *
     * Identificação do Ambiente:
     * 1 - Produção
     * 2 - Homologação
     *
     * @return mixed
     */
    public function getTpAmb()
    {
        return $this->tpAmb;
    }

    /**
     * Sets a new tpAmb
     *
     * Identificação do Ambiente:
     * 1 - Produção
     * 2 - Homologação
     *
     * @param mixed $tpAmb
     * @return self
     */
    public function setTpAmb($tpAmb)
    {
        $this->tpAmb = $tpAmb;
        return $this;
    }

    /**
     * Gets as cUF
     *
     * Identificação da UF
     *
     * @return string
     */
    public function getCUF()
    {
        return $this->cUF;
    }

    /**
     * Sets a new cUF
     *
     * Identificação da UF
     *
     * @param string $cUF
     * @return self
     */
    public function setCUF($cUF)
    {
        $this->cUF = $cUF;
        return $this;
    }

    /**
     * Gets as verAplic
     *
     * Versão do Aplicativo que recebeu o Arquivo.
     *
     * @return string
     */
    public function getVerAplic()
    {
        return $this->verAplic;
    }

    /**
     * Sets a new verAplic
     *
     * Versão do Aplicativo que recebeu o Arquivo.
     *
     * @param string $verAplic
     * @return self
     */
    public function setVerAplic($verAplic)
    {
        $this->verAplic = $verAplic;
        return $this;
    }

    /**
     * Gets as cStat
     *
     * Código do status da mensagem enviada.
     *
     * @return string
     */
    public function getCStat()
    {
        return $this->cStat;
    }

    /**
     * Sets a new cStat
     *
     * Código do status da mensagem enviada.
     *
     * @param string $cStat
     * @return self
     */
    public function setCStat($cStat)
    {
        $this->cStat = $cStat;
        return $this;
    }

    /**
     * Gets as xMotivo
     *
     * Descrição literal do status do serviço solicitado.
     *
     * @return string
     */
    public function getXMotivo()
    {
        return $this->xMotivo;
    }

    /**
     * Sets a new xMotivo
     *
     * Descrição literal do status do serviço solicitado.
     *
     * @param string $xMotivo
     * @return self
     */
    public function setXMotivo($xMotivo)
    {
        $this->xMotivo = $xMotivo;
        return $this;
    }

    /**
     * Gets as infRec
     *
     * Dados do Recibo do Arquivo
     *
     * @return \NFePHP\MDFe\XsdType\MDFe\TRetEnviMDFeType\InfRecType
     */
    public function getInfRec()
    {
        return $this->infRec;
    }

    /**
     * Sets a new infRec
     *
     * Dados do Recibo do Arquivo
     *
     * @param \NFePHP\MDFe\XsdType\MDFe\TRetEnviMDFeType\InfRecType $infRec
     * @return self
     */
    public function setInfRec(\NFePHP\MDFe\XsdType\MDFe\TRetEnviMDFeType\InfRecType $infRec)
    {
        $this->infRec = $infRec;
        return $this;
    }
}
