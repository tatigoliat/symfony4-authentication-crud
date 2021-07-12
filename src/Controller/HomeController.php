<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Role\SwitchUserRole;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class HomeController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        // $user = $this->get('security.context')->getToken()->getUser();


        $users = $this->getDoctrine()
            ->getRepository('App\Entity\User')
            ->findAll();

        return $this->render('home/index.html.twig', [
            'users' => $users
        ]);
    }

    public function deleteUser($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('App\Entity\User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'There are no users with the id: ' . $id
            );
        }

        $em->remove($user);
        $em->flush();

        return $this->redirect('/home');
    }

    public function createUser(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Encode the new users password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect('/home');
        }

        return $this->render(
            'user/edit.html.twig',
            array('form' => $form->createView())
        );

    }

    public function updateUser(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('App\Entity\User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'There are no users with the id: ' . $id
            );
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $form->getData();
            $em->flush();
            
            return $this->redirect('/home');
        }

        return $this->render(
            'user/edit.html.twig',
            array('form' => $form->createView())
        );
    }

    public function page(Request $request, $id)
    {
        
        return $this->render(
            'user/page.html.twig',
            array('id' => $id)
        );
    }

}
