<?php
namespace Item;

use Application\Form\FormService;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use stdClass;

class ItemResource extends AbstractResourceListener
{

    public function __construct(
        private readonly ItemTableGateway $itemTbl,
        private readonly FormService $formService,
    )
    {
    }

    public function create($data) : ApiProblem|stdClass
    {
        $formFields = $this->formService->getFieldsByFormKey('article', true);

        $saveData = [];

        foreach ($formFields as $field) {
            if (property_exists($data, $field['field_key'])) {
                $key = $field['field_key'];
                $saveData[$field['field_key']] = $data->$key;
            }
        }

        $this->itemTbl->insert($saveData);

        return (object)[
            'id' => $this->itemTbl->lastInsertValue
        ];
    }

    public function delete($id) : ApiProblem|bool
    {
        $itemId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($itemId <= 0) {
            return new ApiProblem(400, 'invalid item id');
        }

        $item = $this->itemTbl->getItem($itemId);
        if ($item === null) {
            return new ApiProblem(404, 'invalid item id');
        }

        if ($this->itemTbl->removeItem($itemId)) {
            return true;
        }

        return new ApiProblem(400, 'could not delete item');
    }

    public function deleteList($data) : ApiProblem
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    public function fetch($id) : ApiProblem|stdClass
    {
        $itemId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        $formFields = $this->formService->getFieldsByFormKey('article', true);

        if ($itemId <= 0) {
            return (object)[
                'form' => [
                    'fields' => $formFields
                ],
                'item' => null
            ];
        }

        $item = $this->itemTbl->getItem($itemId);
        if ($item === null) {
            return new ApiProblem(404, 'invalid item id');
        }

        return (object)[
            'form' => [
                'fields' => $formFields
            ],
            'item' => $item->getApiObject($formFields)
        ];
    }

    public function fetchAll($params = []) : ApiProblem|stdClass
    {
        $indexColumns = $this->formService->getListColumnsByFormKey('article', true);

        $items = $this->itemTbl->getAllItems();
        $itemList = [];

        foreach ($items as $item) {
            $itemList[] = $item->getApiObject($indexColumns);
        }

        return (object)[
            'items' => $itemList,
            'total_items' => $this->itemTbl->getItemCount(),
            'list' => [
                'columns' => $indexColumns
            ]
        ];
    }

    public function patch($id, $data) : ApiProblem
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    public function patchList($data) : ApiProblem
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    public function replaceList($data) : ApiProblem
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    public function update($id, $data) : object
    {
        $itemId = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if ($itemId <= 0) {
            return new ApiProblem(400, 'invalid item id');
        }

        $item = $this->itemTbl->getItem($itemId);
        if ($item === null) {
            return new ApiProblem(404, 'invalid item id');
        }

        $formFields = $this->formService->getFieldsByFormKey('article', true);

        $saveData = [];

        foreach ($formFields as $field) {
            if (property_exists($data, $field['field_key'])) {
                $key = $field['field_key'];
                $saveData[$field['field_key']] = $data->$key;
            }
        }

        $this->itemTbl->saveItem($itemId, $saveData);

        return (object)[
            'item' => $item->getApiObject($formFields)
        ];
    }
}
