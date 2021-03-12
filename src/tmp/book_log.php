<?php

function validate($review)
{
    $errors = [];

    // 書籍名が正しく入力されているかチェック
    if (!mb_strlen($review['title'])) {
        $errors['title'] = '書籍名を入力してください';
    } elseif (mb_strlen($review['title']) > 255) {
        $errors['title'] = '************書籍名は255文字以内で入力してください************';
    }

    // 著者名が正しく入力されているかチェック
    if (!mb_strlen($review['author'])) {
        $errors['author'] = '著者名を入力してください';
    } elseif (mb_strlen($review['author']) > 100) {
        $errors['author'] = '************著者名は100文字以内で入力してください************';
    }

    // 読書状況が正しく入力されているかチェック
    // $aryStatus = array("未読", "読んでる", "読了");
    if (!in_array($review['status'], ["未読", "読んでる", "読了"], true)) {
        $errors['status'] = '************読書状況は「未読」「読んでる」「読了」のいずれかを入力してください************';
    }

    // 評価が正しく入力されているかチェック
    if ($review['score'] < 1 || $review['score'] > 5) {
        $errors['score'] = '************評価は1〜5の整数を入力してください************';
    }
    // $errors['score'] = '整数で入力してください';

    // 感想が正しく入力されているかチェック
    if (!mb_strlen($review['summary'])) {
        $errors['summary'] = '感想を入力してください';
    } elseif (mb_strlen($review['summary']) > 1000) {
        $errors['summary'] = '感想は1,000文字以内で入力してください';
    }


    return $errors;
}

function dbConnect()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');
    if (!$link) {
        echo 'Error: データベースに接続できません' . PHP_EOL;
        echo 'Debugging Error: ' . mysqli_connect_error() . PHP_EOL;
        exit;
    }

    // echo '-------------------データベースと接続しました-------------------' . PHP_EOL;

    return $link;
}


function createReview($link) //$linkを使うから引数に指定
{
    $review = [];

    // 読書ログを登録する
    echo '読書ログを登録してください。' . PHP_EOL;
    echo '書籍名：';
    // $title = str_replace(array(" ", "　"), "", fgets(STDIN));
    $review['title'] = trim(fgets(STDIN));

    echo '著者名：';
    $review['author'] = trim(fgets(STDIN));

    echo '読書状況（未読,読んでる,読了）：';
    $review['status'] = trim(fgets(STDIN));

    echo '評価（5点満点の整数）：';
    $review['score'] = (int) trim(fgets(STDIN));

    echo '感想：';
    $review['summary'] = trim(fgets(STDIN));

    $validated = validate($review);
    if (count($validated) > 0) {
        foreach ($validated as $error) {
            echo $error . PHP_EOL;
        }
        return;
    }

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

    $result = mysqli_query($link, $sql);  // $sqlを実行するためにmysqli_query内に記述、$linkはtureがfalseの判定
    if ($result) {
        echo '*******************登録が完了しました。*******************' . PHP_EOL . PHP_EOL;
        // echo 'データを追加しました' . PHP_EOL;
    } else {
        echo 'Error: データの追加に失敗しました' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_error($link) . PHP_EOL . PHP_EOL;
    }


    // return [
    //     'title' => $title,
    //     'author' => $author,
    //     'status' => $status,
    //     'score' => $score,
    //     'summary' => $summary,
    // ];
}

function showReviews($link)
{
    // 読書ログを表示する
    echo '*******登録されている読書ログを表示します。*******' . PHP_EOL;

    // $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

    $sql = <<<EOT
    select
        id,
        title,
        author,
        status,
        score,
        summary
    from
        reviews;
    EOT;

    $results = mysqli_query($link, $sql);

    while ($review = mysqli_fetch_assoc($results)) {
        echo '書籍名：' . $review["title"] . PHP_EOL;
        echo '著者名：' . $review["author"] . PHP_EOL;
        echo '読書状況：' . $review["status"] . PHP_EOL;
        echo '評価：' . $review["score"] . PHP_EOL;
        echo '感想：' . $review["summary"] . PHP_EOL;
        echo "-------------------" . PHP_EOL;
        // var_export($review);
    }

    mysqli_free_result($results);
    // foreach ($reviews as $review) {
    //     // echo $review . PHP_EOL;
    //     echo '書籍名：' . $review["title"] . PHP_EOL;
    //     echo '著者名：' . $review["author"] . PHP_EOL;
    //     echo '読書状況：' . $review["status"] . PHP_EOL;
    //     echo '評価：' . $review["score"] . PHP_EOL;
    //     echo '感想：' . $review["summary"] . PHP_EOL;
    //     echo "-------------------" . PHP_EOL;
    // };
}

// $reviews = [];
$link = dbConnect(); //dbConenectのままじゃ使いづらいから$linkに入れてる

while (true) {
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください（1,2,9）：';
    $num = trim(fgets(STDIN));

    if ($num === '1') {
        // $reviews[] = createReview();
        createReview($link);  //ここで$linkを与える（このあとの関数で使えるように）
    } elseif ($num === '2') {
        showReviews($link);
    } elseif ($num === '9') {
        // アプリケーションを終了する
        mysqli_close($link);
        // echo '-------------------データベースとの接続を切断しました-------------------' . PHP_EOL;
        echo '************************* 読書ログを終了します。 ************************' . PHP_EOL;
        break;
    }
}

// var_export($reviews);


// // echo "書籍名：{$title}" . PHP_EOL;



// // echo '書籍名：銀河鉄道の夜' . PHP_EOL;
// // echo '著者名：宮沢賢治' . PHP_EOL;
// // echo '読書状況：読了' . PHP_EOL;
// // echo '評価：5' . PHP_EOL;
// // echo '感想：ほんとうの幸せとは何だろうかと考えさせられる作品だった。' . PHP_EOL;
