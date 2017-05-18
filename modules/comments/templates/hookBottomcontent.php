<div class="mt-3 mb-3" id="module_comments_form">
    <div id="answer"></div>
    <h4>Добавить комментарий</h4>
    <form method="post" action="module-form/comments" answer="comments">
        <div class="form-group">
            <label for="comment_name">Ваше имя</label>
            <input type="text" class="form-control" id="comment_name" name="comment_name" placeholder="Ваше имя" required>    
        </div>
        <div class="form-group">
            <label for="comment_text">Комментарий</label>
            <textarea class="form-control" id="comment_text" name="comment_text" rows="3" required></textarea>
        </div>
        <input type="hidden" name="id_parent" id="id_parent" value="0">
        <input type="hidden" name="content_slug" value="<?php echo $params['slug'] ?>">
        <input type="hidden" name="content_table" value="<?php echo $params['table'] ?>">
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</div>

<?php if ($comments && !empty($comments)): ?>
    <h4>Комментарии</h4>
    <?php foreach ($comments as $comment): ?>
        <div class="row mt-3 mb-3 p-2 comments">        
            <div class="col-12 mb-3">
                <strong><?php echo $comment['name'] ?></strong>, <em><?php echo $comment['date_add'] ?></em>
            </div>
            <div class="col-12">
                <?php echo $comment['comment'] ?>
            </div>
            <div class="col-12 text-right">
                <a href="#module_comments_form" class="comment_answer" id-comment="<?php echo $comment['id'] ?>">Ответить</a>
            </div>
        </div>
        <?php if (isset($comment['anwers']) && !empty($comment['anwers'])): ?>
            <?php foreach ($comment['anwers'] as $anwers): ?>
                <div class="row offset-2 mt-3 mb-3 p-2 comments answers">
                    <div class="col-12 mb-3">
                        <strong><?php echo $anwers['name'] ?></strong>, <em><?php echo $anwers['date_add'] ?></em>
                    </div>
                    <div class="col-12">
                        <?php echo $anwers['comment'] ?>
                    </div>
                    <div class="col-12 text-right">
                <a href="#module_comments_form" class="comment_answer" id-comment="<?php echo $comment['id'] ?>">Ответить</a>
            </div>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
    <?php endforeach; ?>
    <?php //var_dump($comments) ?>
<?php endif ?>