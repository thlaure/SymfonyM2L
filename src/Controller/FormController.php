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
            ->add('listeAteliers', EntityType::class, array(
                'class' => 'App\Entity\Atelier',
                'multiple' => false,
                'choice_label' => 'libelleAtelier',
                'placeholder' => 'Sélectionnez l\'atelier'
            ))
            ->add('listeAvis', EntityType::class, array(
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
        if ($request->isMethod('POST') && $formulaire->isSubmitted() && $formulaire->isValid()) {
            $atelier = $formulaire['listeAteliers']->getData();
            $avis = $formulaire['listeAvis']->getData();
            $this->enregistrerAvis($atelier, $avis);
            return $this->render('check.html.twig');
        }
        return $this->render('formulaire.html.twig', array('form' => $formulaire->createView()));
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
     * Retourne l'ID lié au libellé de l'atelier passé en paramètre.
     * @param $libelleAtelier
     * @return int
     */
    public function recupIdAtelier(string $libelleAtelier) : int
    {
        $atelier = $this->getDoctrine()->getRepository(Atelier::class)->findBy(
            ['libelleAtelier' => $libelleAtelier]
        );
        return $atelier[0]->getId();
    }

    /**
     * Retourne le nombre d'avis laissés sur l'atelier passé en paramètre.
     * @param $libelleAtelier
     * @return mixed
     */
    public function recupNbAvisAtelier(string $libelleAtelier)
    {
        $idAtelier = $this->recupIdAtelier($libelleAtelier);
        $atelier = $this->getDoctrine()->getRepository(Atelier::class)->find($idAtelier);
        $nbAvisAtelier = $atelier->getAvis()->count();
        return $this->render('formulaire.html.twig', [
            'nbAvisAtelier' => $nbAvisAtelier
        ]);
    }
}