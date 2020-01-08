<?php
namespace App\Command;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AuthorListCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:author-list';
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->authorRepository = $authorRepository;
        parent::__construct();
    }

    public function configure(): void {
        $this
            ->addOption('char', null, InputOption::VALUE_REQUIRED, 'Give a first letter of authors last name');
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $authors = $this->getDataFromAuthors($input);
            if ($authors === false){
                $output->writeln('Give a valid character!');
                return;
    }
        $table = new Table($output);
        $table->setHeaders(['Id', 'Nazwisko', 'Imię', 'Ilość książek']);
        foreach ($authors as $author) {
            $fields = [$author->getId(), $author->getLastName(), $author->getName(), count($author->getBooks())];
            $table->addRow(array_values($fields));
        }
        $table->setStyle('box');
        $table->render();
    }

    /**
     * @param InputInterface $input
     * @return Author[]|bool|mixed
     */
    private function getDataFromAuthors(InputInterface $input)
    {
        if($char=$input->getOption('char')){
            if(strlen($char) !=1 || !ctype_alpha($char)){
                return false;
            }
            return $this->authorRepository
                ->createQueryBuilder('a')
                ->where('a.lastName LIKE :char')
                ->setParameter('char', $char . '%')
                ->getQuery()
                ->getResult();
        }
        return $this->authorRepository->findAll();
    }
}