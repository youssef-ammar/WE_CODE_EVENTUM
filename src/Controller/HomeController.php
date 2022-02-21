<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/base", name="base")
     */
    public function indexBase(): Response
    {
        return $this->render('Event_details.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
