<?php
namespace App\Controller;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/wishlist")
 */
class WishlistController extends AbstractController
{
    /**
     * @Route("/add/{id}", name ="wishlist_add")
     */
    public function add(Product $product)
    {
        $session = new Session(new NativeSessionStorage(), new NamespacedAttributeBag());
        $wishlist = $session->all();
        $id = $product->getId();
        if(!isset($wishlist['wishlist'])) {
            $session->set('wishlist/' . $id,$id);
            $this->addFlash('notice', 'Add to wishlist ID:' . $id);
        }
        return $this->redirectToRoute('product_index');
    }
}