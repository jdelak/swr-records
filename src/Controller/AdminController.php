<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\BestLap;
use App\Entity\Top;
use App\Entity\Racer;
use App\Entity\Race;
use App\Entity\Country;
use App\Entity\User;
use App\Repository\BestLapRepository;
use App\Repository\TopRepository;
use App\Repository\RacerRepository;
use App\Repository\RaceRepository;
use App\Repository\CountryRepository;
use App\Repository\UserRepository;
use App\Form\TopType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="dashboard")
     */
    public function index(UserRepository $userRepo, BestLapRepository $bestRepo)
    {
        $users = $userRepo->getNbUsers();
        $bestlaps = $bestRepo->getNbBestLaps();
        return $this->render('admin/dashboard.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users,
            'bestlaps' => $bestlaps,
        ]);
    }

    /**
     * @Route("/admin/bestlap", name="admin_bestlap")
     */
    public function best(BestLapRepository $repo)
    {

        $bestlaps = $repo->findAll();

        return $this->render('admin/bestlap.html.twig', [
            'controller_name' => 'AdminController',
            'bestlaps' => $bestlaps
        ]);
    }

    /**
     * @Route("admin/top", name="admin_top")
     */
    public function top(Request $request,TopRepository $topRepo, RaceRepository $raceRepo)
    {
        $races = $raceRepo->findAll();
        $race = '';
        $topTiers = '';

        if($request->getMethod() === 'POST'){
            $race = $request->request->get('race');
            $topTiers = $topRepo->findByRaces($race);
        }

        return $this->render('admin/top.html.twig', [
            'controller_name' => 'TopController',
            'races' => $races,
            'race' => $race,
            'topTiers' => $topTiers
        ]);
    }

    /**
     * @Route("admin/players", name="players")
     */
    public function players(UserRepository $repo)
    {
        $players = $repo->findAll();
        
        return $this->render('admin/users.html.twig', [
            'controller_name' => 'AdminController',
            'players' => $players,
        ]);
    }
    
}

