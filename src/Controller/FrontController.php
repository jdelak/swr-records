<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\BestLap;
use App\Repository\BestLapRepository;
use App\Entity\Racer;
use App\Repository\RacerRepository;
use App\Entity\Race;
use App\Repository\RaceRepository;
use App\Entity\Country;
use App\Repository\CountryRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index()
    {
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

	/**
     * @Route("/about", name="about")
     */
    public function about()
    {

    	return $this->render('front/about.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/ranking", name="ranking")
     */
    public function ranking(Request $request, BestLapRepository $lapRepo, RacerRepository $racerRepo, RaceRepository $raceRepo, CountryRepository $cRepo)
    {

        $racers = $racerRepo->findAll();
        $races = $raceRepo->findAll();
        $countries = $cRepo->findAll();

        $bestlaps = $lapRepo->findAllDesc();
        if($request->getMethod() === 'POST'){

            $filter = $request->request->get('filter');
            $bestlaps = $lapRepo->findFilter($filter);

        }

        return $this->render('front/ranking.html.twig', [
            'controller_name' => 'FrontController',
            'countries' => $countries,
            'racers' => $racers,
            'races' => $races,
            'bestlaps' => $bestlaps
        ]);

    }
}

