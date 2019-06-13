<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Racer;
use App\Repository\RacerRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\RacerType;

class RacerController extends AbstractController
{

	/**
     * @Route("/admin/racers", name="racers")
     */
    public function index(RacerRepository $repo){

		$racers = $repo->findAll();
    	return $this->render('racer/index.html.twig', [
            'controller_name' => 'RacerController',
            'racers' => $racers
        ]);
    }


	/**
     * @Route("/admin/racer/add", name="racer_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
    	$racer = new Racer();
        $form = $this->createForm(RacerType::class, $racer);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($racer);
            $manager->flush();
        }

        return $this->render('racer/add.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
