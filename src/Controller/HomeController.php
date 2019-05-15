<?php
/**
 * Created by PhpStorm.
 * User2: linux
 * Date: 23/01/19
 * Time: 17:54
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_homepage")
     */
    public function homepage(){

        return $this->render('home/home.html.twig');
    }
}