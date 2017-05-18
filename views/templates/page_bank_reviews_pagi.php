<?php foreach ($list as $review): ?>
    <?php $bank_data = Bank::getBankData($review['bank']) ?>
    <div class="row pt-3 pb-3 border-bottom">
        <div class="col-12 mb-1">
            <h3>
                <a href="<?php echo $review["category"] . '/' . $review['slug'] ?>">
                    <strong> <?php echo $review['title'] ?></strong>
                </a>
            </h3>
        </div>
        <div class="col-4">
            <em><?php echo $review['name'] ?></em>,
            <?php echo date('d.m.Y', strtotime($review['date_add'])) ?>
        </div>
        <div class="col-4 text-center">
            <a href="/banki/banki-ukrainy/<?php echo $bank_data['slug'] ?>">
                <strong><?php echo $bank_data['title'] ?></strong>
            </a>
        </div>
        <div class="col-4 text-right">  
            <div itemscope="" itemtype="http://schema.org/CollectionPage" class="ratingHolder">
                <div class="passiveRatingHolder">
                    <div class="ratingBg"></div>
                    <div style="width: <?php echo (BanksReviews::getRatingData($review['bank'])['avg_rating'] * 20) ?>%" class="ratingMask"></div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-1">
            <?php echo $review['text'] ?>
            <br>
            <a href="<?php echo $review["category"] . '/' . $review['slug'] ?>">
                Добавить комментарий
            </a>
        </div>
    </div>
<?php endforeach ?> 