<?php include ROOT . '/views/templates/header.php'; ?>

<?php echo $content['text']; ?>
<div id="calc">
    <div class="form-group row">
        <label for="er_amount" class="col-4 col-form-label"><strong>Сумма кредита:</strong></label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="Сумма кредита" id="er_amount" name="er_amount" onkeyup="calculationEffectiveRate()" onchange="calculationEffectiveRate()">
        </div>
        <div class="col-4">
            <span class="badge badge-pill badge-danger">
                *Обязательное поле
            </span>
        </div>
    </div>
    <div class="form-group row">
        <label for="er_term" class="col-4 col-form-label"><strong>Срок кредита, мес.:</strong></label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="Срок кредита" id="er_term" name="er_credit_term" onkeyup="calculationEffectiveRate()" onchange="calculationEffectiveRate()">
        </div>
        <div class="col-4">
            <span class="badge badge-pill badge-danger">
                *Обязательное поле
            </span>
        </div>
    </div>
    <div class="form-group row">
        <label for="er_interest_rate" class="col-4 col-form-label"><strong>Годовая процентная ставка, %:</strong></label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="Процентная ставка" id="er_interest_rate" name="er_interest_rate" onkeyup="calculationEffectiveRate()" onchange="calculationEffectiveRate()">
        </div>
        <div class="col-4">
            <span class="badge badge-pill badge-danger">
                *Обязательное поле
            </span>
        </div>
    </div>
    <div class="form-group row">
        <label for="er_pr1" class="col-4 col-form-label">Единоразовая комиссия</label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="в процентах (%)" id="er_pr1" name="er_pr1" onkeyup="calculationEffectiveRate()" onchange="calculationEffectiveRate()">
        </div>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="или Сумма" id="er_com1" name="er_com1" onkeyup="calculationEffectiveRate()" onchange="calculationEffectiveRate()">
        </div>
    </div>
    <div class="form-group row">
        <label for="er_pr2" class="col-4 col-form-label">Ежемесячная комиссия</label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="в процентах (%)" id="er_pr2" name="er_pr2" onkeyup="calculationEffectiveRate()" onchange="calculationEffectiveRate()">
        </div>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="или Сумма" id="er_com2" name="er_com2" onkeyup="calculationEffectiveRate()" onchange="calculationEffectiveRate()">
        </div>
    </div>
    <div class="form-group row">
        <label for="er_pr3" class="col-4 col-form-label">Ежегодная комиссия</label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="в процентах (%)" id="er_pr3" name="er_pr3" onkeyup="calculationEffectiveRate()" onchange="calculationEffectiveRate()">
        </div>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="или Сумма" id="er_com3" name="er_com3" onkeyup="calculationEffectiveRate()" onchange="calculationEffectiveRate()">
        </div>
    </div>
</div>
<div id="result">
    <div class="form-group row">
        <legend class="col-form-legend col-sm-12" style="text-align: center"><strong>Стоимость кредита</strong></legend>
    </div>
    <div class="form-group row">
        <label for="er_comission_percent" class="col-6 col-form-label"><strong>Эффективная ставка по кредиту:</strong></label>
        <span id="er_comission_percent"></span>
    </div>
    <div class="form-group row">
        <label for="er_extra_pay" class="col-6 col-form-label">Переплата в денежном выражении:</label>
        <span id="er_extra_pay"></span>
    </div>
    <div class="form-group row">
        <label for="er_extra_percent" class="col-6 col-form-label">Переплата за весь период в процентах:</label>
        <span id="er_extra_percent"></span>
    </div>
    <div class="form-group row">
        <label for="er_extra_percent_year" class="col-6 col-form-label"><strong>Реальная ставка:</strong></label>
        <span id="er_extra_percent_year"></span>
    </div>
</div>

<?php include ROOT . '/views/templates/footer.php'; ?>