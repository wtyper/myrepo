<?php
namespace App\Command;
use App\Entity\ProductCategory;
use DateTime;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
class ImportCategoriesFromCsvCommand extends Command
{
    private const FILENAME = 'fileName';
    protected static $defaultName = 'app:import-productCategory';
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var ObjectRepository
     */
    private $repository;
    /**
     * ExportToCsvCommand constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('App:ProductCategory');
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->setDescription('Import items from CSV')
            ->addArgument(self::FILENAME, InputArgument::REQUIRED, 'a name of a file where data will be saved');
        parent::configure();
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $timeStart = microtime(true);
        if ($reader = Reader::createFromPath($input->getArgument(self::FILENAME))) {
            $results = $reader->fetchAssoc();
            $output->writeln('Starting the import...');
            $dateTimeNow = new DateTime('now');
            foreach ($results as $row) {
                if (!($productCategory = $this->repository->find($row['id']))) {
                    $productCategory = new productCategory();
                    $productCategory->setDateOfCreation($dateTimeNow);
                }
                $productCategory->setName($row['name']);
                $productCategory->setDescription($row['description']);
                $productCategory->setDateOfLastModification($dateTimeNow);
                $this->em->persist($productCategory);
            }
            $this->em->flush();
            $output->writeln('Done! Import took ' . (microtime(true) - $timeStart) . ' seconds.');
        }
    }
}