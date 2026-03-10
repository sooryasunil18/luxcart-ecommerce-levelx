<?php
require_once __DIR__ . '/../config/database.php';

class Database
{
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die("Database Connection Failed: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function query($sql, $params = [], $types = '')
    {
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("Query Prepare Failed: " . $this->conn->error);
        }
        if (!empty($params)) {
            if (empty($types)) {
                $types = str_repeat('s', count($params));
            }
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt;
    }

    public function fetchAll($sql, $params = [], $types = '')
    {
        $stmt = $this->query($sql, $params, $types);
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $stmt->close();
        return $rows;
    }

    public function fetch($sql, $params = [], $types = '')
    {
        $stmt = $this->query($sql, $params, $types);
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public function insert($sql, $params = [], $types = '')
    {
        $stmt = $this->query($sql, $params, $types);
        $id = $this->conn->insert_id;
        $stmt->close();
        return $id;
    }

    public function escape($value)
    {
        return $this->conn->real_escape_string($value);
    }
}
