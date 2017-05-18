<?php include ROOT . '/views/templates/header.php'; ?>


<div id="bank_data">
    <?php foreach ($bank_data as $param_name => $param_data): ?>
        <?php if (!empty($param_data)): ?>    
            <div class="row p-2 border-bottom">
                <div class="col-12 col-sm-4">
                    <strong><?php echo $param_name; ?></strong>
                </div>
                <div class="col-12 col-sm-8">
                    <?php echo $param_data; ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php if (isset($finrez) && !empty($finrez)): ?>
    <div id="finrez" class="mt-2">
        <h2>Финансовые показатели банка<br>
            <small class="text-muted">тыс. грн., состоянием на <?php echo $date_finrez ?></small>
        </h2>
        <?php foreach ($finrez as $key => $value): ?>
            <?php unset($value['Банк']);
            unset($value['date'])
            ?>
            <div class="row p-2 border-bottom">
                <div class="col-12 col-sm-4">
                    <strong><?php echo $key; ?></strong>
                </div>
                <div class="col-12 col-sm-8">                                    
        <?php foreach ($value as $rez_key => $rez_value): ?>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <strong><?php echo $rez_key; ?></strong>
                            </div>
                            <div class="col-12 col-sm-6">
            <?php echo number_format((float) $rez_value, 0, '.', ' '); ?>
                            </div>
                        </div>
        <?php endforeach; ?>                                    
                </div>
            </div>
    <?php endforeach; ?>
    </div>
<?php endif ?>

<div class="bank_reviews mt-3 mb-2">
    <h2>Отзывы о банке</h2>

    <div class="col-12 col-md-12 text-center mb-3">
        <div itemscope="" itemtype="http://schema.org/CollectionPage" class="ratingHolder">

            <div class="rateNumbers text-muted">                                 
                <div itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">
                    <strong>
                        Народный рейтинг банка (Средняя оценка): 
                        <span itemprop="ratingValue" class="badge badge-default"><?php echo number_format($rating_bank['avg_rating'], 2) ?></span>
                        из
                        <span itemprop="bestRating" class="badge badge-default">5.00</span>
                        Количество отзывов: <span itemprop="reviewCount" class="badge badge-default"><?php echo $rating_bank['count_rating'] ?></span>
                    </strong>
                </div>
            </div>
            <div class="passiveRatingHolder">
                <div class="ratingBg"></div>
                <div style="width: <?php echo (BanksReviews::getRatingData($content['id'])['avg_rating'] * 20) ?>%" class="ratingMask"></div>
            </div>
        </div> 
    </div>
    <button type="button" class="btn btn-block btn-primary mb-3" data-toggle="modal" data-target="#bank-review" data-bank_select="<?php echo $content['id']; ?>">
        Написать отзыв о банке
    </button>
    <?php if (isset($reviews) && count($reviews) > 0): ?>
    <?php foreach ($reviews as $review): ?>
            <div class="border-bottom p-2">
                <div class="row">
                    <div class="col-12 col-md-8">
                        <strong>
                            <em><?php echo $review['name'] ?></em>,
        <?php echo date('d.m.Y', strtotime($review['date_add'])) ?>
                        </strong>
                    </div>
                    <div class="col-12 col-md-4">
                        <div itemscope="" itemtype="http://schema.org/CollectionPage" class="ratingHolder">
                            <div class="passiveRatingHolder">
                                <div class="ratingBg"></div>
                                <div style="width: <?php echo ($review['rating'] * 20) ?>%" class="ratingMask"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
        <?php echo $review['text'] ?><br>
                        <a href="/banki/otzyvy-o-bankakh/<?php echo $review['slug'] ?>">
                            Добавить комментарий
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
<?php else: ?>
        <div class="row">
            <div class="col-12 text-center">
                <strong>О банке еще нет отзывов!</strong>
            </div>
        </div>
<?php endif; ?>
</div>

<!-- Modal -->
<div class="modal fade" id="bank-review" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="bank/review" method="post" answer="review">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Написать отзыв</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <input class="form-control" type="text" name="name" placeholder="Ваше имя" required>
                        </div>
                    </div>

                    <div class="form-group row">                       
                        <div class="col-12">
                            <select id="bank_select" class="form-control" name="bank_select" required>
                                <option value="">-- Выберите банк --</option>
                                <?php foreach ($banks_list as $bank) : ?>
                                    <option value="<?php echo $bank['id'] ?>"><?php echo $bank['title'] ?></option>
<?php endforeach; ?>
                            </select>
                            <span id="bank_select_error" style="display:none;color:red">Необходимо выбрать банк</span>
                        </div>
                    </div>
                    <div class="form-group row">                       
                        <div class="col-12">
                            <input class="form-control" type="text" name="subject" placeholder="Заголовок отзыва" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <textarea class="form-control" name="review" rows="3" placeholder="Отзыв" required></textarea>
                        </div>
                    </div>
                    <div class="custom-controls-stacked">
                        <strong>Ваша оценка банку</strong>
                        <label class="custom-control custom-radio">
                            <input value="5" name="rating" type="radio" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">5 (отлично)</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input value="4" name="rating" type="radio" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">4 (хорошо)</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input value="3" name="rating" type="radio" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">3 (удовлетворительно)</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input value="2" name="rating" type="radio" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">2 (плохо)</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input value="1" name="rating" type="radio" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">1 (очень плохо)</span>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" id="send_review" class="btn btn-primary">Оставить отзыв</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include ROOT . '/views/templates/footer.php'; ?>