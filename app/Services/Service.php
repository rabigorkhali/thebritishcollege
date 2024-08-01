<?php

namespace App\Services;


class Service
{
    /**
     * Stores the model used for service.
     * @var Eloquent object
     */
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    // get all data

    public function getAllData($data, $selectedColumns = [], $pagination = true)
    {
        $query = $this->query();
        if (count($selectedColumns) > 0) {
            $query->select($selectedColumns);
        }
        if ($pagination) {
            return $query->orderBy('created_at', 'DESC')->paginate(5);
        } else {
            return $query->orderBy('created_at', 'DESC')->get();
        }
    }

    // find model by its identifier

    public function find($id)
    {
        return $this->model->find($id);
    }

    //store single record

    public function store($request)
    {
        return $this->model->create($request->except('_token'));
    }

    //update record

    public function update($request, $id)
    {
        $data = $request->except('_token');
        $update = $this->itemByIdentifier($id);
        $update->fill($data)->save();
        $update = $this->itemByIdentifier($id);
        return $update;
    }

    //delete a record

    public function delete($request, $id)
    {
        $item = $this->itemByIdentifier($id);
        return $item->delete();
    }

    //Get intem by its identifier

    public function itemByIdentifier($id)
    {
        return $this->model->find($id);
    }

    // Data for index page

    public function indexPageData($request)
    {
        return [
            'items' => $this->getAllData($request),
        ];
    }

    // Data for create page

    public function createPageData($request)
    {
        return [];
    }

    public function editPageData($request, $id)
    {
        return [
            'item' => $this->itemByIdentifier($id)
        ];
    }


    public function query()
    {
        return $this->model->query();
    }
}
