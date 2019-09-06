<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once '../bootstrap.php';

use NFePHP\MDFe\Make;

$config = [
   "atualizacao" => "2019-06-15 08:29:21",
   "tpAmb" => 2,
   "razaosocial" => "SOFTWARE & HARDWARE INFORMATICA - ME",
   "siglaUF" => "SP",
   "cnpj" => "11222333444455",
   "inscricaomunicipal" => "11223",
   "codigomunicipio" => "3518800",
   "schemes" => "V3",
   "versao" => "3.00"
];

$configJson = json_encode($config);

$mdfe = new NFePHP\MDFe\Make();

/*
 * Grupo ide ( Identificação )
 */
$std = new \stdClass();
$std->cMunCarrega = '3518800';
$std->xMunCarrega = 'GUARULHOS';
$mdfe->taginfMunCarrega($std);

$std = new \stdClass();
$std->UFPer = ['MG','GO','TO','MA'];
$mdfe->taginfPercurso($std);

$std = new \stdClass();
$std->cUF = '35';
$std->tpAmb = '1';
$std->tpEmit = '1';
$std->tpTransp = 'ETC';
$std->mod = '58';
$std->serie = '0';
$std->nMDF = '5766';
$std->cMDF = '00025563';
$std->cDV = '5';
$std->modal = '1';
$std->dhEmi = '2019-04-04T16:31:48-03:00';
$std->tpEmis = '1';
$std->procEmi = '0';
$std->verProc = '1.6';
$std->UFIni = 'SP';
$std->UFFim = 'PA';
$mdfe->tagide($std);
/*
 * fim ide
 */
 
/*
 * Grupo emit ( Emitente )
 */
$std = new \stdClass();
$std->CNPJ = '00000000000000';
$std->IE = '111111111111';
$std->xNome = 'SIMULADA LOGISTICA LTDA- EPP';
$std->xFant = 'SIMULADA LOGISTICA LTDA- EPP';
$mdfe->tagemit($std);

$std = new \stdClass();
$std->xLgr = 'RUA CENTRAL';
$std->nro = '0001';
$std->xBairro = 'CENTRO';
$std->cMun = '3518800';
$std->xMun = 'GUARULHOS';
$std->CEP = '07000000';
$std->UF = 'SP';
$std->fone = '1125252424';
$std->email = 'simulada@simulada.com.br';
$mdfe->tagenderEmit($std);
/*
 * fim emit
 */
 
/*
 * Grupo rodo ( Rodoviário )
 */
 
    /* Grupo infANTT */
    $stdinfANTT = new \stdClass();
    $stdinfANTT->RNTRC = '12345678';
        /* informações do CIOT */
        $stdinfCIOT = new \stdClass();
        $stdinfCIOT->CIOT = '123456789012';
        $stdinfCIOT->CPF = '11122233344';
        $stdinfCIOT->CNPJ = '11222333444455';

    $stdinfANTT->infCIOT = [$stdinfCIOT];

        /* informações do Vale Pedágio */
        $stdvalePed = new \stdClass();
        $stdvalePed->CNPJForn = '11222333444455';
        $stdvalePed->CNPJPg = '66777888999900';
        $stdvalePed->CPFPg = '11122233355';
        $stdvalePed->nCompra = '777778888999999';
        $stdvalePed->vValePed = '100.00';

    $stdinfANTT->valePed = [$stdvalePed];
        
        /* informações do contratante */
        $stdinfContratante = new \stdClass();
        $stdinfContratante ->CNPJ = '09230232000372';
        
    $stdinfANTT->infContratante = [$stdinfContratante];

    $mdfe->taginfANTT($stdinfANTT);
    /* fim infANTT */

    /* Grupo veicTracao */
    $stdveicTracao = new \stdClass();
    $stdveicTracao->cInt = '01';
    $stdveicTracao->placa = 'DBL6040';
    $stdveicTracao->tara = '8350';
    $stdveicTracao->capKG = '8350';
    $stdveicTracao->tpRod = '03';
    $stdveicTracao->tpCar = '02';
    $stdveicTracao->UF = 'PA';

    $stdcondutor = new \stdClass();
    $stdcondutor->xNome = 'JOAO DA SILVA';
    $stdcondutor->CPF = '11122233344';

    $stdveicTracao->condutor = [$stdcondutor];

    $mdfe->tagveicTracao($stdveicTracao);

    /* fim veicTracao */

    /* Grupo veicReboque */
    $stdveicReboque = new \stdClass();
    $stdveicReboque->cInt = '02';
    $stdveicReboque->placa = 'XXX1111';
    $stdveicReboque->tara = '8350';
    $stdveicReboque->capKG = '15000';
    $stdveicReboque->tpCar = '02';
    $stdveicReboque->UF = 'SP';

    $mdfe->tagveicReboque($stdveicReboque);

    /* fim veicReboque */

/* fim rodo */

/*
 * Grupo infDoc ( Documentos fiscais )
 */

$std = new \stdClass();
$std->cMunDescarga = '1502400';
$std->xMunDescarga = 'CASTANHAL';
$mdfe->taginfMunDescarga($std);

/* infCTe */
$std = new \stdClass();
$std->chCTe = '35310800000000000372570010001999091000027765';
$std->SegCodBarra = '012345678901234567890123456789012345';
$std->indReentrega = '1';

    /* Informações das Unidades de Transporte (Carreta/Reboque/Vagão) */
    $stdinfUnidTransp = new \stdClass();
    $stdinfUnidTransp->tpUnidTransp = '1';
    $stdinfUnidTransp->idUnidTransp = 'AAA-1111';

        /* Lacres das Unidades de Transporte */
        $stdlacUnidTransp = new \stdClass();
        $stdlacUnidTransp->nLacre = ['00000001','00000002'];

        $stdinfUnidTransp->lacUnidTransp = $stdlacUnidTransp;

        /* Informações das Unidades de Carga (Containeres/ULD/Outros) */
        $stdinfUnidCarga = new \stdClass();
        $stdinfUnidCarga->tpUnidCarga = '1';
        $stdinfUnidCarga->idUnidCarga = '01234567890123456789';
        
            /* Lacres das Unidades de Carga */
            $stdlacUnidCarga = new \stdClass();
            $stdlacUnidCarga->nLacre = ['00000001','00000002'];

        $stdinfUnidCarga->lacUnidCarga = $stdlacUnidCarga;
        $stdinfUnidCarga->qtdRat = '3.50';

    $stdinfUnidTransp->infUnidCarga = $stdinfUnidCarga;
    $stdinfUnidTransp->qtdRat = '3.50';
        
    $std->infUnidTransp = $stdinfUnidTransp;

    /* transporte de produtos classificados pela ONU como perigosos */
    $stdperi = new \stdClass();
    $stdperi->nONU = '1234';
    $stdperi->xNomeAE = 'testeNome';
    $stdperi->xClaRisco = 'testeClaRisco';
    $stdperi->grEmb = 'testegrEmb';
    $stdperi->qTotProd = '1';
    $stdperi->qVolTipo = '1';
    $std->peri = $stdperi;

    /* Grupo de informações da Entrega Parcial (Corte de Voo) */
    $stdinfEntregaParcial = new \stdClass();
    $stdinfEntregaParcial->qtdTotal = '1234.56';
    $stdinfEntregaParcial->qtdParcial = '1234.56';
    $std->infEntregaParcial = $stdinfEntregaParcial;

$mdfe->taginfCTe($std);

/* infCTe */
$std = new \stdClass();
$std->chCTe = '35310800000000000372570010001998991000614492';
$mdfe->taginfCTe($std);

/* infNFe */

$std = new \stdClass();
$std->chNFe = '35310800000000000372570010001999091000099999';
$std->SegCodBarra = '012345678901234567890123456789012345';
$std->indReentrega = '1';

    // Informações das Unidades de Transporte (Carreta/Reboque/Vagão)
    $stdinfUnidTransp = new \stdClass();
    $stdinfUnidTransp->tpUnidTransp = '1';
    $stdinfUnidTransp->idUnidTransp = 'AAA-1111';

        // Lacres das Unidades de Transporte
        $stdlacUnidTransp = new \stdClass();
        $stdlacUnidTransp->nLacre = ['00000001','00000002'];

        $stdinfUnidTransp->lacUnidTransp = $stdlacUnidTransp;

        // Informações das Unidades de Carga (Containeres/ULD/Outros)
        $stdinfUnidCarga = new \stdClass();
        $stdinfUnidCarga->tpUnidCarga = '1';
        $stdinfUnidCarga->idUnidCarga = '01234567890123456789';
        
            // lacres das Unidades de Carga
            $stdlacUnidCarga = new \stdClass();
            $stdlacUnidCarga->nLacre = ['00000001','00000002'];

        $stdinfUnidCarga->lacUnidCarga = $stdlacUnidCarga;
        $stdinfUnidCarga->qtdRat = '3.50';

    $stdinfUnidTransp->infUnidCarga = $stdinfUnidCarga;
    $stdinfUnidTransp->qtdRat = '3.50';
        
    $std->infUnidTransp = $stdinfUnidTransp;

    // transporte de produtos classificados pela ONU como perigosos
    $stdperi = new \stdClass();
    $stdperi->nONU = '1234';
    $stdperi->xNomeAE = 'testeNome';
    $stdperi->xClaRisco = 'testeClaRisco';
    $stdperi->grEmb = 'testegrEmb';
    $stdperi->qTotProd = '1';
    $stdperi->qVolTipo = '1';
    $std->peri = $stdperi;

$mdfe->taginfNFe($std);

/* infMDFeTransp */

$std = new \stdClass();
$std->chNFe = '35310800000000000372570010001999091000088888';
$std->indReentrega = '1';

    // Informações das Unidades de Transporte (Carreta/Reboque/Vagão)
    $stdinfUnidTransp = new \stdClass();
    $stdinfUnidTransp->tpUnidTransp = '1';
    $stdinfUnidTransp->idUnidTransp = 'AAA-1111';

        // Lacres das Unidades de Transporte
        $stdlacUnidTransp = new \stdClass();
        $stdlacUnidTransp->nLacre = ['00000001','00000002'];

        $stdinfUnidTransp->lacUnidTransp = $stdlacUnidTransp;

        // Informações das Unidades de Carga (Containeres/ULD/Outros)
        $stdinfUnidCarga = new \stdClass();
        $stdinfUnidCarga->tpUnidCarga = '1';
        $stdinfUnidCarga->idUnidCarga = '01234567890123456789';
        
            // lacres das Unidades de Carga
            $stdlacUnidCarga = new \stdClass();
            $stdlacUnidCarga->nLacre = ['00000001','00000002'];

        $stdinfUnidCarga->lacUnidCarga = $stdlacUnidCarga;
        $stdinfUnidCarga->qtdRat = '3.50';

    $stdinfUnidTransp->infUnidCarga = $stdinfUnidCarga;
    $stdinfUnidTransp->qtdRat = '3.50';
        
    $std->infUnidTransp = $stdinfUnidTransp;

    // transporte de produtos classificados pela ONU como perigosos
    $stdperi = new \stdClass();
    $stdperi->nONU = '1234';
    $stdperi->xNomeAE = 'testeNome';
    $stdperi->xClaRisco = 'testeClaRisco';
    $stdperi->grEmb = 'testegrEmb';
    $stdperi->qTotProd = '1';
    $stdperi->qVolTipo = '1';
    $std->peri = $stdperi;

$mdfe->taginfMDFeTransp($std);

/* fim grupo infDoc */

/* Grupo do Seguro */
$std = new \stdClass();
$std->respSeg = '1';

    /* Informações da seguradora */
    $stdinfSeg = new \stdClass();
    $stdinfSeg->xSeg = 'SOMPO SEGUROS';
    $stdinfSeg->CNPJ = '11222333444455';

$std->infSeg = $stdinfSeg;
$std->nApol = '11223344555';
$std->nAver = ['0572012190000000000007257001000199899140','0572012190000000000007257001000199708140'];
$mdfe->tagseg($std);
/* fim grupo Seguro */

/* grupo de totais */
$std = new \stdClass();
$std->qCTe = '02';
$std->vCarga = '580042.92';
$std->cUnid = '01';
$std->qCarga = '35454.9400';
$mdfe->tagtot($std);
/* fim grupo de totais */

/* grupo de lacres */
$std = new \stdClass();
$std->nLacre = ['0000001','0000002'];
$mdfe->taglacres($std);
/* fim grupo de lacres */

/* grupo Autorizados para download do XML do DF-e */
$std = new \stdClass();
$std->CNPJ = '11122233344455';
$mdfe->tagautXML($std);

$std = new \stdClass();
$std->CPF = '11122233344';
$mdfe->tagautXML($std);

/* fim grupo de lacres */


/* grupo Informações Adicionais */
$std = new \stdClass();
$std->infCpl = 'Contrato No 007018 2 CARR BBB1111';
$mdfe->taginfAdic($std);
/* fim grupo Informações Adicionais */

$xml = $mdfe->getXML(); // O conteúdo do XML fica armazenado na variável $xml
file_put_contents('teste.xml', $xml);
