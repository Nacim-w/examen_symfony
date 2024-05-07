<?php

namespace App\DataFixtures;
use app\Entity\Analyse;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnalyseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=10;$i++)
        {
        $analyse=new Analyse();
        $analyse->setNumAnalyse("$i")->setNom("test")->settype("tester")->setdate(new \DateTime('2024-05-02'));
        $manager->persist($analyse);
        }
        $manager->flush();
    }
}
