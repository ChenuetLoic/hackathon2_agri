<?php

namespace App\Controller;

use App\Repository\CityRepository;
use App\Repository\FarmerRepository;
use App\Repository\TransactionRepository;
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
     * @return Response
     */
    public function indexMap(CityRepository $cityRepository, FarmerRepository $farmerRepository): Response
    {
        $cities = $farmerRepository->getFarmerCountByCity();
        return $this->render('map/map.html.twig', [
            'cities' => $cities,
        ]);
    }

    /**
     * @Route("/{category}", name="map_by_cereal")
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
}
