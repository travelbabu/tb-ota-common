<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\StorageStrategies;

use SYSOTEL\OTA\Common\DB\MongoODM\Documents\Counter;
use Delta4op\MongoODM\Facades\DocumentManager as DM;
use Doctrine\ODM\MongoDB\DocumentManager as BaseDocumentManager;
use Doctrine\ODM\MongoDB\Id\IdGenerator;

class AutoIncrementID implements IdGenerator
{
    public function generate(BaseDocumentManager $dm, object $document)
    {
        if( ! method_exists($document,'getCollectionName')){
            abort(500,'Failed to find collection name');
        }

        $collectionName = $document->getCollectionName();

        $counter = Counter::queryBuilder()->findAndUpdate()->returnNew()
            ->field('_id')->equals($collectionName)
            ->field('value')->inc(1)
            ->getQuery()->execute();

        if (! $counter){
            abort(500, 'Counter not found for ' . $collectionName);
        }

        return $counter->value;
    }
}
