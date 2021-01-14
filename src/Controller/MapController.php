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
     * @Route("/{category}", name="show_wheat")
     * @param TransactionRepository $transactionRepository
     * @param $category
     * @return Response
     */
    public function mapShowWheat(TransactionRepository $transactionRepository, string $category)
    {
        $cities = $transactionRepository->getFarmersByProduct($category);
        return $this->render('map/mapWheat.html.twig', [
            'cities' => $cities,
        ]);
    }
}
