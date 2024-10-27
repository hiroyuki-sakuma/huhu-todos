<?php

namespace Backend\Models;

use Error;
use Exception;
use PDO;

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
            $sql = 'SELECT * FROM test_table ORDER BY created_at DESC';
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
            $sql = 'SELECT * FROM test_table WHERE id = :id';
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
            $sql = 'INSERT INTO test_table (todo) VALUES (:todo)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':todo', $data['todo'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('タスクの保存に失敗しました: ' . $e->getMessage());
        }
    }

    public function update(array $data, int $id)
    {
        try {
            $sql = 'UPDATE test_table SET todo = :todo, completed = :completed WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':todo', $data['todo'], PDO::PARAM_STR);
            $stmt->bindValue(':completed', $data['completed'], PDO::PARAM_BOOL);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Exception('タスクの上書きに失敗しました: ' . $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $sql = 'DELETE FROM test_table WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            throw new Error('タスクの削除に失敗しました: ' . $e->getMessage());
        }
    }
}
