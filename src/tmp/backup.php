<?php

function createReview()
{
    // 読書ログを登録する
    echo '読書ログを登録してください。' . PHP_EOL;
    echo '書籍名：';
    // $title = str_replace(array(" ", "　"), "", fgets(STDIN));
    $title = trim(fgets(STDIN));

    echo '著者名：';
    $author = trim(fgets(STDIN));

    echo '読書状況（未読,読んでる,読了）：';
    $status = trim(fgets(STDIN));

    echo '評価（5点満点の整数）：';
    $score = trim(fgets(STDIN));

    echo '感想：';
    $summary = trim(fgets(STDIN));

    echo '*******登録が完了しました。*******' . PHP_EOL . PHP_EOL;

    return [
        'title' => $title,
        'author' => $author,
        'status' => $status,
        'score' => $score,
        'summary' => $summary,
    ];
}

function showReview()
{
}

// $title = '';
// $author = '';
// $readingStatus = '';
// $evaluation = '';
// $impressions = '';
// $i = 0;

$reviews = [];

while (true) {
    echo '1. 読書ログを登録' . PHP_EOL;
    echo '2. 読書ログを表示' . PHP_EOL;
    echo '9. アプリケーションを終了' . PHP_EOL;
    echo '番号を選択してください（1,2,9）：';
    $num = trim(fgets(STDIN));

    if ($num === '1') {
        $reviews[] = createReview();
    } elseif ($num === '2') {
        showReview();

        // 読書ログを表示する
        echo '*******登録されている読書ログを表示します。*******' . PHP_EOL;
        foreach ($reviews as $review) {
            // echo $review . PHP_EOL;
            echo '書籍名：' . $review["title"] . PHP_EOL;
            echo '著者名：' . $review["author"] . PHP_EOL;
            echo '読書状況：' . $review["status"] . PHP_EOL;
            echo '評価：' . $review["score"] . PHP_EOL;
            echo '感想：' . $review["summary"] . PHP_EOL;
            echo "-------------------" . PHP_EOL;
        }
    } elseif ($num === '9') {
        // アプリケーションを終了する
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
