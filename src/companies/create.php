<?php

require_once __DIR__ . '/lib/mysqli.php';

function createCompany($link, $company)
{
    $sql = <<<EOT
    INSERT INTO companies (
        name,
        establishment_date,
        founder
    ) VALUES (
        "{$company['name']}",
        "{$company['establishment_date']}",
        "{$company['founder']}"
    )
EOT;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        error_log('Error: fail to create company');
        error_log('Debugging Error: ' . mysqli_error($link));
        // echo '登録が完了しました' . PHP_EOL;
        // } else {
        //     echo 'Error: データの追加に失敗しました' . PHP_EOL;
        //     echo 'Debugging Error:' . mysqli_error($link) . PHP_EOL;
    }
}

// HTTPメソッドがPOSTだったら
// var_dump($_SERVER['REQUEST_METHOD'] === 'POST');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTされた会社情報を変数に格納する
    // var_export($_POST);
    $company = [
        'name' => $_POST['name'],
        'establishment_date' => $_POST['establishment_date'],
        'founder' => $_POST['founder']
    ];
    // var_export($company);
    // バリデーションする
    // データベースに接続する
    $link = dbConnect();
    // データベースにデータを登録する
    createCompany($link, $company);
    // 登録が終わったらデータベースとの接続を切断する
    mysqli_close($link);
    // var_export(100);
}

header("Location: index.php");
