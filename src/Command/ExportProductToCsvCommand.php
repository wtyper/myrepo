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
     * ExportProductsToCsvCommand constructor.
     * @param ProductRepository $repository
     * @param ProductNormalizer $normalizer
     */
    public function __construct(ProductRepository $repository, ProductNormalizer $normalizer)
    {
        parent::__construct($repository, $normalizer);
    }
}
