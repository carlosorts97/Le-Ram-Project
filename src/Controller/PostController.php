<?php

namespace App\Controller;

use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;


class PostController extends AbstractController
{
    /**
     * @Route("/post/new", name="new_post")
     */
    public function newPost(Request $request)
    {
        //Creau nuevo objeto Post
        $post= new Post();
        $post-> setTitle('write a post title');
        //Crear formulario
        $form=$this->createForm(PostType::class, $post);

        //handle the request
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //Capturar los datos
            $post=$form->getData();
            //Fluir hacia la base de datos

        }

        //render the form
        return $this->render('post/post.html.twig', [
            'form' => $form->createView()]);
    }
}
