<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TopRepository;
use App\Repository\RaceRepository;
use App\Entity\Top;
use App\Form\TopType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class TopController extends AbstractController
{
    /**
     * @Route("/top", name="top")
     */
    public function index(Request $request,TopRepository $topRepo, RaceRepository $raceRepo)
    {
        $races = $raceRepo->findAll();
        $race = '';
        $topTiers = '';

        if($request->getMethod() === 'POST'){
            $race = $request->request->get('race');
            $topTiers = $topRepo->findByRaces($race);
        }

        return $this->render('top/index.html.twig', [
            'controller_name' => 'TopController',
            'races' => $races,
            'race' => $race,
            'topTiers' => $topTiers
        ]);
    }


    /**
     * @Route("/admin/top/add", name="top_add")
     */
    public function add(Request $request, ObjectManager $manager)
    {
        $top = new Top();
        $form = $this->createForm(TopType::class, $top);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($top);
            $manager->flush();
        }

        return $this->render('top/add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param Top $top
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/top/edit/{id}", name="top_edit")
     */
    public function edit(Request $request, ObjectManager $manager, Top $top)
    {

        $form = $this->createForm(TopType::class, $top);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $manager->flush();

            $this->addFlash('success', 'Top Tier Racer Updated !');

            return $this->redirectToRoute('top');
        }

        return $this->render('top/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
