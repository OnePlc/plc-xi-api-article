<?php
namespace Item;

use ArrayObject;

class ItemEntity
{
    private int $id;
    private array $dynamicAttributes;

    public function __construct(
        private readonly ArrayObject $dbData
    )
    {
        $this->id = $this->dbData->id;

        foreach ($this->dbData as $key => $val) {
            if ($key == 'id') continue;

            $this->dynamicAttributes[$key] = $val;
        }
    }

    public function getApiObject() : array
    {
        $apiObject = [
            'id' => $this->id
        ];

        foreach ($this->dynamicAttributes as $key => $val) {
            $apiObject[$key] = $val;
        }

        return $apiObject;
    }
}
