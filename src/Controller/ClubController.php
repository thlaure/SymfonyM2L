<?php
/**
 * Created by IntelliJ IDEA.
 * User: Thomas
 * Date: 25/05/2018
 * Time: 09:03
 */

namespace App\Controller;

use App\Entity\Club;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ClubController.
 *
 * @category Symfony4
 * @package  App\Controller
 * @author   Display Name <thomaslaure3@gmail.com>
 * @license  https://www.gnu.org/licenses/license-list.fr.html GPL
 * @link     https://symfony.com/
 */
class ClubController extends Controller
{
    /**
     * Méthode permettant d'enregistrer un club à partir d'un formulaire.
     *
     * @param Request $request Instance de la classe Request.
     *
     * @Route("/club", name="form_club")
     *
     * @return null|Response
     */
    public function traitementFormulaireClub(Request $request) : ?Response
    {
        $formulaire = $this->creerFormulaire();
        $formulaireSuppr = $this->creerFormulaireSuppr();

        $formulaire->handleRequest($request);
        if ($request->isMethod('POST')) {
            if ($formulaire->isSubmitted() && $formulaire->isValid()) {
                $nomClub = $formulaire['nomClub']->getData();
                $existe = $this->verifExistenceClub($nomClub);
                if ($existe === false) {
                    $this->enregistrerClub($nomClub);
                    return $this->render(
                        'club.html.twig', array(
                            'textAlert' => 'Le club a été enregistré.',
                            'classAlert' => 'alert-success',
                            'form' => $formulaire->createView(),
                            'formSuppr' => $formulaireSuppr->createView()
                        )
                    );
                } else {
                    return $this->render(
                        'club.html.twig', array(
                            'textAlert' => 'Ce club existe déjà.',
                            'classAlert' => 'alert-danger',
                            'form' => $formulaire->createView(),
                            'formSuppr' => $formulaireSuppr->createView()
                        )
                    );
                }
            } else {
                return $this->render(
                    'club.html.twig', array(
                        'textAlert' => 'Un problème est survenu lors de 
                            l\'enregistrement.',
                        'classAlert' => 'alert-danger'
                    )
                );
            }


        }

        return $this->render(
            'club.html.twig', array(
                'form' => $formulaire->createView(),
                'formSuppr' => $formulaireSuppr->createView()
            )
        );
    }

    /**
     * Méthode de création du formulaire d'enregistrement d'un club.
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function creerFormulaire()
    {
        return $this->createFormBuilder()
            ->add(
                'nomClub', TextType::class, array(
                    'required' => true
                )
            )
            ->add(
                'btnEnvoyer', SubmitType::class, array(
                    'label' => 'Enregistrer'
                )
            )
            ->getForm();
    }

    public function creerFormulaireSuppr()
    {
        return $this->createFormBuilder()
            ->add(
                'clubEntity', EntityType::class, array(
                    'class' => 'App\Entity\Club',
                    'multiple' => false,
                    'choice_label' => 'nomClub',
                    'placeholder' => 'Sélectionnez le club à supprimer',
                    'required' => false
                )
            )
            ->add(
                'btnSupprimer', SubmitType::class, array(
                    'label' => 'Supprimer'
                )
            )
            ->getForm();
    }

    /**
     * Méthode permettant de faire persister un club en base de données.
     *
     * @param Club $nomClub Club à faire persister.
     *
     * @return void
     */
    public function enregistrerClub($nomClub)
    {
        $club = $this->creerClub($nomClub);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($club);
        $entityManager->flush();
    }

    /**
     * Méthode permettant de créer un club.
     *
     * @param string $nomClub Nom du club à créer.
     *
     * @return Club
     */
    public function creerClub($nomClub)
    {
        $club = new Club();
        $club->setNomClub($nomClub);
        return $club;
    }

    /**
     * Méthode permettant de vérifier si un club a déjà
     * été enregistré en base de données ou pas.
     *
     * @param string $nomClub Nom du club dont on veut connaître l'existence.
     *
     * @return bool|null
     */
    public function verifExistenceClub($nomClub) : ?bool
    {
        $repository = $this->getDoctrine()->getRepository(Club::class);
        $result = $repository->findOneBy(
            array(
                'nomClub' => $nomClub
            )
        );
        return $result != null;
    }

    /**
     * Méthode permettant de supprimer un club.
     *
     * @param string $nomClub Nom du club à supprimer.
     *
     * @return void
     */
    public function supprimerClub($nomClub)
    {
        $repository = $this->getDoctrine()->getRepository(Club::class);
        $club = $repository->findOneBy(
            array(
                'nomClub' => $nomClub
            )
        );
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($club);
    }
}