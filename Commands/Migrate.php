<?php

namespace Commands;

use Console\Command;
use Fs\Helpers;

class Migrate
    extends Command
{
    
    const MIGRATIONS_NAMESPACE = 'Migrations';

    public function actionDefault()
    {
        $this->actionUp();
    }

    public function actionUp()
    {
        //
    }

    public function actionCreate($name, $namespace = [])
    {
        $className = "m_" . time() . "_" . $name;
        $namespace = $this->getMigrationsNamespace($namespace);
        
        $content = <<<FILE
<?php

namespace {$namespace};

use Orm\Migration;

class {$className}
    extends Migration
{

    public function up()
    {
    }

    public function down()
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