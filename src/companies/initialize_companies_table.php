<?php

require __DIR__ . '/../vendor/autoload.php'; // __DIR__は現在のディレクトリを表す

function dbConnect()
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    // $dbHost = getenv('DB_HOST');
    $dbHost = $_ENV['DB_HOST'];
    $dbUsername = $_ENV['DB_USERNAME'];
    $dbPassword = $_ENV['DB_PASSWORD'];
    $dbDatabase = $_ENV['DB_DATABASE'];

    // var_dump($dbHost);
    // var_dump($dbUsername);
    // var_dump($dbPassword);
    // var_dump($dbDatabase);


    $link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbDatabase);

    if (!$link) {
        echo "Error: データベースに接続できません。：" . PHP_EOL;
        echo "Debugging Error： " . mysqli_connect_error() . PHP_EOL;
        exit;

        // echo "＊＊＊＊＊＊＊＊＊＊データベースに接続しました＊＊＊＊＊＊＊＊＊＊";
    }

    return $link;
}

function dropTable($link)
{
    $dropTableSql = 'DROP TABLE IF EXISTS companies;';
    $result = mysqli_query($link, $dropTableSql);
    if ($result) {
        echo '*******************テーブルを削除しました。*******************' . PHP_EOL;
    } else {
        echo "Error: テーブルの削除に失敗しました" . PHP_EOL;
        echo "Debugging Error: " . mysqli_error($link) . PHP_EOL . PHP_EOL;
    }
}

function createTable($link)
{
    $createTableSql = <<<EOT
    CREATE TABLE companies (
        id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255),
        establishment_date DATE,
        founder VARCHAR(255),
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) DEFAULT CHARACTER SET=utf8mb4;

EOT;
    $result = mysqli_query($link, $createTableSql);
    if ($result) {
        echo '*******************テーブルを作成しました。*******************' . PHP_EOL;
    } else {
        echo "Error: テーブルの作成に失敗しました" . PHP_EOL;
        echo "Debugging Error: " . mysqli_error($link) . PHP_EOL . PHP_EOL;
    }
}


$link = dbConnect();
dropTable($link);
createTable($link);
mysqli_close($link);
