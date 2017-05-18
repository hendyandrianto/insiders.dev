<div id="credit_module">
    <h4>Популярные кредиты</h4>
    <?php foreach ($list as $item): ?>
        <div class="row pt-3 pb-3 border-bottom">
            <div class="col-12 col-lg-7">
                <a href="<?php echo '/kredity/' . $item["category"] . '/' . $item["slug"]; ?>"><img src="/views/img/logo/<?php echo $item["table_data"]["Банк"]; ?>-50.jpg" width="25px" alt="<?php echo $item["title"]; ?>"></a>
                <a href="<?php echo '/kredity/' . $item["category"] . '/' . $item["slug"]; ?>"><?php echo $item["title"]; ?></a>
            </div>
            <?php
            if (strpos($item["title"], "Кредит наличными") !== false)
                $offercode = 'cashCard';
            else {
                $offercode = 'cardCredit';
            }
            ?>
            <div class="col-12 col-lg-5">
                <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#finline" data-offercode="<?php echo $offercode; ?>">
                    Онлайн заявка
                </button>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="text-right">
        <a href="/kredity/kredit-nalichnymi">Все кредиты >></a>
        <br>
        <a href="/kredity/kreditnie-karty">Все кредитные карты >></a>
    </div>
</div>