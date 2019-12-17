<?php
namespace App\Command;

use App\Normalizer\ProductNormalizer;
use App\Repository\ProductRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class ExportProductToCsvCommand extends ExportToCsvCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:export-products';

    /**
     * @var ObjectRepository
     */
    private $repositoryCategory;

    /**
     * ExportProductsToCsvCommand constructor.
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository, new ProductNormalizer);
    }
}