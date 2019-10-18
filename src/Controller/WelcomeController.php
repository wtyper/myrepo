<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;
class WelcomeController extends AbstractController
{


    /**
     * @Route("/welcome", name="welcome")
     */
    public function welcome()

    {
        $dt = new DateTime();


        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
            'dt' => $dt,
        ]);
    }
}
