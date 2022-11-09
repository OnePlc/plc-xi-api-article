<?php

namespace Item;

use Laminas\Db\Sql\Select;
use Laminas\Db\TableGateway\TableGateway;

class ItemTableGateway extends TableGateway
{
    public function getAllItems(): array
    {
        $select = new Select($this->getTable());

        $itemsRaw = $this->selectWith($select);
        $itemCollection = [];
        foreach ($itemsRaw as $item) {
            $itemCollection[] = new ItemEntity($item);
        }

        return $itemCollection;
    }

    public function getItemCount(): int
    {
        return $this->select()->count();
    }
}