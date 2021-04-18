<?php

use GrahamCampbell\ResultType\Result;

require_once __DIR__ . '/lib/mysqli.php';

function createMemo($link, $memo)
{
    $sql = <<<EOT
    INSERT INTO memos (
        title,
        text
    ) VALUES (
        "{$memo['title']}",
        "{$memo['text']}"
    )
EOT;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        error_log('Error: fail to create memo');
        error_log('Debugging Error: ' . mysqli_error($link));
    }
}

function validate($memo)
{
    $errors = [];

    if (!mb_strlen($memo['title'])) {
        $errors['title'] = 'タイトルを入力してください';
    } elseif (mb_strlen($memo['title']) > 255) {
        $errors['title'] = 'タイトルは255文字以内で入力してください';
    }

    if (!mb_strlen($memo['text'])) {
        $errors['text'] = '本文を入力してください';
    } elseif (mb_strlen($memo['text']) > 10000) {
        $errors['text'] = '本文は10000文字以内で入力してください';
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memo = [
        'title' => $_POST['title'],
        'text' => $_POST['text']
    ];

    $errors = validate($memo);

    if (!count($errors)) {
        $link = dbConnect();
        createMemo($link, $memo);
        mysqli_close($link);
        header("Location: memo_index.php");
    }
}

$title = 'メモアプリの登録';
$content = __DIR__ . '/views/new.php';

include __DIR__ . '/views/layout.php';
