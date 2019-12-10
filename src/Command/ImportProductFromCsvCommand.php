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
     * ExportToCsvCommand constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('App:Product');
        parent::__construct();
    }

    protected function configure(): void
    {//todo remove
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
            $products = [];
            foreach ($results as $row) {
                if (!($product = $this->repository->find($row['id']))) {
                    $product = new Product();
                    $product->setDateOfCreation($dateTimeNow);
                }
                if (!isset($products[$row['id']])) {
                    $productCategory = $this->em->getRepository('App:ProductCategory')->find($row['id']);
                    if ($productCategory) {
                        $products[$row['id']] = $productCategory;
                    }
                }
                if (!isset($products[$row['id']])) {
                    $output->writeln('Item with key: ' . $results->key() . ' was not imported!');
                    continue;
                }
                $product->setProductCategory($products[$row['id']]);
                $product->setName($row['name']);
                $product->setDescription($row['description']);
                $product->setDateOfLastModification($dateTimeNow);
                $this->em->persist($product);
            }
            $this->em->flush();
            $output->writeln('Done! Import took ' . (microtime(true) - $timeStart) . ' seconds.');
            return;
        }
    }
}
