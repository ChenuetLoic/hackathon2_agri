<?php

namespace App\Controller;

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
     * @return Response
     */
    public function indexMap(): Response
    {
        return $this->render('map/map.html.twig');
    }
}
