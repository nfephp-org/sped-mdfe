<?php

require __DIR__ . "/../../vendor/autoload.php";

use NFePHP\MDFe\Factories\Protocol;


$protocol = new Protocol();
$xmlProtocol = $protocol->add($xmlAssinado, $protocolo);
