<?php
namespace App\Command;
use App\Repository\ProductRepository;
use Symfony\Component\Serializer\SerializerInterface;
class ExportProductsToCsvCommand extends ExportToCsvCommand
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:export-products';
    /**
     * ExportProductsToCsvCommand constructor.
     * @param ProductRepository $repository
     * @param SerializerInterface $serializer
     */
    public function __construct(ProductRepository $repository, SerializerInterface $serializer)
    {
        parent::__construct($repository, $serializer);
    }
}