<?php
namespace App\Command;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class ExportToCsvCommand extends Command {

    /**
     * Name of the file where data will be written (required)
     */
    protected const FILENAME = 'fileName';

    /**
     * Second argument to console command (not required)
     */
    protected const ITEM_IDS = 'itemIDs';

    /**
     * @var ServiceEntityRepository $repository
     */
    protected $repository;

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var array
     */
    protected $attributes = ['id', 'name', 'description', 'dateOfCreate', 'dateOfLastModification'];

    /**
     * ExportToCsvCommand constructor.
     * @param ServiceEntityRepository $repository
     */
    public function __construct(ServiceEntityRepository $repository)
    {
        $this->repository = $repository;
        $this->serializer = new Serializer([new DateTimeNormalizer(), new ObjectNormalizer()], [new CsvEncoder()]);
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Exports items to CSV')
            ->addArgument(self::FILENAME, InputArgument::REQUIRED, 'a name of a file where data will be saved')
            ->addArgument(self::ITEM_IDS, InputArgument::IS_ARRAY,
                'IDs of items which will be exported. If this parameter is omitted, all items will be exported (separate multiple IDS with a space)');
        parent::configure();
    }

    protected function dataFromRepository($input): array
    {
        return $input
            ? $this->repository->findBy(['id' => $input->getArgument(self::ITEM_IDS)])
            : $this->repository->findAll();
    }
    protected function saveDataToCsv(InputInterface $input, $handler): void
    {
        $data = $this->serializer->normalize($dataFromRepository, 'csv', ['attributes' => $this->attributes]);
        fwrite($handler, $this->serializer->serialize($data, 'csv'));
        fclose($handler);
        if (!$handler = fopen(preg_replace('/[^A-Za-z0-9]/', '', $input->getArgument(self::FILENAME)) . '.csv', 'wb+')) {
            return;
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $timeStart = microtime(true);
        if (!$dataFromRepository = $this->dataFromRepository($input->getArgument(self::ITEM_IDS))) {
            $output->writeln('No items were found, aborting...');
            return;
        }
        $output->writeln('Found ' . count($dataFromRepository) . ' items, starting the export...');
        $output->writeln('Done! Export took ' . (microtime(true) - $timeStart) . ' seconds.');
        }
}