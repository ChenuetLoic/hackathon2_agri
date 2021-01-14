<?php

namespace App\DataFixtures;

use App\Entity\Farmer;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class FarmerFixtures extends Fixture implements ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $serializer = $this->container->get('serializer');
        $filepath = realpath ("./") . "/src/DataFixtures/farmers.csv";

        $csvData = $serializer->decode(file_get_contents($filepath), 'csv');
        $i = 1;

        foreach ($csvData as $csvLine) {
            $farmer = new Farmer();
            $farmer->setCity($this->getReference('city_'.$csvLine['city_id']))
                ->setRegisteredAt($this->stringToDatetime($csvLine['registered_at']))
                ->setRegisterYear(substr($csvLine['registered_at'], 6,4))
                ->setFirstName($csvLine['first_name'])
                ->setLastName($csvLine['last_name'])
                ->setFarmSize($csvLine['farm_size']);
            $this->addReference('farmer_' . $i, $farmer);
            $manager->persist($farmer);
            $i++;
        }

        $manager->flush();
    }

    private function stringToDatetime(string $date): DateTime
    {
        $dateArray = explode('/', $date);
        return (new DateTime())
            ->setDate(
                (int)$dateArray[2],
                (int)$dateArray[1],
                (int)$dateArray[0]
            )
            ->setTime(0, 0, 0);
    }

}
