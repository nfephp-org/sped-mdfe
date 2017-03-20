###Modais de Transportes
---------------------
Atenção: Implementado somente o modal Rodoviario.
===============================================
*Modo de uso*
=============
    use NFePHP\MDFe\Modais\Rodoviario;
    $rodo = new Rodoviario();
    $rodo
    ->setAnttRNTRC('1111487')
    ->setAnttCIOT('15948', '10144444440')
    ->setAnttCIOT('5987', '12221000100')
    ->setAnttContratante('1031213440')
    ->setAnttValePed('189999900100', '1014894640', '555599', '8200')
    ->setAnttValePed('596401036', '1426983333900', '55', '500')
    ->setTracao('0', 'KGH7744', null, '1600', '14000', null, [
      'CPF' => '00000849899',
      'xNome' => 'Marcos Dantas',
      'UF' => 'RN',
      'tpProp' => '2'
    ])
    ->setTracaoCondutor('Sebastiao Marcos', '10142222440', '01', '01', 'RN')
    ->setReboque('0','KLE6699',null,'1500','25000',null, [
        'CNPJ' => '14262222000100',
        'RNTRC' => null,
        'xNome' => 'Marcos Dantas LTDA-ME',
        'IE' => '000589',
        'tpProp' => '2',
        'tpCar' => '0',
        'UF' => 'RN'
    ]);

    $rodo
      ->setCodAgPorto('15616');

    $rodo
      ->setLacres('1588949984');
    //Injetando na classe mdfe
    $mdfe->modal($rodo);
