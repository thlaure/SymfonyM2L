<?php
/**
 * Created by IntelliJ IDEA.
 * User: Thomas LAURE
 * Date: 14/04/2018
 * Time: 16:56
 */

namespace App\Controller;

use App\Entity\Atelier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class FormController extends Controller
{
    /**
     * Méthode permettant de créer le formulaire.
     * @return \Symfony\Component\Form\FormInterface
     */
    public function creerFormulaire()
    {
        return $this->createFormBuilder()
            ->add('atelier', EntityType::class, array(
                'class' => 'App\Entity\Atelier',
                'multiple' => false,
                'choice_label' => 'libelleAtelier',
                'placeholder' => 'Sélectionnez l\'atelier'
            ))
            ->add('avis', EntityType::class, array(
                'class' => 'App\Entity\Avis',
                'required' => 'true',
                'multiple' => false,
                'choice_label' => 'libelleAvis',
                'expanded' => 'true',
                'label' => 'libelleAvis'
            ))
            ->add('btnEnvoyer', SubmitType::class, array(
                'label' => 'Envoyer'
            ))
            ->getForm();
    }

    /**
     * Méthode permettant de traiter l'avis laisser par le participant.
     * @Route("/form", name="formulaire")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function traitementFormulaire(Request $request)
    {
        $formulaire = $this->creerFormulaire();
        $formulaire->handleRequest($request);
        $message = '';
        $nbAvisAtelier = 0;
        if ($request->isMethod('POST')) {
            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
                $message = '<div class="container"><div class="alert alert-success" role="alert">L\'enregistrement a été validé !</div></div>';
                $atelier = $formulaire['atelier']->getData();
                $avis = $formulaire['avis']->getData();
                $atelier->addAvis($avis);
                $nbAvisAtelier = $this->recupNbAvisAtelier($atelier->getId());
                $this->enregistrerAvis($atelier, $avis);
                return $this->render('formulaire.html.twig', array('nbavis' => $nbAvisAtelier, 'message' => $message, 'form' => $formulaire->createView()));
            } else {
                $message = '<div class="container"><div class="alert alert-danger" role="alert">Un problème est survenu lors de l\'enregistrement.</div ></div >';
                return $this->render('formulaire.html.twig', array('nbavis' => $nbAvisAtelier, 'message' => $message, 'form' => $formulaire->createView()));
            }
        }
        return $this->render('formulaire.html.twig', array('message' => $message, 'nbavis' => $nbAvisAtelier, 'form' => $formulaire->createView()));
    }

    /**
     * Méthode permettant de faire persister en base de données l'avis d'un bénévole sur un atelier.
     * @param $atelier
     * @param $avis
     */
    public function enregistrerAvis($atelier, $avis)
    {
        $atelier->addAvis($avis);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($atelier);
        $entityManager->flush();
    }

    /**
     * Retourne le nombre d'avis laissés sur l'atelier passé en paramètre.
     * @param $idAtelier
     * @return integer
     */
    public function recupNbAvisAtelier(int $idAtelier)
    {
        $atelier = $this->getDoctrine()->getManager()->getRepository(Atelier::class)->find($idAtelier);
        $nbAvisAtelier = $atelier->getAvis()->count();
        return $nbAvisAtelier;
    }
}