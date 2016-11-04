<?php

namespace Tests\NFePHP\MDFe\Auxiliar;

/**
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use NFePHP\MDFe\Auxiliar\Identify;
use PHPUnit_Framework_TestCase;

class IdentifyTest extends PHPUnit_Framework_TestCase
{
    public function testIdentificaMdfe()
    {
        $aResp = array();
        $filePath = dirname(dirname(__FILE__)) . '/fixtures/xml/MDFe41140581452880000139580010000000281611743166.xml';
        $schem = Identify::identificar($filePath, $aResp);
        $this->assertEquals($schem, 'mdfe');
    }
}
