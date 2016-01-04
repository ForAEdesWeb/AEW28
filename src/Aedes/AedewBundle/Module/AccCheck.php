<?php

namespace Aedes\AedewBundle\Module;

class AccCheck
{
    public $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function domainCanUse($domain)
    {
        $domain = $this->em->getRepository("AedesAedewBundle:Acc")
                           ->findOneBy(array("domain" => $domain));

        if($domain !== null)
            return false;

        return true;
    }
}