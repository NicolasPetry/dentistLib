<?php

namespace App\Controller;

use App\Entity\Dentiste;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DentisteController extends Controller
{
    /**
     * @Route("/dentistes", name="dentistes")
     */
    public function index()
    {
        $dentistes = $this->getDoctrine()
                ->getRepository(Dentiste::class)
                ->listdentiste();
        
        return $this->render('dentiste/index.html.twig', [
            'dentistes' => $dentistes,
        ]);
    }

    /**
     * @Route("/dentiste/{id}", name="dentisteDetail")
     * @param Dentiste $dentiste
     * @return type
     */
    public function dentisteDetail(Dentiste $dentiste){
        return $this->render('dentiste/show.html.twig', [
            'dentiste' => $dentiste,
        ]);
    }

//     /**     
//      * @Route("/dentiste/{id}", name="dentisteConsultation")
//      * @param Dentiste $dentiste
//      * @return type
//      */
//     public function dentisteConsultation(Dentiste $dentiste)
//     {
      
//         return $this->render('dentiste/show.html.twig', [
//             'dentiste' => $dentiste,
//         ]);
//     }
}