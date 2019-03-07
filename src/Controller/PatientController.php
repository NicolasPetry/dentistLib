<?php

namespace App\Controller;

use App\Form\UserType;
use App\Form\ModType;
use App\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PatientController extends Controller {

    /**
     * @Route("/register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        // 1) build the form

        $patient = new Patient();
        
        $form = $this->createForm(UserType::class, $patient);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($patient, $patient->getPassword());
            $patient->setPassword($password);
            //on active par défaut
            $patient->setIsActive(true);
            //$patient->addRole("ROLE_ADMIN");

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();
            // ... do any other work - like sending them an email, etc
            $this->addFlash('success', 'Votre compte a bien été enregistré.');
            return $this->redirectToRoute('login');
        }
        return $this->render('registration/register.html.twig', ['form' => $form->createView(), 'mainNavRegistration' => true, 'title' => 'Inscription']);
    }


    /**
     * @Route("/member/modifierInfo/{id}", name="modifier_info")
     */
    public function modifierInfo($id, Request $request){

        $patient = $this->getDoctrine()
        ->getRepository(Patient::class)
        ->find($id);

        $form = $this->createForm(ModType::class, $patient);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();
            $this->addFlash('success', 'Vos modifications ont bien été prises en compte.');
            return $this->redirectToRoute('app_member_index');
        }
        return $this->render('registration/register.html.twig', ['form' => $form->createView(), 'title' => 'Modifier vos informations']);
    }

    /**
     * @Route("/member/modifierMdp/{id}", name="modifier_mdp")
     */
    public function modifierMdp($id, Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $patient = $this->getDoctrine()
        ->getRepository(Patient::class)
        ->find($id);

        $form = $this->get('form.factory')
                ->createNamedBuilder(null)
                ->add('password', RepeatedType::class, array(
                    'type' => Passwordtype::class,
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Confirmation du mot de passe'), 
                ))
                ->add('ok', SubmitType::class, ['label' => 'Ok', 'attr' => ['class' => 'btn-primary btn-block']])
                ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $data = $form->getData();
            $password = $passwordEncoder->encodePassword($patient, $data['password']);
            $patient->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($patient);
            $entityManager->flush();
            $this->addFlash('success', 'Votre mote de passe vient d\'être modifié.');
            return $this->redirectToRoute('app_member_index');
        }
        return $this->render('registration/register.html.twig', ['form' => $form->createView(), 'title' => 'Modifier votre mot de passe']);
    }
}