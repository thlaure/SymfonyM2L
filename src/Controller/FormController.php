<?php
/**
 * Created by IntelliJ IDEA.
 * User: Thomas LAURE
 * Date: 14/04/2018
 * Time: 16:56
 */

namespace App\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormController extends AbstractController
{
    /**
     * @Route("/avis", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('formulaire.html.twig');
    }
}