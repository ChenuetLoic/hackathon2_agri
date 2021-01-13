<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use App\Entity\City;

class CityFixtures extends Fixture implements ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $serializer = $this->container->get('serializer');
        $filepath = realpath ("./") . "/src/DataFixtures/cities.csv";

        $csvData = $serializer->decode(file_get_contents($filepath), 'csv');
        $i = 1;

        foreach ($csvData as $csvLine) {
            $city = new City();
            $city->setZipcode($csvLine['zipcode'])
                ->setCity($csvLine['city'])
                ->setLatitude($csvLine['lat'])
                ->setLongitude($csvLine['long'])
                ->setInseeCode($csvLine['insee_code']);
            $this->addReference('city_' . $i, $city);
            $manager->persist($city);
            $i++;
        }

        $manager->flush();
    }
}
