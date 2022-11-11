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
        $indexColumns = $this->formService->getListColumnsByFormKey('article', false);

        $saveData = [];

        foreach ($indexColumns as $column) {
            if (property_exists($data, $column['field_key'])) {
                $key = $column['field_key'];
                $saveData[$column['field_key']] = $data->$key;
            }
        }

        $this->itemTbl->insert($saveData);

        return (object)[
            'id' => $this->itemTbl->lastInsertValue
        ];
    }

    public function delete($id) : ApiProblem
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    public function deleteList($data) : ApiProblem
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    public function fetch($id) : ApiProblem
    {
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
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

    public function update($id, $data) : ApiProblem
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
