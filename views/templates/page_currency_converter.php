<?php include ROOT . '/views/templates/header.php'; ?>

<?php echo $content['text']; ?>
<div id="calc">
    <div class="row">
        <div class="form-group col-sm-5">
            <label for="currency1">Что отдаем:</label>
            <select class="form-control" id="currency1" name="currency1" onchange="currency_convert(); currencyConvertBank()"></select>
        </div>
        <div class="form-group col-sm-2">
            <button class="btn btn-primary" onclick="changeValue(); currency_convert(); currencyConvertBank()">&#8596;</button>
        </div>
        <div class="form-group col-sm-5">
            <label for="currency2">Что получаем:</label>
            <select class="form-control" id="currency2" name="currency1" onchange="currency_convert(); currencyConvertBank()"></select>
        </div> 
    </div>
    <div class="row">
        <div class="form-group col-sm-5">
            <label for="summ">В размере</label>
            <input type="number" class="form-control" id="summ" placeholder="Сумма..." onkeyup="currency_convert(); currencyConvertBank()" onchange="currency_convert(); currencyConvertBank()">
        </div>
        <div class="form-group col-sm-2">
            <p>Или</p>
        </div>
        <div class="form-group col-sm-5">
            <label for="want_summ">Сколько нужно получить</label>
            <input type="number" class="form-control" id="want_summ" placeholder="Сумма..." onkeyup="currency_convert(); currencyConvertBank()" onchange="currency_convert(); currencyConvertBank()">
        </div>
    </div>
</div>
<div id="result">
    <div class="form-group row">
        <legend class="col-form-legend col-sm-4"><strong>Источник курса</strong></legend>
        <legend class="col-form-legend col-sm-6"><strong>Результат</strong></legend>
        <legend class="col-form-legend col-sm-2"><strong>Курс</strong></legend>
    </div>
    <div class="form-group row">
        <label for="result_nbu" class="col-4 col-form-label">НБУ</label>
        <div class="col-6">
            <span id="result_nbu"></span>
        </div>
        <div class="col-2">
            <span id="result_nbu_rate"></span>
        </div>
    </div>
    <div class="form-group row">
        <label for="result_banks" class="col-4 col-form-label">Среднебанковский курс</label>
        <div class="col-6">
            <span id="result_banks"></span>
        </div>
        <div class="col-2">
            <span id="result_banks_rate"></span>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-4">
            <select class="form-control" id="bank" name="bank" onchange="currencyConvertBank()"></select>
        </div>
        <div class="col-6">
            <span id="result_bank"></span>
        </div>
        <div class="col-2">
            <span id="result_bank_rate"></span>
        </div>
    </div>
</div>
<p>При конвертации одной иностранной валюты на другую необходимо учесть, что операция обмена осуществляется через конвертацию валюты в гривну.</p>
<p>Например, чтоб поменять доллары США на Евро, нужно сначала продать доллары за гривну, потом за полученную гривну купить Евро.</p>

<script type="text/javascript">
    var cache_rate = <?php echo $cache; ?>;
    var nbu_rate = <?php echo $nbu; ?>;
</script>

<?php include ROOT . '/views/templates/footer.php'; ?>