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

function validate($company)
{
    $errors = [];

    // 会社名
    if (!strlen($company['name'])) {
        $errors['name'] = '会社名を入力してください';
    } elseif (strlen($company['name']) > 255) {
        $errors['name'] = '会社名は255文字以内で入力してください';
    }

    // 設立日
    // 2020-10-8 → 2020 10 8
    $dates = explode('-', $company['establishment_date']);
    // var_dump($company['establishment_date']); 形式をチェック
    if (!strlen($company['establishment_date'])) {
        $errors['establishment_date'] = '設立日を入力してください';
    } elseif (count($dates) !== 3) {
        $errors['establishment_date'] = '設立日を正しい形式で入力してください';
    } elseif (!checkdate($dates[1], $dates[2], $dates[0])) {
        $errors['establishment_date'] = '設立日を正しい日付で入力してください';
    }

    // 代表者
    if (!strlen($company['founder'])) {
        $errors['founder'] = '代表者名を入力してください';
    } elseif (strlen($company['founder']) > 100) {
        $errors['founder'] = '代表者名は100文字以内で入力してください';
    }

    return $errors;
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
    $errors = validate(($company));
    // バリデーションエラーがなければ下記処理
    if (!count($errors)) {
        // データベースに接続する
        $link = dbConnect();
        // データベースにデータを登録する
        createCompany($link, $company);
        // 登録が終わったらデータベースとの接続を切断する
        mysqli_close($link);
        // var_export(100);
        header("Location: index.php");
    }

    // もしエラーがあれば下記

}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会社情報の登録</title>
</head>

<body>
    <h1>会社情報の登録</h1>
    <form action="create.php" method="post">
        <?php if (count($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div>
            <label for="name">会社名</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="establishment_date">設立日</label>
            <input type="date" name="establishment_date" id="establishment_date">
        </div>
        <div>
            <label for="founder">代表者</label>
            <input type="text" name="founder" id="founder">
        </div>
        <button type="submit">登録する</button>
    </form>
</body>

</html>
