<h3 class="h3 text-dark mb-4">メモアプリの登録</h3>
<form action="memo_create.php" method="post">
    <?php if (count($errors)) : ?>
        <ul class="text-danger">
            <?php foreach ($errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="form-group">
        <label for="title">題名</label>
        <input type="text" name="title" id="title" class="form-control" value="<?php echo $memo['title'] ?>">
    </div>
    <div class="form-group">
        <label for="text">本文</label>
        <textarea type="text" name="text" id="text" class="form-control" rows="10"><?php echo $memo['text'] ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">登録する</button>
</form>
