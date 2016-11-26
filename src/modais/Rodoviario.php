<?php

/*
 * Esta classe define o modal Rodoviario
 * @Author Marcos Dantas <marcos.adantas@hotmail.com>
 * 20/11/2016 - 21:25
 */

namespace NFePHP\MDFe\Modais;

use NFePHP\MDFe\ModalRender;

class Rodoviario extends ModalRender {
	private $reflection;

	/*
		    * Tags Primarias
	*/
	private $rodo;
	private $infANTT;
	private $veicTracao;
	private $veicReboque;
	private $codAgPorto;
	private $lacRodo;

	/*
		    * Tags Secondarias infANTT
	*/
	private $anttRNTRC;
	private $infCIOT;
	private $valePed;
	private $infContratante;

	/*
		    * Tags Secondarias veicTracao
	*/
	private $tracaoCondutor;

	public function __construct() {
		$this->reflection = new \ReflectionClass($this);
	}

	/*
		    * Verifica campos e retorna nao nulos
	*/
	private function nulos($arr) {
		$prop = [];
		foreach ($arr as $key => $conjunto) {
			if ($conjunto != null) {
				$prop[$key] = $conjunto;
			}
		}
		return $prop;
	}

	/*
		     *@desc Retorna um array com multiplos grupos
	*/
	private function multiArray($grupo, $subgrupo) {
		$prop = [];
		foreach ($subgrupo as $conjunto) {
			$prop[][$grupo] = $conjunto;
		}
		return $prop;
	}

	/*
		     * Monta a hierarquia do documento infANTT se houver
	*/
	private function infANTT() {
		if ($this->anttRNTRC != null) {
			$this->infANTT['RNTRC'] = $this->anttRNTRC;
		}

		if ($this->infCIOT != null) {
			$this->infANTT[] = $this->multiArray('infCIOT', $this->infCIOT);
		}

		if ($this->valePed != null) {
			$this->infANTT['valePed'] = $this->multiArray('disp', $this->valePed);
		}

		if ($this->infContratante != null) {
			$this->infANTT[] = $this->multiArray('infContratante', $this->infContratante);
		}

		//Toda a informação carregada no documento raiz
		if ($this->infANTT != null) {
			$this->rodo['infANTT'] = $this->infANTT;
		}
	}

	/*
		     * Define o documento veicTracao
		     * Verifica se veicTracao ja foi definido
		     * Entao verifica os condutores
		     * Ambos sao obrigatorios
	*/
	private function veicTracao() {
		if ($this->veicTracao != null) {
			if ($this->tracaoCondutor != null) {
				$this->veicTracao[] = $this->multiArray('infCondutores', $this->tracaoCondutor);
			} else {
				Throw new \Exception('Nao foi definido nenhum condutor para o veiculo');
			}
			$this->rodo['veicTracao'] = $this->veicTracao;
		} else {
			Throw new \Exception('Nao foi definido nenhum veiculo de tracao');
		}
	}

	private function veicReboque() {
		if ($this->veicReboque != null) {
			$this->rodo[] = $this->multiArray('veicReboque', $this->veicReboque);
		} else {
			Throw new \Exception('Nao foi definido nenhum reboque para esse mdfe');
		}
	}

	private function codAgPorto() {
		if ($this->codAgPorto != null) {
			$this->rodo['codAgPorto'] = $this->codAgPorto;
		}
	}

	private function lacRodo() {
		if ($this->lacRodo != null) {
			$this->rodo[] = $this->multiArray('lacRodo', $this->lacRodo);
		}
	}

	/*
		     * Ler todas as propriedades do modal
	*/
	public function rodo() {
		$this->infANTT();
		$this->veicTracao();
		$this->veicReboque();
		$this->codAgPorto();
		$this->lacRodo();
		return $this->rodo;
	}

	/*
		     * Define o registro nacional de transportes terrestres.
	*/
	public function setAnttRNTRC($RNTRC) {
		$this->anttRNTRC = $RNTRC;
		return $this;
	}

	public function getAnttRNTRC() {
		return $this->anttRNTRC;
	}

	/*
		     * Definir um ciot
	*/
	public function setAnttCIOT($ciot, $identificador) {
		if (strlen($identificador) > 11) {
			$this->infCIOT[] = ['CIOT' => $ciot, 'CNPJ' => $identificador];
		} else {
			$this->infCIOT[] = ['CIOT' => $ciot, 'CPF' => $identificador];
		}
		return $this;
	}

	public function getAnttCIOT() {
		return $this->infCIOT;
	}

	/*
		     * Define vale pedagio
	*/
	public function setAnttValePed($cnpjForn, $identificadorPG, $nCompra, $vVale) {
		$prop['CNPJForn'] = $cnpjForn;
		if (strlen($identificadorPG) > 11) {
			$prop['CNPJPg'] = $identificadorPG;
		} else {
			$prop['CPFPg'] = $identificadorPG;
		}
		$prop['nCompra'] = $nCompra;
		$prop['vValePed'] = $vVale;
		$this->valePed[] = $prop;
		return $this;
	}

	public function getAnttValePed() {
		return $this->valePed;
	}

	/*
		     * Define um contratante
	*/
	public function setAnttContratante($identificador) {
		if (strlen($identificador) > 11) {
			$this->infContratante[] = ['CNPJ' => $identificador];
		} else {
			$this->infContratante[] = ['CPF' => $identificador];
		}
		return $this;
	}

	/*
		     * @desc Define um veiculo de tracao para o mdfe
		     * E possivel definir o proprietario ao passar um array de acordo com o manual
	*/
	public function setTracao(
		$cInt = null,
		$placa,
		$RENAVAM = null,
		$tara,
		$capKG = null,
		$capM3 = null,
		$propietario = null
	) {
		$this->veicTracao = $this->nulos([
			'cInt' => $cInt,
			'placa' => $placa,
			'RENAVAM' => $RENAVAM,
			'tara' => $tara,
			'capKG' => $capKG,
			'capM3' => $capM3,
		]);

		if ($propietario != null) {
			$this->veicTracao['prop'] = $propietario;
		}
		return $this;
	}

	public function getTracao() {
		return $this->veicTracao;
	}

	/*
		     * Define um condutor para o veiculo
		     * No maximo 10 condutores poderao conduzir um modal
	*/
	public function setTracaoCondutor($xNome, $CPF, $tpRod, $tpCar, $UF) {
		if (count($this->tracaoCondutor) < 10) {
			$this->tracaoCondutor[] = [
				'xNome' => $xNome,
				'CPF' => $CPF,
				'tpRod' => $tpRod,
				'tpCar' => $tpCar,
				'UF' => $UF,
			];
		} else {
			Throw new \Exception('Excedeu o número maximo de condutores para o modal');
		}
		return $this;
	}

	public function getTracaoCondutor() {
		return $this->tracaoCondutor;
	}

	/*
		     * Define um reboque para o veiculo
		     * No maximo 3 reboques podem ser conduzidos por um veiculo
		     * E possivel definir o proprietario ao passar um array de acordo com o manual
	*/
	public function setReboque(
		$cInt = null,
		$placa,
		$RENAVAM = null,
		$tara,
		$capKG = null,
		$capM3 = null,
		$propietario = null
	) {
		if (count($this->veicReboque) < 3) {
			$prop = [];
			$prop = $this->nulos([
				'cInt' => $cInt,
				'placa' => $placa,
				'RENAVAM' => $RENAVAM,
				'tara' => $tara,
				'capKG' => $capKG,
				'capM3' => $capM3,
			]);

			if ($propietario != null) {
				$prop['prop'] = $propietario;
			}
			$this->veicReboque[] = $prop;
		} else {
			Throw new \Exception('Mais de 3 reboques foram definidos para este transporte!');
		}
		return $this;
	}

	public function getReboque() {
		return $this->veicReboque;
	}

	/*
		     * Define um codigo de agendamento no porto
		     * O que e isso ?
	*/
	public function setCodAgPorto($cod) {
		$this->codAgPorto = $cod;
	}

	public function getCodAgPorto() {
		return $this->codAgPorto;
	}

	/*
		     * Define lacres para o transporte
		     * Lacres utilizados nos caminhoes e containers
		     * Na fechadura para garantir a integridade da carga ate o destinatario
	*/
	public function setLacres($cod) {
		$this->lacRodo[] = ['nLacre' => $cod];
	}

	public function getLacres() {
		return $this->lacRodo;
	}
};
