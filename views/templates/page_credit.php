<?php include ROOT . '/views/templates/header.php'; ?>


<img class="col-12 col-sm-6" src="/../views/img/logo/<?php echo $img; ?>-full.jpg" alt="<?php echo $content['title'] ?>">
<?php
if (strpos($content["title"], "Кредит наличными") !== false)
    $offercode = 'cashCard';
else {
    $offercode = 'cardCredit';
}
?>
<button type="button" class="btn btn-warning btn-block mt-3 mb-3" data-toggle="modal" data-target="#finline" data-offercode="<?php echo $offercode; ?>">Онлайн заявка</button>
<?php foreach ($credit_data as $param_name => $param_data): ?>
    <div class="row p-2 border-bottom">
        <div class="col-12 col-sm-5">
            <strong><?php echo $param_name; ?></strong>
        </div>
        <div class="col-12 col-sm-5">
            <?php if ($param_name == 'Трудоустройство') : ?>
                <?php $params = explode(',', $param_data); ?>
                <ul>
                    <?php foreach ($params as $param): ?>
                        <li><?php echo $param ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <?php echo $param_data; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

<?php include ROOT . '/views/templates/footer.php'; ?>