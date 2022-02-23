<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function home(): Response
    {
        return $this->render('Front/home_v.html.twig');
    }
    /**
     * @Route("/travel", name="travel")
     */
    public function travel(): Response
    {
        return $this->render('Front/travel.html.twig');
    }
    /**
     * @Route("/camping", name="camping")
     */
    public function camp(): Response
    {
        return $this->render('Front/camping.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('Front/contact.html.twig');
    }
    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('Front/login.html.twig');
    }
    /**
     * @Route("/details", name="details")
     */
    public function eventDetails(): Response
    {
        return $this->render('Front/Event_details.html.twig');
    }
    /**
     * @Route("/register", name="register")
     */
    public function register(): Response
    {
        return $this->render('Front/register.html.twig');
    }
    /**
     * @Route("/error", name="error")
     */
    public function error(): Response
    {
        return $this->render('Front/error.html.twig');
    }
    /**
     * @Route("/event", name="event")
     */
    public function event(): Response
    {
        return $this->render('Front/event.html.twig');
    }
    /**
     * @Route("/addst1", name="addst1")
     */
    public function addst1(): Response
    {
        return $this->render('Front/add_event_st1.html.twig');
    }
    /**
     * @Route("/addst2", name="addst2")
     */
    public function addst2(): Response
    {
        return $this->render('Front/add_event_st2.html.twig');
    }
    /**
     * @Route("/addst3", name="addst3")
     */
    public function addst3(): Response
    {
        return $this->render('Front/add_event_st3.html.twig');
    }
    /**
     * @Route("/addst4", name="addst4")
     */
    public function addst4(): Response
    {
        return $this->render('Front/add_event_st4.html.twig');
    }

}
