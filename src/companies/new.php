<?php

$company = [
    'name' => '',
    'establishment_date' => '',
    'founder' => ''
];
// $errorsを定義しておけばHTMLのエラーが起きない
$errors = [];

$title = '会社情報の登録';
$content = __DIR__ . '/views/new.php';
// 絶対パスに変更
include __DIR__ . '/views/layout.php';
