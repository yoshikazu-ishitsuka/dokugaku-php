<?php

require_once __DIR__ . '/../memos/lib/mysqli.php';
require __DIR__ . '/../vendor/autoload.php';

function dropTable($link)
{
  $dropTableSql = 'DROP TABLE IF EXISTS memos;';
  $result = mysqli_query($link, $dropTableSql);
  if ($result) {
    echo 'テーブルを削除しました' . PHP_EOL;
  } else {
    echo "Error: テーブルの削除に失敗しました" . PHP_EOL;
    echo "Debugging Error: " . mysqli_error($link) . PHP_EOL;
  }
}

function createTable($link)
{
  $createTableSql = <<<EOT
    CREATE TABLE memos (
        id INTEGER AUTO_INCREMENT PRIMARY KEY NOT NULL,
        title VARCHAR(50),
        text VARCHAR(10000),
        created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) DEFAULT CHARACTER SET=utf8mb4;
EOT;

  $result = mysqli_query($link, $createTableSql);
  if ($result) {
    echo "テーブルを作成しました" . PHP_EOL;
  } else {
    echo "Error: テーブルの作成に失敗しました" . PHP_EOL;
    echo "Debugging Error: " . mysqli_error($link) . PHP_EOL;
  }
}

// DB接続
$link = dbConnect();
// table削除
dropTable($link);
// table作成
createTable($link);
// DB切断
mysqli_close($link);
