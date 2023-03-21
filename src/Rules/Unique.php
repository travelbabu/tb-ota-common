<?php

namespace SYSOTEL\OTA\Common\Rules;

use Delta4op\MongoODM\Facades\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

/**
 * Class UniqueEmail
 *
 * @author Ravish
*/
class Unique extends BaseRule
{
    /**
     * Document repository
     *
     * @var DocumentRepository
    */
    protected DocumentRepository $repository;

    /**
     * @var string
     */
    private string $field;

    public function __construct(string $class, string $field = '_id')
    {
        $this->repository = DocumentManager::getRepository($class);
        $this->field = $field;
    }

    /**
     * Validation
     *
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
         $result = $this->repository->findOneBy([
             $this->field => $value
         ]);

        return $result === null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return ':attribute already taken';
    }
}
