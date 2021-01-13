<?php

namespace App\DataFixtures;

use App\Entity\Buyer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class BuyerFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $serializer = $this->container->get('serializer');
        $filepath = realpath ("./") . "/src/DataFixtures/buyers.csv";

        $csvData = $serializer->decode(file_get_contents($filepath), 'csv');
        $i = 1;

        foreach ($csvData as $csvLine) {
            $buyer = new Buyer();
            $buyer->setCity($this->getReference('city_'.$csvLine['city_id']))
                ->setName($csvLine['name'])
                ->setType($csvLine['type']);
            $this->addReference('buyer_' . $i, $buyer);
            $manager->persist($buyer);
            $i++;
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CityFixtures::class];
    }
}
