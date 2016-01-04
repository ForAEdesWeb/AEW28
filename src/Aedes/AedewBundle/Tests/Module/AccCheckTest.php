<?php

namespace Aedes\AedewBundle\Tests\Module;

class AccCheckTest extends \Aedes\AedewBundle\Tests\AedewTestCase
{
    private $check;

    public function setUp()
    {
        parent::setUp();

        $this->check = new \Aedes\AedewBundle\Module\AccCheck($this->em);
    }

    public function testDomainHasUse()
    {
        $domainCanBeUse = $this->check->domainCanUse("www.aedew.com");

        $this->assertTrue($domainCanBeUse);

        $acc = new \Aedes\AedewBundle\Entity\Acc;
        $acc->setDomain("www.aedew.com");
        $acc->setCompany("companyName");
        $acc->setPassword("password");
        $acc->setStyle("testStyle");
        $acc->setMobileStyle("testMobileStyle");
        $acc->setMenu(0);
        $acc->setDefaultFile(0);

        $this->em->persist($acc);
        $this->em->flush();

        $domainCanBeUse = $this->check->domainCanUse("www.aedew.com");
        $this->assertFalse($domainCanBeUse);
    }
}