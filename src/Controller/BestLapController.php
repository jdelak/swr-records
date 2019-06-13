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
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\BestLapType;

class BestLapController extends AbstractController
{
    /**
     * @Route("/profile/bestlap", name="bestlap")
     */
    public function index(BestLapRepository $repo)
    {
        $user = $this->getUser();
    	$bestlaps = $repo->findByPlayer($user);

        return $this->render('best_lap/index.html.twig', [
            'controller_name' => 'BestLapController',
            'bestlaps' => $bestlaps
        ]);
    }

    /**
     * @Route("/profile/bestlap/add", name="bestlap_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
    	$bestlap = new BestLap();
    	$user = $this->getUser();
        
        $form = $this->createForm(BestLapType::class, $bestlap);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

        	$bestlap->setPlayer($user);
            $manager->persist($bestlap);
            $manager->flush();

            $this->addFlash('success', 'Best Lap Saved !');

			return $this->redirectToRoute('bestlap');
        }

        return $this->render('best_lap/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
	 * @param Request $request
     * @param BestLap $bestLap
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/profile/bestlap/edit/{id}", name="bestlap_edit")
     */
    public function edit(Request $request, ObjectManager $manager, BestLap $bestLap)
    {


    	$form = $this->createForm(BestLapType::class, $bestLap);
    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()){
            

            $manager->flush();

            $this->addFlash('success', 'Best Lap Updated !');

			return $this->redirectToRoute('bestlap');
        }

        return $this->render('best_lap/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
