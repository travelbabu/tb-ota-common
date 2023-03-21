<?php

namespace SYSOTEL\OTA\Common\DB\MongoODM\Documents\IAM;

class PermissionBlock
{
    public string $app;
    public string $component;
    public string $category;
    public string $operation;

    public function __construct(string|Permission $permission)
    {
        $permission = Permission::resolveID($permission);
        $items = explode(':', $permission) +  ['*', '*', '*', '*'];

        $this->app = $items[0];
        $this->component = $items[1];
        $this->category = $items[2];
        $this->operation = $items[3];
    }

    public function matches(string|Permission $permission): bool
    {
        $block = new self($permission);

        return  in_array($this->app, ['*', $block->app]) &&
            in_array($this->component, ['*', $block->component]) &&
            in_array($this->category, ['*', $block->category]) &&
            in_array($this->operation, ['*', $block->operation]);
    }
}
