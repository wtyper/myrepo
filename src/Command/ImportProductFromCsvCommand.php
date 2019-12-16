<?php
namespace App\Command;

use App\Entity\Product;
use DateTime;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportProductFromCsvCommand extends Command
{
    private const FILENAME = 'fileName';

    protected static $defaultName = 'app:import-products';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var ObjectRepository
     */
    private $repository;
    /**
     * @var ObjectRepository
     */
    private $repositoryCategory;

    /**
     * ExportToCsvCommand constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('App:Product');
        $this->repositoryCategory = $em->getRepository('App:ProductCategory');
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->setDescription('Import items from CSV')
            ->addArgument(self::FILENAME, InputArgument::REQUIRED, 'a name of a file where data will be saved');
        parent::configure();
    }

    private function saveToDataBase ($input, $output)
    {

        $reader = Reader::createFromPath($input->getArgument(self::FILENAME));
        if ($reader) {
            $results = $reader->fetchAssoc();
            $output->writeln('Starting the import...');
            $dateTimeNow = new DateTime('now');
            $categories = [];
            foreach ($results as $row) {
                $productCategory = $this->repositoryCategory->find($row['productCategory_id']);
                if ($productCategory) {
                    $categories[$row['productCategory_id']] = $productCategory;
                }
                if (!isset($categories[$row['productCategory_id']])) {
                    $output->writeln('Item with key: ' . $results->key() . ' was not imported!');
                    continue;
                }
                $product = $this->repository->find($row['id']);
                if (!$product) {
                    $product = new Product();
                    $product->setDateOfCreation($dateTimeNow);
                }
                $name=$product->setName($row['name']);
                $description=$product->setDescription($row['description']);
                $dateOfLastModification=$product->setDateOfLastModification($dateTimeNow);
                $this->setProductData($name, $description, $productCategory, $dateOfLastModification);
                
                $this->em->persist($product);
            }
            $this->em->flush();
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $timeStart = microtime(true);
        $this->saveToDataBase($input, $output);
        $output->writeln('Done! Import took ' . (microtime(true) - $timeStart) . ' seconds.');
        return;
    }

    private function setProductData(Product $name, Product $description, $productCategory,  Product $dateOfLastModification)
    {
    }
}
