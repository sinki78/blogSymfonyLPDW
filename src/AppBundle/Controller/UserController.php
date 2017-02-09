<?php

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Entity\Role;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
//    /**
//     * @Route("/login_check", name="check")
//     */
//    public function loginCheckAction(Request $request)
//    {
//
////        dump("test");die;
//    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        // 1) build the form
        $roles = $em->getRepository('AppBundle:Role')->findAll();
        if($roles == NULL){
            $this->get('user_service')->generateGroups($em);
        }

        $user = new User($em);
        $form = $this->createForm(UserType::class, $user);


        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            // 4) save the User!
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'security/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/godpalace", name="become_a_god")
     */
    public function godAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $log_user = $this->getUser()->getId();
//        dump($log_user->getId());die;
        $user = $em->getRepository('AppBundle:User')->find($log_user);
//        dump($user);
        $role = $em->getRepository('AppBundle:Role')->findAll();
//        dump($role[0]);die;
        $user->addRole($role[0]);
//        dump($user);die;
        $em->persist($user);
        $em->flush();
        $token = $this->get('security.token_storage')->getToken()->setAuthenticated(false);
        return $this->redirectToRoute('homepage');

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction() {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }
}