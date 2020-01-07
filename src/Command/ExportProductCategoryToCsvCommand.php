<?php
namespace App\Command;

use App\Repository\ProductCategoryRepository;

class ExportProductCategoryToCsvCommand extends ExportToCsvCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:export-productCategory';
    /**
     * ExportProductsToCsvCommand constructor.
     * @param ProductCategoryRepository $repository
     */
    public function __construct(ProductCategoryRepository $repository)
    {
        parent::__construct($repository);
    }
}
