<?php
namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\ProductLogger;
use App\Repository\ProductRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @var ProductLogger $logger
     */
    private $logger;

    /**
     * @var FileUploader $fileUploader
     */
    private $fileUploader;

    public function __construct(ProductLogger $logger, FileUploader $fileUploader)
    {
        $this->logger = $logger;
        $this->fileUploader = $fileUploader;
    }

    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product = new Product());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (($cover = $form['cover']->getData()) instanceof UploadedFile) {
                $product->setCover($this->fileUploader->upload($cover));
            }
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Product created successfully!'
            );
            $this->logger->log($product->getId(), $this->logger::CREATE);
            return $this->redirectToRoute('product_index');
        }
        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        $this->logger->log($product->getId(), $this->logger::DISPLAY);
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_edit", methods={"GET","PATCH"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product, ['method' => 'PATCH']);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (($cover = $form['cover']->getData()) instanceof UploadedFile) {
                $product->setCover($this->fileUploader->upload($cover));
            }
            $this->getDoctrine()->getManager()->persist($product);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'Product edited successfully!'
            );
            $this->logger->log($product->getId(), $this->logger::UPDATE);
            return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
        }
        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'. $product->getId(), $request->request->get('_token'))) {
            $productId = $product->getId();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            if ($product->getCover()) {
                $this->fileUploader->delete($product->getCover());
            }
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Product deleted successfully!'
            );
        }
        $this->logger->log($productId->getId(), $this->logger::DELETE);
        return $this->redirectToRoute('product_index');
    }

    /**
     * @Route("/{id}/delete-cover", name="product_delete_cover", methods={"DELETE"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function deleteCover(Request $request, Product $product): Response
    {
        if ($product->getCover() &&
            $this->isCsrfTokenValid(
                'delete-product-cover' . $product->getId(), $request->request->get('_token')
            )) {
            $em = $this->getDoctrine()->getManager();
            $this->fileUploader->delete($product->getCover());
            $product->setCover(null);
            $em->flush();
            $this->addFlash('success', 'Product cover deleted');
        }
        return $this->redirectToRoute('product_edit', ['id' => $product->getId()]);
    }
}
