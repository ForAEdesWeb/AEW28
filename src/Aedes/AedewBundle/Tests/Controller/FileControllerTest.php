<?php

namespace Aedes\AedewBundle\Tests\Controller;

class FileControllerTest extends \Aedes\AedewBundle\Tests\AedewTestCase
{
    private $file;
    private $acc;
    private $accRootFile;
    private $nAccRootFile;
    private $accRootFileChile;
    private $nAccRootFileChile;



    public function setUp()
    {
        parent::setUp();

        $this->file = new \Aedes\AedewBundle\Controller\FileController();

        $this->acc = new \Aedes\AedewBundle\Entity\Acc();
        $this->acc->setDomain("www.aedew.com");
        $this->acc->setCompany("companyName");
        $this->acc->setPassword("password");
        $this->acc->setStyle("testStyle");
        $this->acc->setMobileStyle("testMobileStyle");
        $this->acc->setMenu(0);
        $this->acc->setDefaultFile(0);

        $this->em->persist($this->acc);
        $this->em->flush();

        $this->accRootFile = new \Aedes\AedewBundle\Entity\File();
        $this->accRootFile->setTitle("title");
        $this->accRootFile->setOwn($this->acc->getId());

        $this->em->persist($this->accRootFile);
        $this->em->flush();

        $this->nAccRootFile = new \Aedes\AedewBundle\Entity\File();
        $this->nAccRootFile->setTitle("title");
        $this->nAccRootFile->setOwn(9);

        $this->em->persist($this->nAccRootFile);
        $this->em->flush();

        $this->accRootFileChile = new \Aedes\AedewBundle\Entity\File();
        $this->accRootFileChile->setTitle("title");
        $this->accRootFileChile->setOwn($this->acc->getId());
        $this->accRootFileChile->setParent($this->accRootFile->getId());

        $this->em->persist($this->accRootFileChile);
        $this->em->flush();

        $this->nAccRootFileChile = new \Aedes\AedewBundle\Entity\File();
        $this->nAccRootFileChile->setTitle("title");
        $this->nAccRootFileChile->setOwn(9);
        $this->nAccRootFileChile->setParent($this->accRootFile->getId());

        $this->em->persist($this->nAccRootFileChile);
        $this->em->flush();
    }

    public function testController()
    {
        /**
         * 要開始推時候在補測試
         */
        $this->assertTrue(true);
    }
}
