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

    public function getItem(int $itemId): ?ItemEntity
    {
        $select = new Select($this->getTable());
        $select->where(['id' => $itemId]);

        $itemRaw = $this->selectWith($select);
        if ($itemRaw->count() === 0) {
            return null;
        }

        $itemRaw = $itemRaw->current();

        return new ItemEntity($itemRaw);
    }

    public function getItemCount(): int
    {
        return $this->select()->count();
    }

    public function removeItem(int $itemId): bool
    {
        if ($itemId <= 0) {
            return false;
        }
        $this->delete(['id' => $itemId]);

        return true;
    }

    public function saveItem(int $itemId, array $itemData): bool
    {
        return $this->update($itemData, ['id' => $itemId]);
    }
}