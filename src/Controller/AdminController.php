<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\NewArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\User;
use App\Entity\Cities;
use App\Entity\Countries;
use App\Form\UserType;
use App\Form\EditUserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Category;

/**
 * Class AdminController
 * @package App\Controller
 *@IsGranted("ROLE_ADMIN")
 *
 */
class AdminController extends AbstractController
{

    /**
     * @Route("/admin", name="app_admin")
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/index.html.twig', [
            'users' => $users
        ]);
    }
    /**
     * @Route("/createUser",name="app_createUser")
     */
    public function register (Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user=new User();
        $city = new Cities();
        $country = new Countries();
        $country->setName("EEESSSSPAÑA");
        $city->setName("Castelldefels");
        $city->setCountry($country);

        //create the form
        $form=$this->createForm(UserType::class,$user);

        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //encrypt password
            $user->setRoles(['ROLE_USER']);
            $user->setCity($city);
            $password=$passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            //handle the entities
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'succes', 'User2 created'
            );
            return $this->redirectToRoute('app_homepage');
        }

        //render the form
        return $this->render('users/regform.html.twig',[
            'error'=>$error,
            'form'=>$form->createView()
        ]);

    }
    /**
     * @Route("admin/user/{id}/edit", name="app_user_edit")
     */
    public function editUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, $id)
    {
        $title="Edit";
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        //create the form
        $form = $this->createForm(EditUserType::class, $user);

        $form->handleRequest($request);
        $error = $form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            //encrypt password
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            //handle the entities
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'succes', 'User2 created'
            );
            return $this->redirectToRoute('app_admin');
        }

        //render the form
        return $this->render('admin/editUser.html.twig',[
            'error'=>$error,
            'form'=>$form->createView(),
            'title'=>$title
        ]);
    }

    /**
     * @Route("admin/user/{id}/delete", name="app_user_delete")
     */
    public function deleteUser($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_admin');


    }

    /**
     * @Route("/upProduct", name="app_uploadArticle")
     */
    public function uploadArticle(Request $Request)
    {
        $article = new Articles();
        $category = new Category();
        $category->setName("Top");
        $id= $this->getUser();
        //crear form
        $form = $this->createForm(NewArticleType::class, $article);
        //handle the request
        $form->handleRequest($Request);
        if ($form->isSubmitted() && $form->isValid()) {

            $article->setCategory($category);
            $article->setUser($id);
            $article = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            return $this->redirectToRoute('app_homepage');
        }
        //render the form
        return $this->render('article/upProduct.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("admin/article/{id}/edit", name="app_article_edit")
     */
    public function editArticle(Request $request, $id)
    {
        $title="Edit";
        $article = $this->getDoctrine()->getRepository(Articles::class)->find($id);
        //create the form
        $form = $this->createForm(NewArticleType::class, $article);

        $form->handleRequest($request);
        $error = $form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            //encrypt password
            //handle the entities
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash(
                'succes', 'User2 created'
            );
            return $this->redirectToRoute('app_admin');
        }

        //render the form
        return $this->render('admin/editUser.html.twig',[
            'error'=>$error,
            'form'=>$form->createView(),
            'title'=>$title
        ]);
    }

    /**
     * @Route("admin/article/{id}/delete", name="app_article_delete")
     */
    public function deleteArticle($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $this->getDoctrine()->getRepository(Articles::class)->find($id);

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('app_admin');


    }

}
