<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;
class WelcomeController extends AbstractController
{
    /**
     * @Route("/pizza", name="pizza")
     */
    public function index()
    {
        return $this->render('pizza/index.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }

    /**
     * @Route("/welcome", name="pizza")
     */
    public function welcome()

    {
        $dt = new DateTime();
        $dt->format('d-m-Y');

        return $this->render('pizza/index.html.twig', [
            'controller_name' => 'WelcomeController',
            'dt' => $dt,
        ]);
    }
}
