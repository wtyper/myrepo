<?php
namespace App\Command;

use App\Repository\ProductRepository;

class ExportProductToCsvCommand extends ExportToCsvCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:export-products';
    /**
     * ExportProductsToCsvCommand constructor.
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        parent::__construct($repository);
    }
}