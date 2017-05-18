<?php include ROOT . '/views/templates/header.php'; ?>


<?php echo $content['text']; ?>

<div id="calc">
    <div class="form-group row">
        <label for="credit" class="col-4 col-form-label"><strong>Сумма кредита:</strong></label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="Сумма кредита" id="credit" name="credit" onkeyup="considerResultCredit()" onchange="considerResultCredit()">
        </div>
        <div class="col-4">
            <span class="badge badge-pill badge-danger">
                *Обязательное поле
            </span>
        </div>
    </div>
    <div class="form-group row">
        <label for="credit_term" class="col-4 col-form-label"><strong>Срок кредита, мес.:</strong></label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="Срок кредита" id="credit_term" name="credit_term" onkeyup="considerResultCredit()" onchange="considerResultCredit()">
        </div>
        <div class="col-4">
            <span class="badge badge-pill badge-danger">
                *Обязательное поле
            </span>
        </div>
    </div>
    <div class="form-group row">
        <label for="credit_interest_rate" class="col-4 col-form-label"><strong>Годовая процентная ставка, %:</strong></label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="Процентная ставка" id="credit_interest_rate" name="credit_interest_rate" onkeyup="considerResultCredit()" onchange="considerResultCredit()">
        </div>
        <div class="col-4">
            <span class="badge badge-pill badge-danger">
                *Обязательное поле
            </span>
        </div>
    </div>
    <div class="form-group row">
        <label for="shema" class="col-4 col-form-label"><strong>Схема погашения</strong></label>
        <div class="col-4">
            <select class="form-control" id="shema" name="shema" onchange="considerResultCredit()">
                <option id="annuitet" value="annuitet">Аннуитет</option> 
                <option id="classic" value="classic">Классическая</option> 
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="pr1" class="col-4 col-form-label">Единоразовая комиссия</label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="в процентах (%)" id="pr1" name="pr1" onkeyup="considerResultCredit()" onchange="considerResultCredit()">
        </div>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="или Сумма" id="com1" name="com1" onkeyup="considerResultCredit()" onchange="considerResultCredit()">
        </div>
    </div>
    <div class="form-group row">
        <label for="pr2" class="col-4 col-form-label">Ежемесячная комиссия</label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="в процентах (%)" id="pr2" name="pr2" onkeyup="considerResultCredit()" onchange="considerResultCredit()">
        </div>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="или Сумма" id="com2" name="com2" onkeyup="considerResultCredit()" onchange="considerResultCredit()">
        </div>
    </div>
    <div class="form-group row">
        <label for="pr3" class="col-4 col-form-label">Ежегодная комиссия</label>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="в процентах (%)" id="pr3" name="pr3" onkeyup="considerResultCredit()" onchange="considerResultCredit()">
        </div>
        <div class="col-4">
            <input class="form-control" type="number" placeholder="или Сумма" id="com3" name="com3" onkeyup="considerResultCredit()" onchange="considerResultCredit()">
        </div>
    </div>
</div>
<div id="result">
    <div class="form-group row">
        <legend class="col-form-legend col-sm-12" style="text-align: center"><strong>Стоимость кредита</strong></legend>
    </div>
    <div class="form-group row">
        <label for="pay_header" class="col-6 col-form-label">Ежемесячный платеж по кредиту:</label>
        <span id="pay_header"></span>
    </div>
    <div class="form-group row">
        <label for="monthly_fee" class="col-6 col-form-label">Ежемесячная комиссия:</label>
        <span id="monthly_fee"></span>
    </div>
    <div class="form-group row">
        <label for="overpayment" class="col-6 col-form-label"><strong>Переплата в денежном выражении:</strong></label>
        <span id="overpayment"></span>
    </div>
    <div class="form-group row">
        <legend class="col-form-legend col-sm-12"><em>в том числе:</em></legend>
    </div>
    <div class="form-group row">
        <label for="interest_on_loan" class="col-6 col-form-label">- Проценты по кредиту:</label>
        <span id="interest_on_loan"></span>
    </div>
    <div class="form-group row">
        <label for="single_fee" class="col-6 col-form-label">- Единоразовая комиссия:</label>
        <span id="single_fee"></span>
    </div>
    <div class="form-group row">
        <label for="summ_monthly_fee" class="col-6 col-form-label">- Ежемесячные комиссии:</label>
        <span id="summ_monthly_fee"></span>
    </div>
    <div class="form-group row">
        <label for="summ_year_fee" class="col-6 col-form-label">- Ежегодные комиссии:</label>
        <span id="summ_year_fee"></span>
    </div>
    <div class="form-group row">
        <label for="overpayment_percentage" class="col-6 col-form-label"><strong>Переплата в процентах:</strong></label>
        <span id="overpayment_percentage"></span>
    </div>
    <div class="form-group row">
        <label for="all_pay" class="col-6 col-form-label"><strong>Общая сумма к возврату:</strong></label>
        <span id="all_pay"></span>
    </div>
</div>
<button type="button" class="btn btn-primary btn-lg btn-block"  onclick="buildSchedule()">Построить график погашения</button>
<div id="table_data"></div>

<?php include ROOT . '/views/templates/footer.php'; ?>