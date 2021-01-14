<?php

namespace App\Controller;

use App\Repository\BuyerRepository;
use App\Repository\CityRepository;
use App\Repository\FarmerRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/")
 */
class MapController extends AbstractController
{
    /**
     * @Route ("/", name="index_map", methods={"GET"})
     * @param CityRepository $cityRepository
     * @param FarmerRepository $farmerRepository
     * @param BuyerRepository $buyerRepository
     * @return Response
     */
    public function indexMap(CityRepository $cityRepository, FarmerRepository $farmerRepository, BuyerRepository $buyerRepository): Response
    {

        $cities = $farmerRepository->getFarmerWithCity();
        $buyers = $buyerRepository->getBuyers();
        return $this->render('map/map.html.twig', [
            'cities' => $cities,
            'buyers' => $buyers,
        ]);
    }

    /**
     * @Route("/category/{category}", name="map_by_cereal")
     * @param TransactionRepository $transactionRepository
     * @param $category
     * @return Response
     */
    public function mapShowFarmersByCereal(TransactionRepository $transactionRepository, string $category): Response
    {
        $cities = $transactionRepository->getFarmersByProduct($category);
        return $this->render('map/map.html.twig', [
            'cities' => $cities,
        ]);
    }

    /**
     * @Route("/size/{size}", name="map_by_size")
     * @param FarmerRepository $farmerRepository
     * @param int $size
     * @return Response
     */
    public function mapShowFarmersByFarmSize(FarmerRepository $farmerRepository, int $size): Response
    {
        $cities = $farmerRepository->getFarmersByFarmSize($size);
        return $this->render('map/map.html.twig', [
            'cities' => $cities,
        ]);
    }
  
    /**
     * @Route("scriptdegueu", name="nepasregarder")
     * @param FarmerRepository $farmerRepository
     * @param EntityManagerInterface $entityManager
     */

    public function scriptpourriparcequeyapasgroupconcatdansDoctrine(FarmerRepository $farmerRepository, EntityManagerInterface $entityManager)
    {
        $farmers = $farmerRepository->findAll();
        $categories=[];
        foreach ($farmers as $farmer){
            $products = [];
            $quantity = 0;
            $transactions = $farmer->getTransactions();
            foreach ($transactions as $transaction) {
                $products[] = ucfirst($transaction->getProduct()->getCategory());
                $quantity += $transaction->getQuantity();
            }

            $farmer->setCategory(implode(' ', array_unique($products)))
                ->setQuantitySold($quantity);
        }

        $entityManager->flush();
        return $this->redirectToRoute('index_map');

    }
}
