# PROTOCOLAR XML DA MDF-e

**Função:** Função adicionado o protoloco retornado da consulta do recibo ao XML já assinado

## Parametros

| Variável | Detalhamento  |
| :---:  | :--- |
| $xmlAssinado | XML já assinado com o certificado digital (OBRIGATÓRIO) |
| $protocolo | XML retornado pela consulta do recibo do lote (OBRIGATÓRIO) |

```php
<?php

use NFePHP\MDFe\Factories\Protocol;


$protocol = new Protocol();
$xmlProtocol = $protocol->add($xmlAssinado, $protocolo);
```
