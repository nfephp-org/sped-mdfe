<?php

namespace Tests\NFePHP\MDFe;

/**
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use NFePHP\MDFe\Mail;
use PHPUnit_Framework_TestCase;

class MailTest extends PHPUnit_Framework_TestCase
{
    public $mail;

    public function testInstanciar()
    {
        $configJson = file_get_contents(dirname(__FILE__) . '/fixtures/config/fakeconfig.json');
        $json = json_decode($configJson);
        $aMail = (array)$json->aMailConf;
        $this->mail = new Mail($aMail);
    }
}
