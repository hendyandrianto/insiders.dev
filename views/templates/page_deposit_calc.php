<?php include ROOT . '/views/templates/header.php'; ?>

<?php echo $content['text']; ?>
<div id="calc">
    <div class="form-group row">
        <label for="deposit" class="col-4 col-form-label"><strong>Сумма депозита:</strong></label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="Сумма депозита" id="deposit" name="deposit" onkeyup="considerResult()" onchange="considerResult()">
        </div>
        <div class="col-4">
            <span class="badge badge-pill badge-danger">
                *Обязательное поле
            </span>
        </div>
    </div>
    <div class="form-group row">
        <label for="term" class="col-4 col-form-label"><strong>Срок депозита, мес.:</strong></label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="Срок депозита" id="term" name="term" onkeyup="considerResult()" onchange="considerResult()">
        </div>
        <div class="col-4">
            <span class="badge badge-pill badge-danger">
                *Обязательное поле
            </span>
        </div>
    </div>
    <div class="form-group row">
        <label for="interest_rate" class="col-4 col-form-label"><strong>Годовая процентная ставка, %:</strong></label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="Процентная ставка" id="interest_rate" name="interest_rate" onkeyup="considerResult()" onchange="considerResult()">
        </div>
        <div class="col-4">
            <span class="badge badge-pill badge-danger">
                *Обязательное поле
            </span>
        </div>
    </div>
    <div class="form-group row">
        <label for="replenishment" class="col-4 col-form-label"><strong>Пополнение депозита</strong></label>
        <div class="col-4">
            <select class="form-control" id="replenishment" name="replenishment" onchange="considerResult()">
                <option value=1>нет</option>
                <option value=2>ежемесячно</option>
                <option value=3>каждые 3 месяца</option>
                <option value=4>ежегодно</option>
            </select>
        </div>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="На сумму" id="replenishment_summ" name="replenishment_summ" onkeyup="considerResult()"  onchange="considerResult()">
        </div>
    </div>
    <div class="form-group row">
        <label for="capitalization" class="col-4 col-form-label"><strong>Капитализация процентов</strong></label>
        <div class="col-4">
            <select class="form-control" id="capitalization" name="capitalization" onchange="considerResult()">
                <option value=1>нет</option>
                <option value=2>ежемесячно</option>
                <option value=3>каждые 3 месяца</option>
                <option value=4>ежегодно</option>
            </select>
        </div>
    </div>
</div>
<div id="result">
    <div class="form-group row">
        <legend class="col-form-legend col-sm-12" style="text-align: center"><strong>Выплаты по депозиту</strong></legend>
    </div>
    <div class="form-group row">
        <label for="deposit_rez" class="col-6 col-form-label">Депозит:</label>
        <span id="deposit_rez"></span>
    </div>
    <div class="form-group row">
        <label for="replenishment_summ_rez" class="col-6 col-form-label">Сумма довложений:</label>
        <span id="replenishment_summ_rez"></span>
    </div>
    <div class="form-group row">
        <label for="interest_rez" class="col-6 col-form-label"><strong>Сумма процентов по депозиту:</strong></label>
        <span id="interest_rez"></span>
    </div>
    <div class="form-group row">
        <label for="all_summ_rez" class="col-6 col-form-label"><strong>Итого, общая сумма к возврату:</strong></label>
        <span id="all_summ_rez"></span>
    </div>
</div>

<?php include ROOT . '/views/templates/footer.php'; ?>