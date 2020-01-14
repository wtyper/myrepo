<?php
namespace App\Controller\API;

use App\Repository\BookRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * BookController
 * @Route("/api/book", name="api_book_")
 */
class BookController extends AbstractController
{
    /**
     * @var BookRepository
     */
    private $bookRepository;
    public function __construct(BookRepository $repository)
    {
        $this->bookRepository = $repository;
    }
    /** Show one product.
     * @Rest\Get("/{id}")
     * @param int $id
     * @return JsonResponse
     */
    public function getBook(int $id): JsonResponse
    {
        $book = $this->bookRepository->find($id);
        return new JsonResponse($book, $book ? JsonResponse::HTTP_OK : JsonResponse::HTTP_NOT_FOUND);
    }
    /** Show one product.
     * @Rest\Get("/all")
     * @return JsonResponse
     */
    public function getBooks(): JsonResponse
    {
        $books = $this->bookRepository->findAll();
        return new JsonResponse($books, $books ? JsonResponse::HTTP_OK : JsonResponse::HTTP_NOT_FOUND);
    }
}
