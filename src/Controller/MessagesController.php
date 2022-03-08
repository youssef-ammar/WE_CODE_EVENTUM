<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Topic;
use App\Entity\Utilisateur;
use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessagesController extends AbstractController
{
    /**
     * @Route("/messages", name="messages")
     */
    public function index(): Response
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find(1);
        return $this->render('Front/Forum/messages/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request): Response
    {
        $message = new Message;
        $form = $this->createForm(MessageType::class, $message);
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find(1);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid() ){
            $message->setSender($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash("message", "Message envoyé avec succès.");
            return $this->redirectToRoute("messages");
        }

        return $this->render("Front/Forum/messages/send.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find(1);

        return $this->render('Front/Forum/messages/received.html.twig',['user'=>$user]);
    }


    /**
     * @Route("/sent", name="sent")
     */
    public function sent(): Response
    {
        $user = $this->getDoctrine()->getRepository(Utilisateur::class)->find(1);
        return $this->render('Front/Forum/messages/sent.html.twig',['user'=>$user]);

    }

    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Message $message): Response
    {
        $message->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('Front/Forum/messages/read.html.twig', compact("message"));
    }

    /**
     * @Route("/delete/{id}", name="deleteM")
     */
    public function delete(Message $message): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute("received");
    }
}
