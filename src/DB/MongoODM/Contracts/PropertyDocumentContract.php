<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Contracts;

interface PropertyDocumentContract
{
    public function docType(): string;
    public function docTypeLabel(): string;
}