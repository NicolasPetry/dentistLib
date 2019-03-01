<?php

namespace App\Controller;

use App\Entity\Consultation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
* @Route("/consultations")
*/
class ConsultationController extends Controller
{
    /**
     * @Route("/", name="consultations")
     */
    public function index()
    {   

        $consultations = $this->getDoctrine()
                ->getRepository(Consultation::class)
                ->listconsultation();
        
        return $this->render('consultation/index.html.twig', [
            'consultations' => $consultations
        ]);
    }

    /**
     * @Route("/reserver/{id}", name="reserver")
     */
    public function reserver($id, $deplace = false){

        $consultation = $this->getDoctrine()
        ->getRepository(Consultation::class)
        ->find($id);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $consultation->setPatient($this->getUser());

        $rdv= $consultation->getCreneau();
        $dr = $consultation->getDentiste()->getNom();
        $rdv= $rdv->format('d m Y \à h:i');

        if($deplace == true){
            $success = "Votre rendez vous a bien été déplacé le ".$rdv. " avec le Docteur ".$dr." .";
        }else{
            $success = "Votre rendez vous avec le Docteur ".$dr." le ".$rdv." a bien été enregistré.";
        }
        
        $this->addFlash('success', $success);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($consultation);
        $entityManager->flush();

        return $this->redirectToRoute('consultations');
    }

    /**
     * @Route("/annuler/{id}", name="annuler")
     */
    public function annuler($id, $deplace = true){

        $consultation = $this->getDoctrine()
        ->getRepository(Consultation::class)
        ->find($id);

        $consultation->setPatient(null);

        $rdv= $consultation->getCreneau();
        $rdv= $rdv->format('d m Y \à h:i');
        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($consultation);
        $entityManager->flush();

        if ($deplace == false){
            $this->addFlash('success', 'Votre rendez vous avec le Docteur '.$consultation->getDentiste()->getNom().' le '.$rdv.' a bien été annulé.');
            return $this->redirectToRoute('app_member_index');
        }else{
            return $this->reserver($id, true);
            
        }
        
    }

    /**
     * @Route("/deplacer/{id}", name="deplacer")
     */
    public function deplacer($id){
        return $this->annuler($id, true);
    }

}   