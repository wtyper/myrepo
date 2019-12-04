<?php
namespace App\Controller;
use App\Entity\Image;
use App\Entity\Product;
use App\Form\ImageType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/product")
 * @property FileUploader fileUploader
 */
class ProductGalleryController extends AbstractController
{
    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }
    /**
     * @Route("/{id}/gallery/add", name="product_gallery_add", methods={"GET","POST"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function new(Request $request, Product $product): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $image->setProduct($product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (($file = $form['file']->getData()) instanceof UploadedFile) {
                $image->setFile($this->fileUploader->upload($file));
            }
            $entityManager->persist($image);
            $entityManager->flush();
            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }
        return $this->render('product/gallery/add.html.twig', [
            'image' => $image,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{product}/gallery/{image}", name="product_gallery_show_one", methods={"GET"})
     * @param Product $product
     * @param Image $image
     * @return Response
     */
    public function show(Product $product, Image $image): Response
    {
        return $this->render('product/gallery/show.html.twig', [
            'image' => $image,
            'product' => $product
        ]);
    }
}