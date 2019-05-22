<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PruebaController extends AbstractController
{
    /**
     * @Route("/prueba", name="prueba")
     */
    public function index()
    {
        return $this->render('article/article.html.twig', [
            'controller_name' => 'PruebaController',
        ]);
    }
}
