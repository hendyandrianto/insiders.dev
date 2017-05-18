<?php include ROOT . '/views/templates/header.php'; ?>

<div class="row mb-3 text-right">
    <div class="col-12">
        <div itemscope="" itemtype="http://schema.org/CollectionPage" class="ratingHolder">
            <div class="passiveRatingHolder">
                <div class="ratingBg"></div>
                <div style="width: <?php echo (BanksReviews::getRatingData($content['bank'])['avg_rating'] * 20) ?>%" class="ratingMask"></div>
            </div>
            <div class="rateNumbers text-muted">                                 
                <div itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
                    <div>Оценка автора: <?php echo $content['rating'] ?></div>
                    <div>Средняя оценка банку: 
                        <span itemprop="ratingValue"><?php echo number_format($rating_bank['avg_rating'], 2) ?></span>
                        из
                        <span itemprop="bestRating">5.00</span></div>
                    <div>Количество отзывов: <span itemprop="reviewCount"><?php echo $rating_bank['count_rating'] ?></span></div>
                </div>
            </div>
            <div>
                <a href="/banki/banki-ukrainy/<?php echo $bank_data['slug'] ?>">
                    Все отзывы и информация о банке >>
                </a>
            </div>
        </div> 
    </div>
</div>
<div class="row mb-2">
    <div class="col-12">
        <?php echo $content['text'] ?>  
    </div>
</div>


<?php include ROOT . '/views/templates/footer.php'; ?>