<?php

/// MySQLとの接続関数
function dbConnect()
{
    $link = mysqli_connect('db', 'book_log', 'pass', 'book_log');

    if (!$link) {
        echo "Error: データベースに接続できません。：" . PHP_EOL;
        echo "Debugging Error： " . mysqli_connect_error() . PHP_EOL;
        exit;

        echo "＊＊＊＊＊＊＊＊＊＊データベースに接続しました＊＊＊＊＊＊＊＊＊＊";
    }

    return $link;
}


/// メモの登録関数
function createMemo($link)
{
    $memo = [];

    echo "＊＊＊＊＊＊＊＊[1]が選択されました。メモを作成します。＊＊＊＊＊＊＊＊" . PHP_EOL;

    echo "タイトル：";
    $memo['title'] = fgets(STDIN);

    // echo "日付：";
    // $date = fgets(STDIN);

    echo "本文：";
    $memo['text'] = fgets(STDIN);

    // echo "＊＊＊＊＊＊＊メモの登録が完了しました。＊＊＊＊＊＊＊＊" . PHP_EOL . PHP_EOL;

    $sql = <<<EOT
    INSERT INTO memos (
        title,
        text
    ) VALUES (
        "{$memo['title']}",
        "{$memo['text']}"
    )
    EOT;
    // created_at
    // "{$memo['created_at']}"

    $result = mysqli_query($link, $sql);

    if ($result) {
        echo '*******************登録が完了しました。*******************' . PHP_EOL . PHP_EOL;
    } else {
        echo "Error: データの追加に失敗しました" . PHP_EOL;
        echo "Debugging Error: " . mysqli_error($link) . PHP_EOL . PHP_EOL;
    }

    // この下は変数の時は使用するMySQLの時は不要
    // return [   // returnが無いと「Trying to access array offset on value of type null」エラーになる
    //     'title' => $title,
    //     'date' => $date,
    //     'text' => $text,
    // ];
}

/// メモの表示関数
function showMemo($link)
{
    echo "＊＊＊＊＊＊＊＊[2]が選択されました。メモを表示します。＊＊＊＊＊＊＊＊" . PHP_EOL . PHP_EOL;

    $sql = <<<EOT
    SELECT
        title,
        text,
        created_at
    FROM
        memos;
    EOT;

    $result = mysqli_query($link, $sql);

    while ($memo = mysqli_fetch_assoc($result)) {
        echo 'タイトル：' . $memo["title"];
        echo '本文：' . $memo['text'];
        echo '作成日時：' . $memo['created_at'] . PHP_EOL;
        echo "-------------------" . PHP_EOL;
    }

    mysqli_free_result($result);

    /// この下は変数の時
    // foreach ($memoLists as $memoList) {
    //     echo "タイトル：" . $memoList["title"];
    //     echo "日付：" . $memoList["date"];
    //     echo "本文：" . $memoList["text"] . PHP_EOL;
    //     echo "----------------------" . PHP_EOL;
    // };
}

/// メモ格納配列の定義
// $memoLists = [];
$link = dbConnect();

/// 実行コード
while (true) {
    echo "ご希望のサービスを選択してください。" . PHP_EOL;
    echo "1:メモを作成する / 2:メモを表示する / 9:アプリケーションを終了する" . PHP_EOL;
    echo "番号を選択してください。(1, 2, 9) => :";
    $num = trim(fgets(STDIN));
    echo "\n";

    if ($num === "1") {
        // $memoLists[] = createMemo();
        createMemo($link);
    } elseif ($num === "2") {
        showMemo($link);
    } elseif ($num === "9") {
        echo "＊＊＊＊＊＊＊＊＊＊＊[9]が選択されました。アプリケーションを終了します。＊＊＊＊＊＊＊＊＊＊" . PHP_EOL;
        break;
    }
}
// $memoLists["title"] = str_replace(PHP_EOL, '', $memoLists["title"]);
// var_export($memoLists);
// var_dump($memoLists);
