<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class RandomBookService
{
    private const LAST_RNG_BOOK = 'LAST_RNG_BOOK';
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
        $this->session->set(self::LAST_RNG_BOOK, $book);
    }
    /**
     * @return mixed
     */
    public function getSessionBook()
    {
        return $this->session->get(self::LAST_RNG_BOOK, '');
    }
}