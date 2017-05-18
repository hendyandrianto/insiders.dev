<?php include ROOT . '/views/templates/header.php'; ?>


<button type="button" class="btn btn-block btn-primary mb-3" data-toggle="modal" data-target="#bank-review">
    Написать отзыв
</button>

<?php foreach ($reviews_list as $review): ?>
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
            <a href="/banki/banki-ukrainy/<?php echo $review['bank_link'] ?>">
                <strong class="h5"><?php echo $review['bank_name'] ?></strong>
            </a>
        </div>
        <div class="col-4 hidden-xs-down text-right">   
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

<script>
    var pagination = 'bank_reviews';
</script>

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