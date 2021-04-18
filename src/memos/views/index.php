<h1 class="h3">メモ一覧</h1>
<a class="btn btn-primary mt-3 mb-3" href="memo_new.php">メモを登録する</a>
<main>
    <?php if (count($memos) > 0) : ?>
        <?php $memos = array_reverse($memos); ?>
        <?php foreach ($memos as $memo) : ?>
            <section class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="card-title h4 text-dark mb-3">
                        <?php echo escape($memo['title']); ?>
                    </h2>
                    <p>
                        <?php echo nl2br(escape($memo['text']), false); ?>
                    </p>
                </div>
            </section>
        <?php endforeach; ?>
    <?php else : ?>
        <p>まだメモが登録されていません</p>
    <?php endif; ?>
</main>
