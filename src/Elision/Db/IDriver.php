<?php

namespace Elision\Db;


interface IDriver
{

    public function createTable(Connection $connection, $tableName, $columns = [], $indexes = [], $extensions = []);

    public function existsTable(Connection $connection, $tableName);
}