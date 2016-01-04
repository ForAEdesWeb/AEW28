<?php

namespace Aedes\AedewBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase,
    Doctrine\ORM\Tools\SchemaTool;

class AedewTestCase extends WebTestCase
{
    protected $client;
    protected $em;


    /**
     * create Kernel for test client and get em
     * drop and create a new db
     */
    public function setUp()
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->em     = $this->client->getKernel()->getContainer()
                                     ->get('doctrine.orm.entity_manager');

        $classes = $this->em->getMetadataFactory()->getAllMetadata();

        $schemaTool = new SchemaTool($this->em);

        $schemaTool->dropDatabase();
        $schemaTool->createSchema($classes);

        return true;
    }

    /**
     * clear em cache and unset this client, em
     */
    public function tearDown()
    {
        parent::tearDown();

        $this->em->clear();

        unset($this->client);
        unset($this->em);

        return true;
    }
}