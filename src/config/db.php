<?php
$file_name = __DIR__ . '/' . '_local.db.php';
$include_db_config = [];
if (file_exists($file_name)) {
    $include_db_config = include $file_name;
}

return array_replace_recursive([
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=postgres;port=5432;dbname=db_name',
    'username' => 'user_name',
    'password' => 'password',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
], $include_db_config);
