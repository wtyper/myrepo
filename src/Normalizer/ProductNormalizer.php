<?php

namespace App\Normalizer;

use App\Entity\Product;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProductNormalizer implements NormalizerInterface
{
    public function normalize($object, $format = null, array $context = [])
    {
        /** @var Product $object */
        return [
            'id' => $object->getId(),
            'productCategory_id' => $object->getProductCategory()->getId(),
            'name'=> $object->getName(),
            'description'=>$object->getDescription(),
            'dateOfLastModification'=>$object->getDateOfLastModification()
        ];
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Product;
    }
}
