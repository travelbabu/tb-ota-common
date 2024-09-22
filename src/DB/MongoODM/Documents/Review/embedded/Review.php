<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\Review\embedded;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Delta4op\MongoODM\Documents\EmbeddedDocument;
use SYSOTEL\OTA\Common\Enums\ReviewCommenterType;
use function SYSOTEL\OTA\Common\Helpers\arrayFilter;

/**
 * @ODM\EmbeddedDocument
 */
class Review extends EmbeddedDocument
{
    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $totalComments;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $totalGuestComments;

    /**
     * @var ?int
     * @ODM\Field(type="int")
     */
    public $totalManagementComments;

    /**
     * @var ArrayCollection & ReviewComment[]
     * @ODM\EmbedMany (targetDocument=ReviewComment::class)
     */
    public ArrayCollection $comments;

    public function __construct(array $attributes = [])
    {
        $this->comments = new ArrayCollection;

        parent::__construct($attributes);
    }

    public function calculateCommentCounts(): static
    {
        $this->totalComments = 0;
        $this->totalGuestComments = 0;
        $this->totalManagementComments = 0;

        foreach($this->comments as $comment) {
            $this->totalComments++;

            if ($comment->commenterType === ReviewCommenterType::GUEST) {
                $this->totalGuestComments++;
            } elseif ($comment->commenterType === ReviewCommenterType::ADMIN) {
                $this->totalManagementComments++;
            } elseif ($comment->commenterType === ReviewCommenterType::EXTRANET_USER) {
                $this->totalManagementComments++;
            } elseif ($comment->commenterType === ReviewCommenterType::UNKNOWN) {
                $this->totalManagementComments++;
            }
        }

        return $this;
    }

    /**
     * @inheritDoc
    */
    public function toArray(): array
    {
        return arrayFilter([

        ]);
    }
}
