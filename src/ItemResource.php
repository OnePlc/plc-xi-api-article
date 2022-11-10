<?php
namespace Item;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use stdClass;

class ItemResource extends AbstractResourceListener
{

    public function __construct(
        private readonly ItemTableGateway $itemTbl
    )
    {
    }

    public function create($data) : ApiProblem
    {
        return new ApiProblem(405, 'The POST method has not been defined');
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
        $items = $this->itemTbl->getAllItems();

        $itemList = [];
        foreach ($items as $item) {
            $itemList[] = $item->getApiObject();
        }

        return (object)[
            'items' => $itemList,
            'total_items' => $this->itemTbl->getItemCount()
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
