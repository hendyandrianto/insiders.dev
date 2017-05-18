<?php include ROOT . '/views/templates/header.php'; ?>

<?php echo $content['text']; ?>
<div id="calc">
    <div class="form-group row">
        <label for="searchTerm" class="col-4 col-form-label">Поиск</label>
        <div class="col-8">
            <input class="form-control" type="text" placeholder="Поиск" id="searchTerm" onfocus="dinamicPagination(window.pagination, 30, 200); $('*').removeAttr('onfocus');" onkeyup="filterBanks()">
        </div>
    </div>
    <div class="form-group row">
        <label for="problem" class="col-4 col-form-label">Проблемные банки</label>
        <div class="col-8">
            <select  class="form-control" id="problem" onfocus="dinamicPagination(window.pagination, 30, 200); $('*').removeAttr('onfocus')" onchange="filterBanks()">
                <option value="">- Выбрать статус -</option>
                <option value="Временная администрация">Временная администрация</option>
                <option value="Ликвидация">Ликвидация</option>
            </select>
        </div>
    </div>  
    <div class="form-group row">
        <label for="capital" class="col-4 col-form-label">Капитал</label>
        <div class="col-8">
            <select  class="form-control" id="capital" onfocus="dinamicPagination(window.pagination, 30, 200); $('*').removeAttr('onfocus')" onchange="filterBanks()">
                <option value="">- Выбрать -</option>
                <option value="Государственный">Государственный</option>
                <option value="Частный украинский">Украинский капитал</option>
                <option value="Частично иностранный капитал">Частично иностранный капитал</option>
                <option value="100% иностранный капитал">100% иностранный капитал</option>
            </select>
        </div>
    </div> 
    <!--div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" onchange="letter_bank(this)"> А
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="inlineRadioOptions"  onchange="letter_bank(this)"> Б
        </label>
    </div>
    <div class="form-check form-check-inline">
        <label class="form-check-label">
            <input class="form-check-input" type="radio" name="inlineRadioOptions"  onchange="letter_bank(this)"> В
        </label>
    </div-->
</div>
<div id="banks">
    <?php foreach ($list as $item): ?>
        <div class="row pt-3 pb-3 border-bottom" capital="<?php echo isset($item["table_data"]['Капитал']) ? $item["table_data"]['Капитал'] : ''; ?>" problem="<?php echo isset($item["table_data"]['Статус']) ? $item["table_data"]['Статус'] : ''; ?>">
            <div class="col-12 col-md-4">
                <a href="<?php echo $item["category"] . '/' . $item["slug"]; ?>"><strong><?php echo $item["title"]; ?></strong></a>
            </div>
            <div class="col-12 col-md-4">
                <?php if (!empty($item["table_data"]['Статус'])): ?>
                    <span class="badge badge-danger">
                        <?php echo $item["table_data"]['Статус'] ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    var pagination = 'banks';
</script>

<?php include ROOT . '/views/templates/footer.php'; ?>