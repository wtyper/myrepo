<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RandomBookService
{
    private const LAST_RANDOM_BOOK = 'LAST_RANDOM_BOOK';
    /**
     * @var SessionInterface
     */
    private $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    /**
     * @param string $book
     */
    public function setSessionBook(string $book)
    {
        $this->session->set(self::LAST_RANDOM_BOOK, $book);
    }
    /**
     * @return mixed
     */
    public function getSessionBook()
    {
        return $this->session->get(self::LAST_RANDOM_BOOK, '');
    }
}
