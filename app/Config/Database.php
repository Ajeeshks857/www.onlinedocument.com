<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;
    public string $defaultGroup = 'default';
    public $default = [];
    public array $tests = [];

    public function __construct()
    {
        parent::__construct();

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }

        $this->default = [
            'DSN'      => '',
            'hostname' => env('database.default.hostname', 'localhost'),
            'username' => env('database.default.username', 'root'),
            'password' => env('database.default.password', ''),
            'database' => env('database.default.database', 'document_managements_v1'),
            'DBDriver' => env('database.default.DBDriver', 'MySQLi'),
            'DBPrefix' => env('database.default.DBPrefix', ''),
            'pConnect' => false,
            'DBDebug'  => (ENVIRONMENT !== 'production'),
            'charset'  => 'utf8',
            'DBCollat' => 'utf8_general_ci',
            'swapPre'  => '',
            'encrypt'  => false,
            'compress' => false,
            'strictOn' => false,
            'failover' => [],
            'port'     => env('database.default.port', 3306),
        ];

        $this->tests = [
            'DSN'         => '',
            'hostname'    => env('database.tests.hostname', 'localhost'),
            'username'    => env('database.tests.username', 'root'),
            'password'    => env('database.tests.password', ''),
            'database'    => env('database.tests.database', 'document_managements_v1'),
            'DBDriver'    => env('database.tests.DBDriver', 'MySQLi'),
            'DBPrefix'    => env('database.tests.DBPrefix', ''),
            'pConnect'    => false,
            'DBDebug'     => true,
            'charset'     => env('database.tests.charset', 'utf8mb4'),
            'DBCollat'    => env('database.tests.DBCollat', 'utf8mb4_general_ci'),
            'swapPre'     => '',
            'encrypt'     => false,
            'compress'    => false,
            'strictOn'    => false,
            'failover'    => [],
            'port'        => env('database.tests.port', 3306),
            'foreignKeys' => true,
            'busyTimeout' => 1000,
            'dateFormat'  => [
                'date'     => 'Y-m-d',
                'datetime' => 'Y-m-d H:i:s',
                'time'     => 'H:i:s',
            ],
        ];
    }
}
