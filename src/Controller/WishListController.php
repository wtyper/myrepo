<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class WishListController extends AbstractController

{
    /**
     * @Route("/wishlist", name="wishlist")
     */
    public function index()
    {
        return $this->render('wishlist/index.html.twig', [
            'controller_name' => 'WishListController',
        ]);
    }

    private const WISH_LIST_NAME = 'WISHLIST';

    private $session;

    /**
     * @var array
     */
    private $wishList;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
        $this->wishList = $this->session->get(self::WISH_LIST_NAME, []);
    }

    /**
     * @param Product $product
     * @Route("/add/{id}", name="wishlist_add", methods={"POST"})
     * @return Response
     */
    public function add(Product $product): Response
    {
        if (!isset($this->getSessionWishList()[$product->getId()])) {
            if (count($this->wishList) >= 5) {
                $this->addFlash('warning',
                    'Too much product at wishlist!');
            } else {
                $this->wishList[$product->getId()] = $product->getName();
                $this->addFlash('Product added to wishlist!', $product->getName() . ' ');
                $this->setSessionWishList();
            }
        }
        return $this->showProducts();
    }

    public function setSessionWishList(): void
    {
        $this->session->set(self::WISH_LIST_NAME, $this->wishList);
    }

    /**
     * @return Response
     */
    private function showProducts(): Response
    {
        return $this->redirectToRoute('product_index');
    }
    /**
     * @Route("/remove/{id}", name="wishlist_remove", methods={"POST"})
     */
    public function remove(Product $product): Response
    {
        if (isset($this->getSessionWishList()[$product->getId()])) {
            unset($this->wishList[$product->getId()]);
            $this->addFlash('Product removed from wishlist!', $product->getName() . ' ');
        }
        $this->setSessionWishList();
        return $this->showProducts();
    }

    /**
     * @return array
     */
    public function getSessionWishList(): array
    {
        return $this->session->get(self::WISH_LIST_NAME, []);
    }

    /**
     * @return Response
     */
    public function dropdown(): Response
    {
        return $this->render('wishlist/_dropdown.html.twig', [
            'wishList' => $this->getSessionWishList()
        ]);
    }

    public function showWishListProductForm(Product $product): Response
    {
        return $this->render(!isset($this->getSessionWishList()[$product->getId()])
            ? 'wishlist/_add_form.html.twig'
            : 'wishlist/_remove_form.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/clear", name="wishlist_clear", methods={"POST"})
     */
    public function clearSessionWishList(): Response
    {
        $this->wishList = [];
        $this->setSessionWishList();
        return $this->showProducts();
    }

}
