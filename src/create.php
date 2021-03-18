<?php

require_once __DIR__ . '/lib/mysqli.php';

function createReview($link, $review)
{
    $sql = <<<EOT
    INSERT INTO reviews (
        title,
        author,
        status,
        score,
        summary
    ) VALUES (
        "{$review['title']}",
        "{$review['author']}",
        "{$review['status']}",
        "{$review['score']}",
        "{$review['summary']}"
    )
EOT;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        // $sqlを実行するためにmysqli_query内に記述、$linkはtureかfalseの判定
        error_log('Error: fail to create review');
        error_log('Debugging Error: ' . mysqli_error(($link)));
    }
}

function validate($review)
{
    $errors = [];

    // 書籍名
    if (!strlen($review['title'])) {
        $errors['title'] = '書籍名を入力してください';
    } elseif (strlen($review['title']) > 255) {
        $errors['title'] = '書籍名は255文字以内で入力してください';
    }

    // 著者名
    if (!strlen($review['author'])) {
        $errors['author'] = '著者名を入力してください';
    } elseif (strlen($review['author']) > 255) {
        $errors['author'] = '著者名は255文字以内で入力してください';
    }

    // 読書状況
    // if (!strlen($review['status'])) {
    //     $errors['status'] = '読書状況を入力してください';
    if (!in_array($review['status'], ["未読", "読んでる", "読了"], true)) {
        $errors['status'] = '読書状況は「未読」「読んでる」「読了」のいずれかを入力してください';
    }

    // 評価
    if (!strlen($review['score'])) {
        $errors['score'] = '評価を入力してください';
    } elseif (!in_array($review['score'], [1, 2, 3, 4, 5], true)) {
        $errors['score'] = '評価は1~5の数字で入力してください';
    }

    // 感想
    if (!strlen($review['summary'])) {
        $errors['summary'] = '感想を入力してください';
    } elseif (strlen($review['summary']) > 1000) {
        $errors['summary'] = '感想は1000文字以内で入力してください';
    }

    return $errors;
}

// HTTPメソッドがPOSTだったら
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // $_POST['status]は未入力だとラジオボタンがチェックされていないためエラーになるので対策の処理
    // (ラジオボタンに初めからチェックを入れておくでもOK)
    $status = '';
    if (array_key_exists('status', $_POST)) {
        $status = $_POST['status'];
    }

    // POSTされた読書情報を変数に格納する
    $review = [
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        // 'status' => $_POST['status'],
        'status' => $status,
        'score' => $_POST['score'],
        'summary' => $_POST['summary']
    ];

    // バリデーションする
    $errors = validate($review);
    // バリデーションエラーがなければ下記を実行
    if (!count($errors)) {
        // DBに接続する
        $link = dbConnect();

        // DBにデータを登録する
        createReview($link, $review);

        // 登録が終わったらDBとの接続を切断する
        mysqli_close($link);

        // リダイレクトする
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
    <title>読書ログの登録</title>
</head>

<body>
    <h1>読書ログ</h1>
    <form action="create.php" method="post">
        <?php if (count($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <h3>読書ログの登録</h3>
        <div>
            <label for="title">書籍名</label>
            <input type="text" name="title" id="title">
        </div>
        <div>
            <label for="author">著者名</label>
            <input type="text" name="author" id="author">
        </div>
        <div>
            <label>読書状況</label>
            <div>
                <div>
                    <input type="radio" name="status" id="status1" value="未読">
                    <label for="status1">未読</label>
                </div>
                <div>
                    <input type="radio" name="status" id="status2" value="読んでる">
                    <label for="status2">読んでる</label>
                </div>
                <div>
                    <input class="form-check-input" type="radio" name="status" id="status3" value="読了">
                    <label for="status3">読了</label>
                </div>
            </div>
        </div>
        <div>
            <label for="score">評価(5点満点の整数)</label>
            <input type="number" name="score" id="score">
        </div>
        <div>
            <label for="summary">感想</label>
            <textarea type="text" name="summary" id="summary" rows="10"></textarea>
        </div>
        <button type="submit">登録する</button>
    </form>
</body>

</html>
