<?php

namespace Backend\Models;

use Error;
use Exception;
use PDO;
use DateTime;

class TodoModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find_all()
    {
        try {
            $sql = 'SELECT * FROM todos ORDER BY created_at DESC';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            throw new Exception('タスクの取得に失敗しました: ' . $e->getMessage());
        }
    }

    public function find_by_id(int $id)
    {
        try {
            $sql = 'SELECT * FROM todos WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            throw new Exception('タスクの取得に失敗しました: ' . $e->getMessage());
        }
    }

    public function save_db(array $data)
    {
        try {
            $sql = 'INSERT INTO todos (category_id, todo, created_by) VALUES (:category_id, :todo, :created_by)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':category_id', 1, PDO::PARAM_INT);
            $stmt->bindValue(':todo', $data['todo'], PDO::PARAM_STR);
            $stmt->bindValue(':created_by', 1, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('タスクの保存に失敗しました: ' . $e->getMessage());
        }
    }

    public function update(array $data, int $id)
    {
        try {
            $sql = 'UPDATE todos SET todo = :todo, completed = :completed, completed_at = :completed_at WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':todo', $data['todo'], PDO::PARAM_STR);
            $stmt->bindValue(':completed', $data['completed'], PDO::PARAM_BOOL);
            if ($data['completed_at']) {
                $date = new DateTime($data['completed_at']);
                $completed_at = $date->format('Y-m-d');
            }
            $stmt->bindValue(':completed_at', $completed_at, $completed_at ? PDO::PARAM_STR : PDO::PARAM_NULL);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('タスクの上書きに失敗しました: ' . $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $sql = 'DELETE FROM todos WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Error('タスクの削除に失敗しました: ' . $e->getMessage());
        }
    }
}
