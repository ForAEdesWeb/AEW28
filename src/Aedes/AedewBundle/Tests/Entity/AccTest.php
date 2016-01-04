<?php

namespace Aedes\AedewBundle\Tests\Entity;

class AccTest extends \Aedes\AedewBundle\Tests\AedewTestCase
{
    private $acc;

    public function setUp()
    {
        parent::setUp();

        $this->acc = new \Aedes\AedewBundle\Entity\Acc();
    }

    public function testSetPassword()
    {
        $this->acc->setPassword("password");

        $this->assertEquals(md5("password"), $this->acc->getPassword());
    }

    public function testExtendAcc()
    {
        $this->acc->setEndTime(new \DateTime("2012-04-19"));

        $this->acc->extend(10);

        $this->assertEquals(new \DateTime("2012-04-29"),
                            $this->acc->getEndTime());

        $this->acc->extend(-10);

        $this->assertEquals(new \DateTime("2012-04-19"),
                            $this->acc->getEndTime());
    }
}