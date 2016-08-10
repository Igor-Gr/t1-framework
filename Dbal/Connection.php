<?php

namespace Dbal;

use Core\Config;
use Core\Exception;

class Connection
{

    /**
     * @var \Core\Config
     */
    protected $config;


    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * Connection constructor.
     * @throws Exception
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        try {
            $this->pdo = $this->getPdoObject($this->config);
        } catch (\PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param \Core\$config
     * @return \PDO
     */
    protected function getPdoObject(Config $config)
    {
        $dsn = $config->driver . ':host=' . $config->host . ';dbname=' . $config->dbname;
        $pdo = new \PDO($dsn, $config->user, $config->password);
        return $pdo;
    }

    /**
     * @return string
     */
    public function getDriverName()
    {
        return (string)$this->config->driver;
    }
    
    public function getDriver()
    {
        return DriverFactory::getDriver($this->getDriverName());
    }

    /**
     * @param string $query
     * @param array $params
     * @return bool
     */
    public function execute($query, array $params = [])
    {
        $sth = $this->pdo->prepare($query);
        $result = $sth->execute($params);
        return $result;
    }

    /**
     * @param string $query
     * @param string $class
     * @param array $params
     * @return array
     */
    public function queryClass($query, $class, array $params = [])
    {
        $sth = $this->pdo->prepare($query);
        $result = $sth->execute($params);
        if ($result !== false) {
            return $sth->fetchAll(\PDO::FETCH_CLASS, $class);
        }
        return [];
    }

    public function query($query, array $params = [])
    {
        $sth = $this->pdo->prepare($query);
        $result = $sth->execute($params);
        if ($result !== false) {
            return $sth->fetchAll();
        }
        return [];
    }
}