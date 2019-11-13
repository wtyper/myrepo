<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WhishListController extends AbstractController
{
    /**
     * @Route("/whishlist", name="whish_list")
     */
    public function index()
    {
        return $this->render('whish_list/index.html.twig', [
            'controller_name' => 'WhishListController',
        ]);
    }
}
