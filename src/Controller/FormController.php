<?php
/**
 * Created by IntelliJ IDEA.
 * User: Thomas LAURE
 * Date: 14/04/2018
 * Time: 16:56
 */

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\AtelierAvis;
use App\Entity\Avis;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FormController
 *
 * @category Symfony4
 * @package  App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class FormController extends Controller
{
    /**
     * Méthode permettant de traiter l'avis laisser par le participant.
     *
     * @param Request $request Instance de la classe Request.
     *
     * @Route("/", name="formulaire")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function traitementFormulaire(Request $request) : ?Response
    {
        $formulaire = $this->creerFormulaire();
        $formulaire->handleRequest($request);
        if ($request->isMethod('POST')) {
            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
                $atelier = $formulaire['atelierEntity']->getData();
                $avis = $formulaire['avisEntity']->getData();
                // Contrôles nécessaires avant d'enregistrer
                // un avis en base de données.
                $existe = $this->verifExistenceAtelierAvis($atelier, $avis);
                if ($existe == true
                    && $this->verifNbPlacesSuperieurQuantiteAvis($atelier)
                ) {
                    $this->updateQuantite($atelier, $avis);
                } else {
                    $this->enregistrerAtelierAvis($atelier, $avis);
                }
                return $this->render(
                    'formulaire.html.twig', array(
                        'nbAvis' => $this->recupQuantiteAvis($atelier),
                        'nomAtelier' => $atelier->getLibelleAtelier(),
                        'textAlert' => 'L\'enregistrement a été validé !',
                        'classAlert' => 'alert-success',
                        'form' => $formulaire->createView()
                    )
                );
            } else {
                return $this->render(
                    'formulaire.html.twig',
                    array(
                        'nbAvis' => 0,
                        'nomAtelier' => '',
                        'textAlert' => 'Un problème est survenu lors de l\'enregistrement.',
                        'classAlert' => 'alert-danger',
                        'form' => $formulaire->createView()
                    )
                );
            }
        }
        return $this->render(
            'formulaire.html.twig', array(
                'nbAvis' => 0,
                'nomAtelier' => '',
                'form' => $formulaire->createView()
            )
        );
    }

    /**
     * Méthode permettant de créer le formulaire.
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function creerFormulaire()
    {
        return $this->createFormBuilder()
            ->add(
                'atelierEntity', EntityType::class, array(
                    'class' => 'App\Entity\Atelier',
                    'multiple' => false,
                    'choice_label' => 'libelleAtelier',
                    'placeholder' => 'Sélectionnez l\'atelier'
                )
            )
            ->add(
                'avisEntity', EntityType::class, array(
                    'class' => 'App\Entity\Avis',
                    'required' => 'true',
                    'multiple' => false,
                    'choice_label' => 'libelleAvis',
                    'expanded' => 'true',
                    'label' => 'libelleAvis'
                )
            )
            ->add(
                'btnEnvoyer', SubmitType::class,  array(
                    'label' => 'Envoyer'
                )
            )
            ->getForm();
    }

    /**
     * Méthode permettant de faire persister en base de données
     * l'avis d'un bénévole sur un atelier.
     *
     * @param Atelier $atelier Atelier sur lequel l'avis est laissé.
     * @param Avis    $avis    Avis qui est laissé sur l'atelier.
     *
     * @return void
     */
    public function enregistrerAtelierAvis($atelier, $avis)
    {
        $atelierAvis = $this->creerAtelierAvis($atelier, $avis);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($atelierAvis);
        $entityManager->flush();
    }

    /**
     * Méthode qui va récupérer une liste d'objets AtelierAvis
     * en fonction d'un atelier passé en paramètre,
     * et parcourir cette liste pour additionner toutes les quantités.
     *
     * @param Atelier $atelier Atelier sur lequel l'avis est laissé.
     *
     * @return int|null|Response
     */
    public function recupQuantiteAvis($atelier)
    {
        $repository = $this->getDoctrine()->getRepository(AtelierAvis::class);
        $result = $repository->findBy(
            array(
                'atelier' => $atelier
            )
        );
        $nbAvisAtelier = 0;
        foreach ($result as $lAtelierAvis) {
            $nbAvisAtelier += $lAtelierAvis->getQuantite();
        }
        if ($nbAvisAtelier < 0) {
            return $this->render(
                'error.html.twig',
                array(
                    'errorMessage' => 'Une erreur est survenue dans la gestion du nombre d\'avis laissés sur cet atelier. Veuillez contactez le service informatique.'
                )
            );
        } else {
            return $nbAvisAtelier;
        }
    }

    /**
     * Méthode qui vérifie l'existence en base de données de l'AtelierAvis
     * possédant l'Atelier et l'Avis passés en paramètres.
     * Retourne Vrai si l'AtelierAvis existe.
     *
     * @param Atelier $atelier Atelier sur lequel l'avis est laissé.
     * @param Avis    $avis    Avis qui est laissé sur l'atelier.
     *
     * @return bool|null
     */
    public function verifExistenceAtelierAvis($atelier, $avis) : ?bool
    {
        $repository = $this->getDoctrine()->getRepository(AtelierAvis::class);
        $result = $repository->findOneBy(
            array(
                'atelier' => $atelier,
                'avis' => $avis
            )
        );
        return $result != null;
    }

    /**
     * Méthode permettant de mettre à jour
     * la quantité d'un AtelierAvis déjà existant.
     *
     * @param Atelier $atelier Atelier sur lequel l'avis est laissé.
     * @param Avis    $avis    Avis qui est laissé sur l'atelier.
     *
     * @return Response
     */
    public function updateQuantite($atelier, $avis)
    {
        $atelierAvis = $this->recupLAtelierAvis($atelier, $avis);
        if ($atelierAvis->getQuantite() > 0) {
            $atelierAvis->setQuantite($atelierAvis->getQuantite() + 1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        } else {
            return $this->render(
                'error.html.twig',
                array(
                    'errorMessage' => 'Une erreur est survenue dans la gestion du nombre d\'avis laissés sur cet atelier. Veuillez contactez le service informatique.'
                )
            );
        }
    }

    /**
     * Récupère l'enregistrement de la table atelier_avis
     * qui contient l'atelier et l'avis passés en paramètres.
     *
     * @param Atelier $atelier Atelier sur lequel l'avis est laissé.
     * @param Avis    $avis    Avis qui est laissé sur l'atelier.
     *
     * @return AtelierAvis|null|object
     */
    public function recupLAtelierAvis($atelier, $avis) : ?AtelierAvis
    {
        $repository = $this->getDoctrine()->getRepository(AtelierAvis::class);
        return $repository->findOneBy(
            array(
                'atelier' => $atelier,
                'avis' => $avis
            )
        );
    }

    /**
     * Méthode permettant de créer un objet AtelierAvis.
     *
     * @param Atelier $atelier Atelier sur lequel l'avis est laissé.
     * @param Avis    $avis    Avis qui est laissé sur l'atelier.
     *
     * @return AtelierAvis
     */
    public function creerAtelierAvis($atelier, $avis) : ?AtelierAvis
    {
        $atelierAvis = new AtelierAvis();
        $atelierAvis->setAtelier($atelier);
        $atelierAvis->setAvis($avis);
        $atelierAvis->setQuantite(1);
        return $atelierAvis;
    }

    /**
     * Méthode permettant de vérifier que le nombre de places maximum est
     * bien supérieur à la quantité d'avis laissés sur l'atelier passé en paramètre.
     * Retourne Vrai si le nombre de places maximum est supérieur
     * à la quantité d'avis laissés,
     * sinon retourne Faux.
     *
     * @param Atelier $atelier Atelier sur lequel l'avis est laissé.
     *
     * @return bool|null
     */
    public function verifNbPlacesSuperieurQuantiteAvis($atelier) : ?bool
    {
        return $atelier->getNbPlacesMaxi() < $this->recupQuantiteAvis($atelier);
    }
}