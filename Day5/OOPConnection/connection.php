<?php
class DB
{
    protected  $dbType;
    protected  $dbName;
    protected  $host;
    protected  $userName;
    protected  $password;
    protected  $connection;

    function __construct($dbType, $dbName, $host, $password, $userName)
    {
        $this->dbName = $dbName;
        $this->dbType = $dbType;
        $this->host = $host;
        $this->password = $password;
        $this->userName = $userName;
        $this->connection = new PDO("$this->dbType:host=$this->host;dbname=$this->dbName", $this->userName, $this->password);
    }

    function index($table)
    {
        try {
            $query = "select * from $table";
            $sqlQuery = $this->connection->prepare($query);
            $sqlQuery->execute();
            $result = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            } else {
                echo "Empty Data";
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function show($table, $id)
    {
        try {
            $query = "select * from $table where id=:id";
            $sqlQuery = $this->connection->prepare($query);
            $sqlQuery->execute([
                ':id' => $id
            ]);
            $result = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            } else {
                echo "Empty Data";
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function delete($table, $id)
    {
        try {
            $query = "delete from $table where id=:id";
            $sqlQuery = $this->connection->prepare($query);
            $result = $sqlQuery->execute([
                ':id' => $id
            ]);

            if ($result) {
                return "deleted successfully";
            } else {
                echo "check your data";
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function create($table, $data)
    {
        try {
            $dataKeys = array_keys($data);
            $columns = implode(',', $dataKeys);
            $placeholders = ':' . implode(',:', $dataKeys);

            $query = "insert into $table ($columns) values($placeholders)";
            $sqlQuery = $this->connection->prepare($query);
            $result = $sqlQuery->execute(
                array_combine(
                    array_map(fn($key) => ":$key", $dataKeys),
                    array_values($data)
                )
            );

            if ($result) {
                return "created successfully";
            }
            echo "check your data";
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    function update($table, $data)
    {
        try {
            $id = $data['id'] ?? null;
            if (!$id) {
                echo "missing id";
                return;
            }

            $dataToUpdate = $data;
            unset($dataToUpdate['id']);

            $setParts = [];
            foreach ($dataToUpdate as $key => $_value) {
                $setParts[] = "$key=:$key";
            }

            $setClause = implode(', ', $setParts);
            $query = "update $table set $setClause where id=:id";

            $sqlQuery = $this->connection->prepare($query);
            $params = array_combine(
                array_map(fn($key) => ":$key", array_keys($dataToUpdate)),
                array_values($dataToUpdate)
            );
            $params[':id'] = $id;

            $result = $sqlQuery->execute($params);
            if ($result) {
                return "updated successfully";
            }
            echo "check your data";
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}

$database = new DB(dbType: "mysql", userName: "root", password: "", dbName: "iti_os_46_2026", host: "localhost");
