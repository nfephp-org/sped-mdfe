# CONSTRUÇÃO DO XML

Para construir o XML da MDF-e deve ser usada a classe Make::class

## *NOTA: Esta classe agora recebe os parâmetros dos métodos em forma de stdClass e não mais com variáveis individuais. É importante salientar que os campos do stdClass devem ser nomeados com a EXATA nomenclatura contida no manual ou conforme a nomenclatura das estruturas do TXT, observando as letras maiuscula se minusculas.*
## *NOTA: Procure observar a ordem em os métodos devem ser usados. Carregar os dados em sequencia errada pode causar problemas, especialmente em nodes dependentes.*

Esses stdClass pode ser criados diretamente como demonstrado nos exemplos abaixo, mas também podem ser criados a partir de matrizes.

> NOTA: Muitos campos não são obrigatórios nesse caso caso não haja nenhum valor a ser informado, devem ser criados como NULL. 

# Métodos

### function __construct()
Método construtor. Instancia a classe

```php
$make = new Make();
```

### function taginfMDFe($std):DOMElement
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->versao = '3.00';

$elem = $make->taginfMDFe($std);
```

### function tagide($std):DOMElement
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->cUF = '31';
$std->tpAmb = '2';
$std->tpEmit = '1';
$std->tpTransp = '1';
$std->mod = '58';
$std->serie = '1';
$std->nMDF = '3345678';
$std->cMDF = '09835783';
$std->cDV = substr($chave, -1);
$std->modal = '1';
$std->dhEmi = '2017-10-09T10:24:00-03:00';
$std->tpEmis = '1';
$std->procEmi = '0';
$std->verProc = '2.0';
$std->ufIni = 'MG';
$std->ufFim = 'DF';
$std->dhIniViagem = '2017-12-12T10:24:00-03:00';

$elem = $make->tagide($std);
```

### function tagInfMunCarrega($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->cMunCarrega = '3106200';
$std->xMunCarrega = 'BELO HORIZONTE';

$elem = $make->tagInfMunCarrega($std);
```

### function tagInfPercurso($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->ufPer = 'GO';

$elem = $make->tagInfPercurso($std);
```

### function tagemit($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->CNPJ = '09204054000143';
$std->IE = '0010526120088';
$std->xNome = 'NOME DO CLIENTE';
$std->xFant = 'FANTASIA';

$elem = $make->tagemit($std);
```

### function tagenderEmit($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->xLgr = 'R. ONTINENTINO';
$std->nro = '1313';
$std->xCpl = '';
$std->xBairro = 'CAICARAS';
$std->cMun = '3106200';
$std->xMun = 'Belo Horizonte';
$std->CEP = '30770180';
$std->UF = 'MG';
$std->fone = '31988998899';
$std->email = 'email@hotmail.com';

$elem = $make->tagenderEmit($std);
```

### function tagInfModal($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->versaoModal = '3.00';

$elem = $make->tagInfModal($std);
```

### function tagRodo($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->codAgPorto  = '10167059';

$elem = $make->tagRodo($std);
```

### function tagInfANTT($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->RNTRC  = '9988877';

$elem = $make->tagInfANTT($std);
```

### function tagInfCIOT($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->CIOT  = '9988877';
$std->CNPJ  = '09204054000143';

$elem = $make->tagInfCIOT($std);
```

### function tagDisp($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->CNPJForn  = '09204054000143';
$std->CNPJPg  = '09204054000143';
$std->CPFPg  = '64884590074';
$std->nCompra  = '34566';
$std->vValePed  = '200';

$elem = $make->tagDisp($std);
```

### function tagInfContratante($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->CPF  = '64884590074';
$std->CNPJ  = '09204054000143';

$elem = $make->tagInfContratante($std);
```

### function tagVeicTracao($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->cInt = '';
$std->placa = 'ABC1234';
$std->RENAVAM = '78541258';
$std->tara = '10000';
$std->capKG = '500';
$std->capM3 = '60';
$std->tpRod = '06';
$std->tpCar = '02';
$std->UF = 'MG';

$elem = $make->tagVeicTracao($std);
```

### function tagPropVeicTracao($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->xNome = 'Proprietario';

$elem = $make->tagPropVeicTracao($std);
```

### function tagCondutor($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->xNome = 'Condutor 1';
$std->CPF = '54749355011';

$elem = $make->tagCondutor($std);
```

### function tagVeicReboque($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->item = '1';
$std->cInt = '1';
$std->placa = 'ABC1234';
$std->RENAVAM = '78541258';
$std->tara = '10000';
$std->capKG = '500';
$std->capM3 = '60';
$std->tpCar = '02';
$std->UF = 'MG';

$elem = $make->tagVeicReboque($std);
```

### function tagPropVeicReboque($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->item = '1';
$std->xNome = 'Proprietario';

$elem = $make->tagPropVeicReboque($std);
```

### function tagLacRodo($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->nLacre = '6552';

$elem = $make->tagLacRodo($std);
```

### function tagAereo($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->nac = 'PP';
$std->matr = '';
$std->nVoo = 'AB1234';
$std->cAerEmb = 'OACI';
$std->cAerDes = 'OACI';
$std->dVoo = '2017-12-12T10:24:00-03:00';

$elem = $make->tagAereo($std);
```

### function tagAquav($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->irin = '12';
$std->tpEmb = '53';
$std->cEmbar = '3352';
$std->xEmbar = 'Embarcacao teste';
$std->nViag = '8896';
$std->cPrtEmb = 'BRADRARE0002';
$std->cPrtDest = 'BRADRARE9999';
$std->prtTrans = 'Porto Teste';
$std->tpNav = 0;

$elem = $make->tagAquav($std);
```

### function tagInfTermCarreg($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->cTermCarreg = '12';
$std->xTermCarreg = 'Carga Teste';

$elem = $make->tagInfTermCarreg($std);
```

### function tagInfTermDescarreg($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->cTermDescarreg = '12';
$std->xTermDescarreg = 'Carga Teste';

$elem = $make->tagInfTermDescarreg($std);
```

### function tagInfEmbComb($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->cEmbComb = '12';
$std->xBalsa = 'balsa teste';

$elem = $make->tagInfEmbComb($std);
```

### function tagInfUnidCargaVazia($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->idUnidCargaVazia = '6552';
$std->tpUnidCargaVazia = '6552';

$elem = $make->tagInfUnidCargaVazia($std);
```

### function tagInfUnidCargaVazia($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->idUnidTranspVazia = '6552';
$std->tpUnidTranspVazia = '6552';

$elem = $make->tagInfUnidTranspVazia($std);
```

### function tagTrem($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->xPref = 'NGA0115';
$std->dhTrem = '2017-12-12T10:24:00-03:00';
$std->xOri = 'EFVM';
$std->xDest = 'EFA';
$std->qVag = '6';

$elem = $make->tagTrem($std);
```

### function tagVag($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->pesoBC = 1.000;
$std->pesoR = 1.000;
$std->tpVag = 'Gai';
$std->serie = '1';
$std->nVag = '3';
$std->nSeq = '1';
$std->TU = 1.000;

$elem = $make->tagVag($std);
```

### function tagInfMunDescarga($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->nItem = '1';
$std->cMunDescarga = '5107602';
$std->xMunDescarga = 'Rondonópolis';

$elem = $make->tagInfMunDescarga($std);
```

### function tagInfCTe($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->nItem = '1';
$std->chCTe = '31171009204054000143570010000015441090704345';
$std->SegCodBarra = '';
$std->indReentrega = '';

$elem = $make->tagInfCTe($std);
```

### function tagInfNFe($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->nItem = '1';
$std->chNFe = '31171009204054000143570010000015441090704345';
$std->SegCodBarra = '';
$std->indReentrega = '';

$elem = $make->tagInfNFe($std);
```

### function tagInfResp($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->respSeg = '1';
$std->CNPJ = '11095658000140';
$std->CPF  = '';

$elem = $make->tagInfResp($std);
```

### function tagInfSeg($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->xSeg = 'Seguradora';
$std->CNPJ = '11095658000140';

$elem = $make->tagInfSeg($std);
```

### function tagSeg($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->nApol = '114';
$std->nAver = '300';

$elem = $make->tagSeg($std);
```

### function tagTot($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->qCTe = '1';
$std->qNFe = '';
$std->qMDFe = '';
$std->vCarga = '157620.00';
$std->cUnid = '01';
$std->qCarga = '2323.0000';

$elem = $make->tagTot($std);
```

### function tagLacres($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->nLacre = '1';

$elem = $make->tagLacres($std);
```

### function tagautXML($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->CNPJ = '09835787667';
$std->CPF = '';

$elem = $make->tagautXML($std);
```

### function taginfAdic($std):DOMElement 
| Parametro | Tipo | Descrição |
| :--- | :---: | :--- |
| $std | stcClass | contêm os dados dos campos, nomeados conforme manual |

```php
$std = new stdClass();
$std->infAdFisco = 'Inf. Fisco';
$std->infCpl = 'Inf. Complementar do contribuinte';

$elem = $make->taginfAdic($std);
```

### function monta()
Este método executa a montagem do XML
```php
$make->monta();
```

### function getXMl():string
Este método retorna o XML em uma string
```php
$xml = $make->getXML();
```

### function getChave():string
Este método retorna o numero da chave da MDFe
```php
$chave = $nfe->getChave();
```
