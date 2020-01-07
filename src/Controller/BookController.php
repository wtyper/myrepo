<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Service\RandomBookService;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Route("/book")
 * @property FileUploader fileUploader
 */
class BookController extends AbstractController
{
    /**
     * BookController constructor.
     * @param FileUploader $fileUploader
     */
    public function __construct(FileUploader $fileUploader)
    {
        $this->fileUploader = $fileUploader;
    }

    /**
     * @Route("/", name="book_index", methods={"GET"})
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="book_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (($cover = $form['cover']->getData()) instanceof UploadedFile) {
                $book->setCover($this->fileUploader->upload($cover));
            }
            $entityManager->persist($book);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Book "' . $book->getTitle() . '" created successfully!'
            );
            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="book_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Book $book): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (($cover = $form['cover']->getData()) instanceof UploadedFile) {
                $book->setCover($this->fileUploader->upload($cover));
            }
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'Book "' . $book->getTitle() . '" updated successfully!'
            );
            return $this->redirectToRoute('book_index');
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="book_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Book $book): Response
    {
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($book);
            if ($book->getCover()) {
                $this->fileUploader->delete($book->getCover());
            }
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Book "' . $book->getTitle() . '" deleted successfully!'
            );
        }

        return $this->redirectToRoute('book_index');
    }

    /**
     * @Route("/booklist", name="bookList", methods="GET")
     */
    public function bookList(BookRepository $bookRepository): Response
    {
        return $this->render('book/_books.html.twig', [
            'bookList' => $bookRepository->findBy([], ['dateOfCreate' => 'ASC'], 5),
        ]);
    }

    /**
     * @Route("/random", name="random_book", methods="GET")
     */
    public function random(BookRepository $bookRepository, EntityManagerInterface $em, RandomBookService $randomBookService, LoggerInterface $logger): Response
    {
        $bookId = $em->createQueryBuilder()
            ->select('b.id')
            ->from('App:Book', 'b')
            ->getQuery()
            ->getArrayResult();
        $randomBook = $bookRepository->find($bookId[array_rand($bookId)]['id']);
        if (!$randomBook) {
            throw $this->createNotFoundException('There are no products.');
        }
        $randomBookService->setSessionBook($randomBook->getId());
        $logger->info('Book with ID:' . $randomBook->getId() . ' was randomly chosen.');
        return $this->show($randomBook);
    }

    /**
     * @param RandomBookService $randomBookService
     * @return Response
     */
    public function lastRandomBookLink(RandomBookService $randomBookService)
    {
        if ($id = $randomBookService->getSessionBook()) {
            return $this->render('_last_random_book.html.twig', ['id' => $id]);
        }
        return $this->render('libraryBase.html.twig');
    }

    /**
     * @Route("/{id}", name="book_show", methods={"GET"})
     */
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/{id}/delete-cover", name="book_delete_cover", methods={"DELETE"})
     * @param Request $request
     * @param Book $book
     * @return Response
     */
    public function deleteCover(Request $request, Book $book): Response
    {
        if ($book->getCover() &&
            $this->isCsrfTokenValid(
                'delete-book-cover' . $book->getId(), $request->request->get('_token')
            )
        ) {
            $em = $this->getDoctrine()->getManager();
            $this->fileUploader->delete($book->getCover());
            $book->setCover(null);
            $em->flush();
            $this->addFlash('success', 'Book cover deleted successfully!');
        }
        return $this->redirectToRoute('book_edit', ['id' => $book->getId()]);
    }
}