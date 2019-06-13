<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\ContactType;


class ContactController extends AbstractController
{

    /**
     * @Route("contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer){
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $username = $form['name']->getData();
            $mail = $form['email']->getData();
            $sujet = $form['subject']->getData();
            $body = $form['message']->getData();;


            $transport = (new \Swift_SmtpTransport('in-v3.mailjet.com', 587))
                ->setUsername('xxxx')
                ->setPassword('xxxx')
                ->setEncryption('tls')
                ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false))
                );
            $mailer = new \Swift_Mailer($transport);

            $message = (new \Swift_Message('Vous avez un nouveau message sur SWR-RECORDS de '.$username))
                ->setFrom(['contact@swr-records.net' => 'SWR RECORDS'])
                ->setTo(['delakdev@gmail.com' => 'Julien Delacourt'])
                ->setBody(
                    $this->renderView(
                        'mails/contact.html.twig',
                        array('name' => $username, 'email' => $mail, 'subject' => $sujet, 'message'=> $body)
                    ),
                    'text/html'
                );

            $mailer->send($message);

            $this->addFlash('success', 'Message Sent !');
            return $this->redirectToRoute('contact');

        }

        return $this->render('contact.html.twig',[
            'form' => $form->createView()
        ]);
    }
}