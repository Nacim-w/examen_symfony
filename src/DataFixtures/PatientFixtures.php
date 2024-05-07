<?php

namespace App\DataFixtures;
use app\Entity\Patient;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PatientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i=1;$i<=10;$i++)
        {
        $patient=new Patient();
        $patient->setNom("test $i")->setPrenom("tester")->setDate(new \DateTime('2024-05-02'))->setAdresse("Tunisia")->setNum("12346578")->setValide("False");
        $manager->persist($patient);
        }
        $manager->flush();
    }
}
