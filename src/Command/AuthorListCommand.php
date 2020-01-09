<?php
namespace App\Command;

use App\Entity\Author;
use App\Helper\StringHelper;
use App\Repository\AuthorRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Filesystem\Filesystem;
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

    /**
     * @var fileSystem
     */
    private $fileSystem;

    public function __construct(AuthorRepository $authorRepository, FileSystem $fileSystem, string $name = null)
    {
        $this->authorRepository = $authorRepository;
        $this->fileSystem = $fileSystem;
        parent::__construct();
    }

    public function configure(): void {
        $this
            ->addOption('char', null, InputOption::VALUE_REQUIRED, 'Give a first letter of authors last name')
            ->addOption('save', null, InputOption::VALUE_REQUIRED, 'Give a file name!');
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
        $data = '';
        $fileName= $this->processFileName((string)$input->getOption('save'), $output);
        foreach ($authors as $author) {
            $fields = [$author->getId(), $author->getLastName(), $author->getName(), count($author->getBooks())];
            $table->addRow(array_values($fields));
            if ($fileName){
                $data .=implode(' ', array_values($fields)) . "\n";
            }
        }
        $table->setStyle('box');
        $table->render();
        if($fileName){
            $this->fileSystem->dumpFile($fileName, $data);
            $output->writeln('Your data has been saved in ' . $fileName);
        }
    }
    /**
     * @param InputInterface $input
     * @return Author[]|bool|mixed
     */
    private function getDataFromAuthors(InputInterface $input)
    {
        $char=$input->getOption('char');
        if($char){
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

    private function processFileName(string $fileName, OutputInterface $output){
        if (!StringHelper::endWith($fileName, '.txt')){
            $output->writeln('You should add .txt extension!');
        }
        $fileName =  transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', pathinfo($fileName, PATHINFO_FILENAME));
        while($this->fileSystem->exists($fileName . '.txt')){
            preg_match('/([a-z A-Z]*)(\d+)$/', $fileName, $matches);
            if (isset($matches[1], $matches[2])){
                $fileName = $matches[1] . ++$matches[2];
            } else {
                $i = 1;
                while ($this->fileSystem->exists($fileName . "$i.txt")){
                    $i++;
                }
                $fileName .= $i;
            }
        }
        return $fileName . '.txt';
    }
}
