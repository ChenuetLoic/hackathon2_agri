<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class ProductFixtures extends Fixture implements ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $serializer = $this->container->get('serializer');
        $filepath = realpath ("./") . "/src/DataFixtures/products.csv";

        $csvData = $serializer->decode(file_get_contents($filepath), 'csv');
        $i = 1;

        foreach ($csvData as $csvLine) {
            $product = new Product();
            $product->setName($csvLine['name'])
                ->setCategory($csvLine['category']);
            $this->addReference('product_' . $i, $product);
            $manager->persist($product);
            $i++;
        }

        $manager->flush();
    }
}
