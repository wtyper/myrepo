<?php

namespace App\Controller\API;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * ProductController
 * @Route("/api", name="api_")
 */
class ProductController extends AbstractController
{
    /**
     * @var ProductRepository $productRepository
     */
    private $productRepository;
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(ProductRepository $productRepository, EntityManagerInterface $em)
    {
        $this->productRepository = $productRepository;
        $this->em = $em;
    }

    /** Show all Products.
     * @Rest\Get("/product/all")
     */
    public function getProducts(): JsonResponse
    {
        return new JsonResponse($this->em->createQueryBuilder()
            ->select(['p.id', 'p.name'])
            ->from('App:Product', 'p')
            ->getQuery()
            ->getResult()
        );
    }

    /** Show one product.
     * @Rest\Get("/product/{id}")
     * @param int $id
     * @return JsonResponse
     */
    public function getProduct(int $id): JsonResponse
    {
        $product = $this->productRepository->find($id);
        return new JsonResponse($product, $product ? JsonResponse::HTTP_OK : JsonResponse::HTTP_NOT_FOUND);
    }

    /** Delete a Product
     * @Rest\Delete("/product/remove/{id}")
     * @param int $id
     * @return JsonResponse
     * @throws ORMException
     */
    public function deleteProduct(int $id): JsonResponse
    {
        if ($product = $this->productRepository->find($id)) {
            $this->em->remove($product);
            $this->em->flush();
            return new JsonResponse(['Product was successfully deleted!']);
        }
        return new JsonResponse(['Could not find the product', JsonResponse::HTTP_NOT_FOUND]);
    }

    /**
     * Create Product.
     * @Rest\Post("/product")
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     */
    public function postProduct(Request $request): JsonResponse
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form = $this->createForm(ProductType::class, $product, ['csrf_protection' => false]);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($product);
            $this->em->flush();
            return new JsonResponse(['status' => 'OK'], JsonResponse::HTTP_CREATED);
        }
        return new JsonResponse([$this->getErrorsFromForm($form)], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }
    /**
     * @param FormInterface $form
     * @return array
     */
    private function getErrorsFromForm(FormInterface $form): array
    {
        $errors = [];
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface && $childErrors = $this->getErrorsFromForm($childForm)) {
                $errors[$childForm->getName()] = $childErrors;
            }
        }
        return $errors;
    }
    /**
     * Edit Product.
     * @Rest\Put("/product/{id}/edit")
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function editProduct(Request $request, int $id): JsonResponse
    {
        if ($product = $this->productRepository->find($id)) {
            $form = $this->createForm(ProductType::class, $product, ['csrf_protection' => false]);
            $form->submit(json_decode($request->getContent(), true));
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($product);
                $this->em->flush();
                return new JsonResponse(['status' => 'OK']);
            }
            return new JsonResponse([$this->getErrorsFromForm($form)], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        return new JsonResponse('Product was not found!', JsonResponse::HTTP_NOT_FOUND);
    }
}