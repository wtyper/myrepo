<?php

namespace App\Controller;

use App\Entity\ProductCategory;
use App\Form\ProductCategoryType;
use App\Repository\ProductCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/product/category")
 */
class ProductCategoryController extends AbstractController
{
    /**
     * @var TranslatorInterface $translator
     */
    private $translator;

    /**
     * ProductCategoryController constructor.
     * @param TranslatorInterface $translator
     */

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    /**
     * @Route("/", name="product_category_index", methods={"GET"})
     */
    public function index(ProductCategoryRepository $productCategoryRepository): Response
    {
        return $this->render('product_category/index.html.twig', [
            'product_categories' => $productCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_category_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $productCategory = new ProductCategory();
        $form = $this->createForm(ProductCategoryType::class, $productCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($productCategory);
            $entityManager->flush();
            $this->addFlash(
                'success',
                $this->translator->trans('Category created successfully!')
            );
            return $this->redirectToRoute('product_category_index');
        }
        return $this->render('product_category/new.html.twig', [
            'product_category' => $productCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_category_show", methods={"GET"})
     */
    public function show(ProductCategory $productCategory): Response
    {
        return $this->render('product_category/show.html.twig', [
            'product_category' => $productCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="product_category_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProductCategory $productCategory): Response
    {
        $form = $this->createForm(ProductCategoryType::class, $productCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                $this->translator->trans('Category edited successfully!')
            );
            return $this->redirectToRoute('product_category_index');
        }
        return $this->render('product_category/edit.html.twig', [
            'product_category' => $productCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="product_category_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ProductCategory $productCategory): Response
    {
        if ($this->isCsrfTokenValid('delete' . $productCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($productCategory);
            $entityManager->flush();
            $this->addFlash(
                'success',
                $this->translator->trans('Category deleted successfully!')
            );
        }
        return $this->redirectToRoute('product_category_index');
    }

    /**
     * @Route("/", name="product_categories", methods="GET")
     */
    public function productCategories(ProductCategoryRepository $productCategoryRepository): Response
    {
        return $this->render('product_category/_categories.html.twig', [
            'productCategories'=> $productCategoryRepository->findAll(),
        ]);
    }
}
