<?php include ROOT . '/views/templates/header.php'; ?>

<div id="calc">
    <p>
        <label for="amount">Сумма кредита:</label>
        <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold; background: #eaf4fb">
    </p>
    <div id="slider-range"></div>
</div>
<div id="credits">
    <?php foreach ($list as $item): ?>
        <div summ="<?php echo $item["table_data"]["Сумма кредита"]; ?>" class="row pt-3 pb-3 border-bottom">
            <div class="col-12 col-md-5">
                <a href="<?php echo $item["category"] . '/' . $item["slug"]; ?>"><img src="../views/img/logo/<?php echo $item["table_data"]["Банк"]; ?>-50.jpg" alt="<?php echo $item["title"]; ?>"></a>
                <a href="<?php echo $item["category"] . '/' . $item["slug"]; ?>"><strong><?php echo $item["title"]; ?></strong></a>
            </div>
            <div class="col-12 col-md-3 text-center">
                <span>до <strong><?php echo number_format($item["table_data"]["Сумма кредита"], 0, '.', ' '); ?></strong> грн.</span>
            </div>
            <?php
            if (strpos($item["title"], "Кредит наличными") !== false)
                $offercode = 'cashCard';
            else {
                $offercode = 'cardCredit';
            }
            ?>
            <div class="col-12 col-md-4">
                <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#finline" data-offercode="<?php echo $offercode; ?>">
                    Онлайн заявка
                </button>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div class="credit-content mt-5">
    <?php echo $content['text']; ?>
</div>

<?php include ROOT . '/views/templates/footer.php'; ?>