<?php

namespace Backend\Controllers;

use Backend\Models\TodoModel;
use PDO;

class TodoController
{
    private $todoModel;

    public function __construct(PDO $pdo)
    {
        $this->todoModel = new TodoModel($pdo);
    }

    public function get_test_all()
    {
        try {
            $todos = $this->todoModel->find_all();
            return $todos;
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function get_by_id($id)
    {
        try {
            $todo = $this->todoModel->find_by_id($id);
            return ['status' => 'success', 'data' => $todo];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
