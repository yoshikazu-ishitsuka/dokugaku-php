<?php

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

$link = dbConnect();
dropTable($link);
createTable($link);
mysqli_close($link);
