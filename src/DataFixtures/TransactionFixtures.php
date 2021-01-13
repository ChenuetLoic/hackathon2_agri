<?php

namespace App\DataFixtures;

use App\Entity\Transaction;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class TransactionFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $serializer = $this->container->get('serializer');
        $filepath = realpath ("./") . "/src/DataFixtures/transactions.csv";

        $csvData = $serializer->decode(file_get_contents($filepath), 'csv');
        $i = 1;

        foreach ($csvData as $csvLine) {
            $transaction = new Transaction();
            $transaction->setProduct($this->getReference('product_'.$csvLine['product_id']))
                ->setFarmer($this->getReference('farmer_'.$csvLine['farmer_id']))
                ->setBuyer($this->getReference('buyer_'.$csvLine['buyer_id']))
                ->setCreatedAt($this->stringToDatetime($csvLine['created_at']))
                ->setPrice($csvLine['price'])
                ->setQuantity($csvLine['quantity']);
            $this->addReference('transaction_' . $i, $transaction);
            $manager->persist($transaction);
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

    public function getDependencies()
    {
        return [BuyerFixtures::class];
    }

}
