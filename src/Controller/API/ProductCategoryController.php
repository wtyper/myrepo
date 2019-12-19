<?php
namespace App\Controller\API;
use App\Entity\ProductCategory;
use App\Form\ProductCategoryType;
use App\Repository\ProductCategoryRepository;
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
 * @Route("product/category/api", name="api_product_category_")
 */
class ProductCategoryController extends AbstractController
{
    /**
     * @var ProductCategoryRepository $productRepository
     */
    private $productCategoryRepository;
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * ProductRESTController constructor.
     * @param ProductCategoryRepository $productCategoryRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(ProductCategoryRepository $productCategoryRepository, EntityManagerInterface $em)
    {
        $this->productCategoryRepository = $productCategoryRepository;
        $this->em = $em;
    }
    /** Show all Categories.
     * @Rest\Get("/product/category")
     */
    public function getCategories(): JsonResponse
    {
        return new JsonResponse($this->em->createQueryBuilder()
            ->select(['c.id', 'c.name'])
            ->from('App:ProductCategory', 'c')
            ->getQuery()
            ->getResult()
        );
    }
    /** Show one productCategory.
     * @Rest\Get("/product/category/{id}")
     * @param int $id
     * @return JsonResponse
     */
    public function getProductCategory(int $id): JsonResponse
    {
        $productCategory = $this->productCategoryRepository->find($id);
        return new JsonResponse($productCategory, $productCategory ? JsonResponse::HTTP_OK : JsonResponse::HTTP_NOT_FOUND);
    }
    /** Delete a productCategory
     * @Rest\Delete("/product/category/remove/{id}")
     * @param int $id
     * @return JsonResponse
     * @throws ORMException
     */
    public function deleteProductCategory(int $id): JsonResponse
    {
        if ($productCategory = $this->productCategoryRepository->find($id)) {
            $this->em->remove($productCategory);
            $this->em->flush();
            return new JsonResponse(['Product category was successfully deleted!']);
        }
        return new JsonResponse(['Could not find the product category', JsonResponse::HTTP_NOT_FOUND]);
    }
    /**
     * Create ProductCategory.
     * @Rest\Post("/product/category")
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     */
    public function postProductCategory(Request $request): JsonResponse
    {
        $productCategory = new productCategory();
        $form = $this->createForm(productCategoryType::class, $productCategory, ['csrf_protection' => false]);
        $form->submit(json_decode($request->getContent(), true));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($productCategory);
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
     * @Rest\Put("/product/category/{id}/edit")
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function editProductCategory(Request $request, int $id): JsonResponse
    {
        if ($productCategory = $this->productCategoryRepository->find($id)) {
            $form = $this->createForm(ProductCategoryType::class, $productCategory, ['csrf_protection' => false]);
            $form->submit(json_decode($request->getContent(), true));
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($productCategory);
                $this->em->flush();
                return new JsonResponse(['status' => 'OK']);
            }
            return new JsonResponse([$this->getErrorsFromForm($form)], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        return new JsonResponse('Product category was not found!', JsonResponse::HTTP_NOT_FOUND);
    }
}