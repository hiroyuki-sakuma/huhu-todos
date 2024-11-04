<?php

namespace Backend\Controllers;

use Backend\Models\TodoModel;
use PDO;

class TodoController
{
    private $todo_model;

    public function __construct(PDO $pdo)
    {
        $this->todo_model = new TodoModel($pdo);
    }

    public function index()
    {
        return $this->todo_model->find_all();
    }

    public function get_by_id(int $id)
    {
        return $this->todo_model->find_by_id($id);
    }

    public function store(array $data)
    {
        $this->todo_model->save_db($data);
    }

    public function update(array $data, int $id)
    {
        $this->todo_model->update($data, $id);
    }

    public function delete(int $id)
    {
        $this->todo_model->delete($id);
    }
}
