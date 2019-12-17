<?php
namespace App\Command;

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
        parent::__construct($repository);
    }

    private function getCategory ($input){
        if ($input) {
            return $this->repositoryCategory->find(['productCategory_id' => $input]);
        } else {
            return $this->repositoryCategory->findAll();
        }
    }
}