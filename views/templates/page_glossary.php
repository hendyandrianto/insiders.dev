<?php include ROOT . '/views/templates/header.php'; ?>

<?php echo $content['text']; ?>
<div id="calc" class="glossary">
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="А" name="letter">А
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Б" name="letter">Б
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="В" name="letter">В
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Г" name="letter">Г
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Д" name="letter">Д
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Е" name="letter">Е
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="З" name="letter">З
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="И" name="letter">И
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="К" name="letter">К
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Л" name="letter">Л
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="М" name="letter">М
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Н" name="letter">Н
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="О" name="letter">О
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="П" name="letter">П
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Р" name="letter">Р
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="С" name="letter">С
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Т" name="letter">Т
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="У" name="letter">У
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Ф" name="letter">Ф
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Х" name="letter">Х
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Ц" name="letter">Ц
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Ч" name="letter">Ч
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" value="Э" name="letter">Э
        </label>
    </div>
</div>
<div id="catalogue">
    <?php foreach ($list as $item): ?>
        <div class="row pt-3 pb-3 border-bottom">
            <div class="col-12">
                <a href="<?php echo $item["category"] . '/' . $item["slug"]; ?>"><strong><?php echo $item["title"]; ?></strong></a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    var pagination = 'catalogue';
</script>

<?php include ROOT . '/views/templates/footer.php'; ?>