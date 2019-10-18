<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
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
        return $this->render('pizza/index.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }
}
