<?php
/**
 * Inicializar Banco de dados.
 *
 * @var \Phalcon\Db\AdapterInterface $connection
 */

use Phalcon\Exception;
use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Config\Adapter\Ini as IniConfig;
use Phalcon\Config;

try {

    $configFile = __DIR__ . '/../app/config/config_local.ini';
    if (!is_file($configFile)) {
        throw new Exception(
            sprintf('Não é possível ler o arquivo de configuração localizado em %s.', $configFile)
        );
    }

    $config = new IniConfig($configFile);

    /** @var \Phalcon\Config $config */
    $config = $config->get('database');

    if (!$config instanceof Config) {
        throw new Exception('Não é possível ler o banco de dados config.');
    }

    $dbClass = sprintf('\Phalcon\Db\Adapter\Pdo\%s', $config->get('adapter', 'MySql'));

    if (!class_exists($dbClass)) {
        throw new Exception(
            sprintf('PDO adapter "%s" Não encontrado.', $dbClass)
        );
    }

    $dbConfig = $config->toArray();
    unset($dbConfig['adapter']);

    $connection = new $dbClass($dbConfig);

    $connection->begin();

    $connection->createTable(
        'users',
        null,
        [
            'columns' => [
                new Column('id', [
                    'type'          => Column::TYPE_INTEGER,
                    'size'          => 10,
                    'unsigned'      => true,
                    'notNull'       => true,
                    'autoIncrement' => true
                ]),
                new Column('email', [
                    'type'      => Column::TYPE_VARCHAR,
                    'size'      => 80,
                    'notNull'   => true
                ]),
                new Column('name', [
                    'type'      => Column::TYPE_VARCHAR,
                    'size'      => 120,
                    'notNull'   => true
                ]),
                new Column('password', [
                    'type'      => Column::TYPE_CHAR,
                    'size'      => 40,
                    'notNull'   => true
                ]),
                new Column('created_at', [
                    'type'    => Column::TYPE_TIMESTAMP,
                    'notNull' => true,
                    'default' => 'CURRENT_TIMESTAMP'
                ]),
                new Column('active', [
                    'type'    => Column::TYPE_CHAR,
                    'size'    => 1,
                    'notNull' => true
                ]),
            ],
            'indexes' => [
                new Index('PRIMARY', ['id'], 'PRIMARY')
            ]
        ]
    );

    $connection->execute("INSERT INTO users VALUES (1, 'teste.phalcon@mailinator.com', 'Joao Teste', 'c0bd96dc7ea4ec56741a4e07f6ce98012814d853', '2016-05-22 21:31:05', 'Y')");

    $connection->commit();

} catch (\Exception $e) {
    if ($connection->IsUnderTransaction()){
        $connection->rollback();
    }

    echo $e->getMessage(), PHP_EOL;
    echo $e->getTraceAsString(), PHP_EOL;
}