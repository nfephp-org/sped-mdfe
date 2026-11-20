<?php

use NFePHP\MDFe\Make;
use PHPUnit\Framework\TestCase;

class MakeTest extends TestCase
{
    const ERRO_CIOT = 'Tag infCIOT é obrigatória para modal rodoviário com '
        . 'tpEmit 1 ou 3, ou tpEmit 2 com tpTransp informado (NT 2026.001)!';

    /**
     * @dataProvider emitentesQueExigemCiot
     */
    public function test_shouldRequireInfCiotWhenNt2026001Applies($tpEmit, $tpTransp)
    {
        $errors = $this->montaRodoviario($tpEmit, $tpTransp, false);

        $this->assertContains(self::ERRO_CIOT, $errors);
    }

    public function emitentesQueExigemCiot()
    {
        return [
            'prestador de serviço de transporte' => ['1', null],
            'transportador com CT-e globalizado' => ['3', null],
            'carga própria com tpTransp' => ['2', '1'],
        ];
    }

    /**
     * @dataProvider emitentesQueExigemCiot
     */
    public function test_shouldNotRequireInfCiotWhenItIsInformed($tpEmit, $tpTransp)
    {
        $errors = $this->montaRodoviario($tpEmit, $tpTransp, true);

        $this->assertNotContains(self::ERRO_CIOT, $errors);
    }

    public function test_shouldNotRequireInfCiotForOwnCargoWithoutTpTransp()
    {
        $errors = $this->montaRodoviario('2', null, false);

        $this->assertNotContains(self::ERRO_CIOT, $errors);
    }

    private function montaRodoviario($tpEmit, $tpTransp, $comCiot)
    {
        $mdfe = new Make();

        $std = new \stdClass();
        $std->cUF = '35';
        $std->tpAmb = '2';
        $std->tpEmit = $tpEmit;
        $std->tpTransp = $tpTransp;
        $std->mod = '58';
        $std->serie = '1';
        $std->nMDF = '1';
        $std->cMDF = '12345678';
        $std->cDV = '0';
        $std->modal = '1';
        $std->dhEmi = '2026-11-23T08:00:00-03:00';
        $std->tpEmis = '1';
        $std->procEmi = '0';
        $std->verProc = '1.0';
        $std->UFIni = 'SP';
        $std->UFFim = 'SP';
        $mdfe->tagide($std);

        $std = new \stdClass();
        $std->CNPJ = '11222333000181';
        $std->IE = '111111111111';
        $std->xNome = 'EMITENTE TESTE';
        $mdfe->tagemit($std);

        $std = new \stdClass();
        $std->xLgr = 'RUA CENTRAL';
        $std->nro = '1';
        $std->xBairro = 'CENTRO';
        $std->cMun = '3550308';
        $std->xMun = 'SAO PAULO';
        $std->UF = 'SP';
        $mdfe->tagenderEmit($std);

        $std = new \stdClass();
        $std->RNTRC = '12345678';
        $mdfe->taginfANTT($std);

        if ($comCiot) {
            $std = new \stdClass();
            $std->CIOT = '123456789012';
            $std->CNPJ = '11222333000181';
            $mdfe->taginfCIOT($std);
        }

        $std = new \stdClass();
        $std->vCarga = '1000.00';
        $std->cUnid = '01';
        $std->qCarga = '1000.0000';
        $mdfe->tagtot($std);

        try {
            $mdfe->monta();
        } catch (\RuntimeException $e) {
            // outras tags obrigatórias ficam de fora; só interessam os erros
        }

        return $mdfe->getErrors();
    }
}
