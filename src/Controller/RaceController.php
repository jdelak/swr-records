<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Race;
use App\Repository\RaceRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\RaceType;

class RaceController extends AbstractController
{
    /**
     * @Route("/admin/races", name="races")
     */
    public function index(RaceRepository $repo)
    {
    	$races = $repo->findAll();
        return $this->render('race/index.html.twig', [
            'controller_name' => 'RaceController',
            'races' => $races
        ]);
    }

    /**
     * @Route("/admin/race/add", name="race_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
    	$race = new Race();
        $form = $this->createForm(RaceType::class, $race);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($race);
            $manager->flush();
        }

        return $this->render('race/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Race $race
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin/race/edit/{id}", name="race_edit")
     */
    public function edit(Request $request, ObjectManager $manager, Race $race)
    {


        $form = $this->createForm(RaceType::class, $race);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $manager->flush();

            $this->addFlash('success', 'Race Updated !');

            return $this->redirectToRoute('bestlap');
        }

        return $this->render('race/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
