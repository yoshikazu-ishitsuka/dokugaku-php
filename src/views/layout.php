<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/css/app.css">
    <link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
    <title><?php echo $title; ?></title>
</head>

<body>
    <header class="navbar shadow-sm p-3 mb-5 bg-white">
        <h1 class="h2">
            <a class="text-body text-decoration-none" href="index.php"><img class="mr-1" src="/public/book.jpg" width="100px" alt="image">【読書ログ】</a>
        </h1>
    </header>

    <div class="container">
        <?php include $content; ?>
    </div>

    <hr>
    <footer class="ml-3">
        <p class="text-center">
            読書ログ
        </p>
    </footer>
</body>
