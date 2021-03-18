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
    } elseif (!in_array($review['score'], ["1", "2", "3", "4", "5"], true)) {
        $errors['score'] = '評価は1~5の数字で入力してください';
    }

    // // 評価の別パターン
    // if ($review['score'] < 1 || $review['score'] > 5) {
    //     $errors['score'] = '評価は1~5の整数で入力してください';
    // }

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
}

// もしエラーがあれば下記
include 'views/new.php';
