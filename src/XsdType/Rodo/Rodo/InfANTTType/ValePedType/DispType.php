<?php

namespace NFePHP\MDFe\XsdType\Rodo\Rodo\InfANTTType\ValePedType;

/**
 * Class representing DispType
 */
class DispType
{

    /**
     * CNPJ da empresa fornecedora do Vale-Pedágio- CNPJ da Empresa Fornecedora do
     * Vale-Pedágio, ou seja, empresa que fornece ao Responsável pelo Pagamento do
     * Vale-Pedágio os dispositivos do Vale-Pedágio.
     *  - Informar os zeros não significativos.
     *
     * @property string $CNPJForn
     */
    private $CNPJForn = null;

    /**
     * CNPJ do responsável pelo pagamento do Vale-Pedágio- responsável pelo
     * pagamento do Vale Pedágio. Informar somente quando o responsável não for o
     * emitente do MDF-e.
     *  - Informar os zeros não significativos.
     *
     * @property string $CNPJPg
     */
    private $CNPJPg = null;

    /**
     * CNPJ do responsável pelo pagamento do Vale-PedágioInformar os zeros não
     * significativos.
     *
     * @property string $CPFPg
     */
    private $CPFPg = null;

    /**
     * Número do comprovante de compraNúmero de ordem do comprovante de compra do
     * Vale-Pedágio fornecido para cada veículo ou combinação veicular, por viagem.
     *
     * @property string $nCompra
     */
    private $nCompra = null;

    /**
     * Valor do Vale-PedagioNúmero de ordem do comprovante de compra do Vale-Pedágio
     * fornecido para cada veículo ou combinação veicular, por viagem.
     *
     * @property string $vValePed
     */
    private $vValePed = null;

    /**
     * Gets as CNPJForn
     *
     * CNPJ da empresa fornecedora do Vale-Pedágio- CNPJ da Empresa Fornecedora do
     * Vale-Pedágio, ou seja, empresa que fornece ao Responsável pelo Pagamento do
     * Vale-Pedágio os dispositivos do Vale-Pedágio.
     *  - Informar os zeros não significativos.
     *
     * @return string
     */
    public function getCNPJForn()
    {
        return $this->CNPJForn;
    }

    /**
     * Sets a new CNPJForn
     *
     * CNPJ da empresa fornecedora do Vale-Pedágio- CNPJ da Empresa Fornecedora do
     * Vale-Pedágio, ou seja, empresa que fornece ao Responsável pelo Pagamento do
     * Vale-Pedágio os dispositivos do Vale-Pedágio.
     *  - Informar os zeros não significativos.
     *
     * @param string $CNPJForn
     * @return self
     */
    public function setCNPJForn($CNPJForn)
    {
        $this->CNPJForn = $CNPJForn;
        return $this;
    }

    /**
     * Gets as CNPJPg
     *
     * CNPJ do responsável pelo pagamento do Vale-Pedágio- responsável pelo
     * pagamento do Vale Pedágio. Informar somente quando o responsável não for o
     * emitente do MDF-e.
     *  - Informar os zeros não significativos.
     *
     * @return string
     */
    public function getCNPJPg()
    {
        return $this->CNPJPg;
    }

    /**
     * Sets a new CNPJPg
     *
     * CNPJ do responsável pelo pagamento do Vale-Pedágio- responsável pelo
     * pagamento do Vale Pedágio. Informar somente quando o responsável não for o
     * emitente do MDF-e.
     *  - Informar os zeros não significativos.
     *
     * @param string $CNPJPg
     * @return self
     */
    public function setCNPJPg($CNPJPg)
    {
        $this->CNPJPg = $CNPJPg;
        return $this;
    }

    /**
     * Gets as CPFPg
     *
     * CNPJ do responsável pelo pagamento do Vale-PedágioInformar os zeros não
     * significativos.
     *
     * @return string
     */
    public function getCPFPg()
    {
        return $this->CPFPg;
    }

    /**
     * Sets a new CPFPg
     *
     * CNPJ do responsável pelo pagamento do Vale-PedágioInformar os zeros não
     * significativos.
     *
     * @param string $CPFPg
     * @return self
     */
    public function setCPFPg($CPFPg)
    {
        $this->CPFPg = $CPFPg;
        return $this;
    }

    /**
     * Gets as nCompra
     *
     * Número do comprovante de compraNúmero de ordem do comprovante de compra do
     * Vale-Pedágio fornecido para cada veículo ou combinação veicular, por viagem.
     *
     * @return string
     */
    public function getNCompra()
    {
        return $this->nCompra;
    }

    /**
     * Sets a new nCompra
     *
     * Número do comprovante de compraNúmero de ordem do comprovante de compra do
     * Vale-Pedágio fornecido para cada veículo ou combinação veicular, por viagem.
     *
     * @param string $nCompra
     * @return self
     */
    public function setNCompra($nCompra)
    {
        $this->nCompra = $nCompra;
        return $this;
    }

    /**
     * Gets as vValePed
     *
     * Valor do Vale-PedagioNúmero de ordem do comprovante de compra do Vale-Pedágio
     * fornecido para cada veículo ou combinação veicular, por viagem.
     *
     * @return string
     */
    public function getVValePed()
    {
        return $this->vValePed;
    }

    /**
     * Sets a new vValePed
     *
     * Valor do Vale-PedagioNúmero de ordem do comprovante de compra do Vale-Pedágio
     * fornecido para cada veículo ou combinação veicular, por viagem.
     *
     * @param string $vValePed
     * @return self
     */
    public function setVValePed($vValePed)
    {
        $this->vValePed = $vValePed;
        return $this;
    }
}
