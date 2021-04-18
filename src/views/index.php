<h1 class="h3 mb-4">読書ログの一覧</h1>
<a href="new.php" class="btn btn-primary mb-4">読書ログを登録する</a>
<main>
    <?php if (count($reviews) > 0) : ?>
        <?php $reviews = array_reverse($reviews) ?>
        <?php foreach ($reviews as $review) : ?>
            <section class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2 class="card-title text-dark h4 mb-3">
                        「<?php echo escape($review['title']); ?>」
                    </h2>
                    <div class="small mb-3">
                        作者：<?php echo escape($review['author']); ?>&nbsp;/&nbsp;
                        読書状況：<?php echo escape($review['status']); ?>&nbsp;/&nbsp;
                        評価（5点満点）：<?php echo escape($review['score']); ?>点
                    </div>
                    <p>
                        <?php echo nl2br(escape($review['summary']), false); ?>
                    </p>
                </div>
            </section>
        <?php endforeach; ?>
    <?php else : ?>
        <p class="text-danger mt-3">「まだ読書ログが登録されていません。」</p>
    <?php endif; ?>
</main>
