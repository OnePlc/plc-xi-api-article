<?php
namespace Item;

use Application\List\FormListTypeEnum;
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

    public function getApiObject(array $filters = []) : array
    {
        $apiObject = [
            'id' => $this->id
        ];

        foreach($filters as $filter) {
            if (array_key_exists($filter['field_key'], $this->dynamicAttributes)) {
                $apiObject[$filter['field_key']] = match($filter['field_type']) {
                    FormListTypeEnum::CURRENCY->value => [
                        'prefix' => 'CHF ',
                        'appendix' => '',
                        'value' => number_format(
                                $this->dynamicAttributes[$filter['field_key']]
                                , 2
                                , '.'
                                , '\''
                            )
                    ],
                    default => [
                        'value' => $this->dynamicAttributes[$filter['field_key']]
                    ]
                };
            }
        }

        return $apiObject;
    }
}
