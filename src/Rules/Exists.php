<?php

namespace SYSOTEL\OTA\Common\Rules;

use Delta4op\MongoODM\Facades\DocumentManager;
use Doctrine\ODM\MongoDB\Repository\DocumentRepository;

/**
 * Class UniqueEmail
 *
 * @author Ravish
*/
class Exists extends BaseRule
{
    /**
     * Document repository
     *
     * @var DocumentRepository
    */
    protected DocumentRepository $repository;

    protected array $filters;

    /**
     * @var string
     */
    private string $identifier;

    public function __construct(string $class, string $identifier = '_id', array $filters = [])
    {
        $this->repository = DocumentManager::getRepository($class);
        $this->identifier = $identifier;
        $this->filters = $filters;
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
        $criteria = array_merge(
            [$this->identifier => $value],
            $this->filters
        );

         $result = $this->repository->findOneBy($criteria);

        return $result !== null;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Field does not exists';
    }
}
