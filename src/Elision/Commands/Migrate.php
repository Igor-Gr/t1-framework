<?php

namespace Elision\Commands;

use Elision\Console\Command;
use Elision\Core\Exception;
use Elision\Fs\Helpers;

class Migrate
    extends Command
{

    const TABLE_NAME = '__migrations';
    const MIGRATIONS_NAMESPACE = 'Migrations';

    public function actionDefault()
    {
        $this->actionUp();
    }

    public function actionUp()
    {
        try {
            if (!$this->isInstalled()) {
                $this->install();
            }
        } catch (\PDOException $e) {
            throw  new Exception($e->getMessage());
        }
    }

    protected function isInstalled()
    {
        $connection = \Elision\Orm\Model::getDbConnection();
        $driver = $connection->getDriver();
        return $driver->existsTable($connection, self::TABLE_NAME);
    }

    protected function install()
    {
        $connection = \Elision\Orm\Model::getDbConnection();
        $driver = $connection->getDriver();
        $driver->createTable($connection, self::TABLE_NAME,
            [
                '__id' => ['type' => 'serial'],
                'time' => ['type' => 'int']
            ],
            [

            ]
        );
        $this->writeLn('Migration table `' . self::TABLE_NAME . '` is created`');
    }

    public function actionCreate($name, $namespace = [])
    {
        $className = "m_" . time() . "_" . $name;
        $namespace = $this->getMigrationsNamespace($namespace);
        
        $content = <<<FILE
<?php

namespace {$namespace};

use Elision\Orm\Migration;

class {$className}
    extends Migration
{

    web function up()
    {
    }

    web function down()
    {
    }
    
}
FILE;
        $filename = 'Migrations//' . $className . '.php';

        if (!is_readable(dirname($filename))) {
            Helpers::makeDir(dirname($filename));
        }
        file_put_contents($filename, $content);

        $this->writeLn('Migration ' . $className . ' is created in ' . $filename);
    }

    protected function getMigrationsNamespace($namespace = null)
    {
        if ($namespace == null) {
            return self::MIGRATIONS_NAMESPACE;
        } else {
            return ucfirst($namespace);
        }
    }
}