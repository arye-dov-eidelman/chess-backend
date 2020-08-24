<?php
class SQLStatement
{
    private $sql;
    private $data;
    private $types;
    private $statement;

    public function __construct(string $sql, ?string $types, ...$data)
    {
        $this->sql = $sql;
        $this->types = $types;
        $this->data = $data;
        $this->statement = DBConnection::$connection->prepare($this->sql);
    }

    public function execute()
    {
        DBConnection::connect();
        if (isset($this->types, $this->data)) {
            $this->statement->bind_param($this->types, ...$this->data);
        }
        $this->statement->execute();
        return $this->statement->get_result();
    }

    public function bind(string $types, ...$data)
    {
        $this->types = $types;
        $this->data = $data;
    }

    public function __destruct()
    {
        if (isset($this->statement)) {
            $this->statement->close();
        }
    }
}
