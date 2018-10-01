<?php

/**
 * Class MailMDFeTest
 * @author Roberto L. Machado <linux.rlm at gmail dot com>
 */
use PHPUnit\Framework\TestCase;
use NFePHP\MDFe\Mail;

class MailTest extends TestCase
{
    public $mail;
    
    public function testeInstanciar()
    {
        $configJson = file_get_contents(dirname(__FILE__) . '/fixtures/config/fakeconfig.json');
        $json = json_decode($configJson);
        $aMail = (array) $json->aMailConf;
        $this->mail = new Mail($aMail);
        $this->assertTrue(true);
    }
}
