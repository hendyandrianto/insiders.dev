$(document).ready(function () {
//    $("#datepicker").datepicker($.extend({
//        dateFormat: 'yy-mm-dd',
//        minDate: '2015-08-01',
//        maxDate: '0d'
//    },
//            $.datepicker.regional['ru']
//            ));
//    jQuery(function ($) {
//        $.datepicker.regional['ru'] = {
//            prevText: '&#x3c;Пред',
//            nextText: 'След&#x3e;',
//            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
//                'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
//            monthNamesShort: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
//                'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
//            dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
//            dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
//            dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
//            weekHeader: 'Нед',
//            firstDay: 1,
//        };
//        $.datepicker.setDefaults($.datepicker.regional['ru']);
//    });
//        
    // отправка форм
    $("form").submit(function (e) {
        event.preventDefault();
        var form_type = $(this).attr('answer');
        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            type: "POST",
        }).done(function (answer) {
            //console.log(form);
            //$("form").get(0).reset();
            switch (form_type) {
                case 'comments':
                    // комментарий
                    $('div#module_comments_form #answer').html(answer);
                    break;
                case 'credits':
                    // заявка на кредит
                    $('.modal-content .modal-body').fadeIn(1000).html(answer);
                    $('.modal-content button[type="submit"]').hide();
                    break;
                case 'review':
                    // отзывы о банках
                    $('.modal-content .modal-body').fadeIn(1000).html(answer);
                    $('.modal-content button[type="submit"]').hide();
                    break;
                case 'currency':
                    // курсы валют
                    $('#table').html(answer);
                    break;
				case 'ratings':
                    // рейтинг банков
                    $('#table').html(answer);
                    break;
            }
        }).fail(function (xhr, status, error) {
            var err = xhr.responseText;
            alert(err);
        });

    });

    if (page_name === "home") {
        $(document).ready(function () {
            $('.bxslider').bxSlider({
                mode: 'fade',
                easing: 'ease',
                pager: false,
                auto: true,
                controls: false,

            });
        });
    }

    // выбор буквы словаря
    $('input[name="letter"]').change(function () {
//        document.getElementById("glossary").submit();
        var letter = $(this).val();
        $.ajax({
            url: '../catalogue/glossary',
            data: {letter: letter},
            type: "POST",
        }).done(function (answer) {
            $('#catalogue').html(answer);
            window.pagination_end = true;
        })
    });

    // слайдер выбора суммы кредита
    $("#slider-range").slider({
        min: 10000,
        max: 200000,
        value: 20000,
        step: 1000,
        slide: function (event, ui) {
            $("#amount").val(displaysNumbers(ui.value, 0, '.', ' '));
        }
    });
    $("#amount").val(displaysNumbers($("#slider-range").slider("value"), 0, '.', ' '));

    $("#slider-range").on("slidechange", function () {
        var summ_val = $("#slider-range").slider("value");

        $.each($('div#credits div.row'), function (key, value) {
            var item = $(value).get(0);
            var summ = $(item).attr('summ');
            if (summ < summ_val)
                $(item).hide();
            else if (summ > summ_val)
                $(item).show();
        });
    });

    if (page_name === "kurs-nalichnoj-valyuty" || page_name === "kurs-valyut-nbu" || page_name === "kurs-bankovskikh-metallov") {
        // таблица с сортировкой
        $('table.display').DataTable({
            "paging": false,
            "info": false,
            //"searching": false, 
        });
    }

    // конвертр валют
    if (page_name === "konverter-valyut") {
        // добавляем список валют в селект
        var main_currencys = [];
        var select_currency1 = $('#currency1');
        var select_currency2 = $('#currency2');
        var select_bank = $('#bank');
        var banks_arr = [];

        select_currency1.append('<optgroup label="Основные валюты">');
        select_currency2.append('<optgroup label="Основные валюты">');

        $.each(cache_rate, function (d, results) {
            select_currency1.append('<option value="' + d + '">' + d + '</option>');
            select_currency2.append('<option value="' + d + '">' + d + '</option>');
            main_currencys.push(d);

            if (banks_arr.length === 0)
                banks_arr = results;
        });

        select_currency1.append('</optgroup>');
        select_currency1.append('<optgroup label="Остальные валюты">');
        select_currency2.append('</optgroup>');
        select_currency2.append('<optgroup label="Остальные валюты">');

        $.each(banks_arr, function (key, bank) {
            select_bank.append('<option value="' + key + '">' + key + '</option>');
        });

        $.each(nbu_rate, function (d, results) {
            if ($.inArray(d, main_currencys) !== -1) {
                return;
            }
            select_currency1.append('<option value="' + d + '">' + d + '</option>');
            select_currency2.append('<option value="' + d + '">' + d + '</option>');
        });

        select_currency1.append('</optgroup>');
        select_currency2.append('</optgroup>');

        // меняем свойсва полей (ридонли)
        var input_summ = $('#summ');
        var input_summ_want = $('#want_summ');
        input_summ.focus(function () {
            input_summ_want.attr('readonly', true);
            input_summ_want.val('');
        });
        input_summ_want.focus(function () {
            input_summ.attr('readonly', true);
            input_summ.val('');
        });
        input_summ_want.click(function () {
            input_summ_want.attr('readonly', false);
        });
        input_summ.click(function () {
            input_summ.attr('readonly', false);
        });

        currency_convert();
        currencyConvertBank();
    }

    //ajax pagination
    if ("pagination" in window) {

        window.inProgress = false;
        window.pagination_end = false;
        var startFrom = 30, limit = 30;
        var result;
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() && !inProgress && !window.pagination_end) {
                result = dinamicPagination(pagination, startFrom, limit);
                if (result) {
                    startFrom += 30;
                    window.inProgress = false;
                }
            }
        });
    }
// scroll to top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn();
        } else {
            $('.scrollToTop').fadeOut();
        }
    });
    $('.scrollToTop').click(function () {
        $('html, body').animate({scrollTop: 0}, 1000);
        return false;
    });
    // запрет отправки отзыва без названия банка
//    var bank_select = $('#select_bank');
//    var button_send = $('button#send_review');
//    if ($(bank_select).val() == 0)
//        button_send.attr("disabled", true);
//    bank_select.change(function () {
//        if ($(bank_select).val() == 0){
//            button_send.attr("disabled", true);
//            $('#bank_select_error').show();
//        }else{
//            button_send.attr("disabled", false);
//            $('#bank_select_error').hide();
//      }
//    });
});

// функция динамической подгрузки контента
function dinamicPagination(pagination, startFrom, limit) {
    var url = 'dynamic/loading';
    var table = pagination;
    var container = document.getElementById(pagination);
    var category = window.page_name;
    var data = {
        'table': table,
        'category': category,
        'startFrom': startFrom,
        'limit': limit
    };
    $.ajax({
        url: url,
        data: data,
        type: "POST",
        beforeSend: function () {
            window.inProgress = true;
        }
    }).done(function (answer) {
        //console.log(answer);
        if (answer.length > 0)
            $(container).append(answer);
        else
            window.pagination_end = true;

    }).fail(function (xhr, status, error) {
        var err = xhr.responseText;
        alert(err);
    });
    return true;
}

// конвертр валют
function currency_convert() {
    var currency1 = $('#currency1').val();
    var currency2 = $('#currency2').val();
    var summ = $('#summ').val();
    var want_summ = $('#want_summ').val();
    var summ_rez_cache = 0, summ_rez_nbu = 0;
    var rate_nbu1, rate_nbu2, result_nbu, rate_nbu_rez,
            rate_temp1 = 0, rate_temp2 = 0,
            rate_cache1, rate_cache2, result_cache, rate_cache_rez,
            kol1 = 0, kol2 = 0;
    var cache_currency1 = currency1;
    var cache_currency2 = currency2;
    var nbu_currency1 = currency1;
    var nbu_currency2 = currency2;

    $.each(cache_rate, function (key, value) {
        if (key == currency1) {
            $.each(value, function (key, value) {
                rate_temp1 += +value.Buy;
                kol1++;
            });
            rate_cache1 = rate_temp1 / kol1;
        }
        if (key == currency2) {
            $.each(value, function (key, value) {
                rate_temp2 += +value.Sale;
                kol2++;
            });
            rate_cache2 = rate_temp2 / kol2;
        }
    });
    if (summ !== '') {
        result_cache = summ * +rate_cache1 / +rate_cache2;
        summ_rez_cache = summ;
        cache_currency1 = currency1;
        cache_currency2 = currency2;
    } else if (want_summ !== '') {
        result_cache = want_summ / +rate_cache1 * +rate_cache2;
        summ_rez_cache = want_summ;
        cache_currency1 = currency2;
        cache_currency2 = currency1;
    } else {
        result_cache = 0;
    }
    rate_cache_rez = +rate_cache1 / +rate_cache2;

    if (rate_cache_rez / 1) {
        rate_cache_rez = displaysNumbers(rate_cache_rez, 4, ".", " ");
        result_cache = displaysNumbers(result_cache, 2, ".", " ");
        summ_rez_cache = displaysNumbers(summ_rez_cache, 2, ".", " ");
        result_cache = summ_rez_cache + " " + cache_currency1.slice(0, 3) + " = <strong>" + result_cache + "</strong> " + cache_currency2.slice(0, 3);
    } else {
        rate_cache_rez = '---';
        result_cache = '---';
    }
    $('#result_banks').html(result_cache);
    $('#result_banks_rate').html(rate_cache_rez);

    $.each(nbu_rate, function (key, value) {
        if (key === currency1)
            rate_nbu1 = value;

        if (key === currency2)
            rate_nbu2 = value;
    });

    if (summ !== '') {
        result_nbu = summ * +rate_nbu1 / +rate_nbu2;
        summ_rez_nbu = summ;
        nbu_currency1 = currency1;
        nbu_currency2 = currency2;
    } else if (want_summ !== '') {
        result_nbu = want_summ / +rate_nbu1 * +rate_nbu2;
        summ_rez_nbu = want_summ;
        nbu_currency1 = currency2;
        nbu_currency2 = currency1;
    } else {
        result_nbu = 0;
    }

    result_nbu = displaysNumbers(result_nbu, 2, ".", " ");
    summ_rez_nbu = displaysNumbers(summ_rez_nbu, 2, ".", " ");
    result_nbu = summ_rez_nbu + " " + nbu_currency1.slice(0, 3) + " = <strong>" + result_nbu + "</strong> " + nbu_currency2.slice(0, 3);

    rate_nbu_rez = +rate_nbu1 / +rate_nbu2;
    $('#result_nbu').html(result_nbu);
    $('#result_nbu_rate').html(displaysNumbers(rate_nbu_rez, 4, ".", " "));
}
// конвертация валюты одного банка
function currencyConvertBank() {
    var bank = $('#bank').val();
    var currency1 = $('#currency1').val();
    var currency2 = $('#currency2').val();
    var summ = $('#summ').val();
    var want_summ = $('#want_summ').val();
    var rate_buy1, rate_sell1, rate_buy2, rate_sell2, result_bank, rate_bank;
    var summ_rez = 0;

    if (typeof cache_rate[currency1] !== "undefined") {
        rate_buy1 = cache_rate[currency1][bank].Buy;
    }

    if (typeof cache_rate[currency2] !== "undefined") {
        rate_sell2 = cache_rate[currency2][bank].Sale;
    }

    if ($.isNumeric(+rate_buy1) && $.isNumeric(+rate_sell2)) {
        if (summ !== '') {
            result_bank = summ * +rate_buy1 / +rate_sell2;
            summ_rez = summ;
        } else if (want_summ !== '') {
            result_bank = want_summ / +rate_buy1 * +rate_sell2;
            summ_rez = want_summ;
            currency1 = $('#currency2').val();
            currency2 = $('#currency1').val();
        } else {
            result_bank = 0;
        }
        rate_bank = displaysNumbers(+rate_buy1 / +rate_sell2, 4, ".", " ");
        result_bank = displaysNumbers(result_bank, 2, ".", " ");
        summ_rez = displaysNumbers(summ_rez, 2, ".", " ");
        result_bank = summ_rez + " " + currency1.slice(0, 3) + " = <strong>" + result_bank + "</strong> " + currency2.slice(0, 3);
    } else {
        result_bank = '---';
        rate_bank = '---';
    }

    $('#result_bank').html(result_bank);
    $('#result_bank_rate').html(rate_bank);
}
// изменение значений валют в конвертере
function changeValue() {
    var select1 = $('#currency1');
    var select2 = $('#currency2');
    var selected_value1 = $('#currency1').val();
    var selected_value2 = $('#currency2').val();

    select1.val(selected_value2);
    select2.val(selected_value1);
}

// добавление необходимого значения offerCode во всплывающее окно с заявкой на кредит
$('#finline').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var offercode = button.data('offercode') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    //modal.find('.modal-title').text('New message to ' + recipient)
    modal.find('.modal-body input#offerCode').val(offercode)

    // скрываем поле "сумма" для кредитных карт
    if (offercode == 'cardCredit')
        modal.find('.modal-body #amount_div').hide();
    else
        modal.find('.modal-body #amount_div').show();
})

$('#bank-review').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var bank_select = button.data('bank_select');
    var modal = $(this);
    modal.find('.modal-body select#bank_select').val(bank_select);
})

// 
function displaysNumbers(a, b, c, d) {
    a = Math.round(a * Math.pow(10, b)) / Math.pow(10, b);
    e = a + '';
    f = e.split('.');
    if (!f[0]) {
        f[0] = '0';
    }
    if (!f[1]) {
        f[1] = '';
    }
    if (f[1].length < b) {
        g = f[1];
        for (i = f[1].length + 1; i <= b; i++) {
            g += '0';
        }
        f[1] = g;
    }
    if (d != '' && f[0].length > 3) {
        h = f[0];
        f[0] = '';
        for (j = 3; j < h.length; j += 3) {
            i = h.slice(h.length - j, h.length - j + 3);
            f[0] = d + i + f[0] + '';
        }
        j = h.substr(0, (h.length % 3 == 0) ? 3 : (h.length % 3));
        f[0] = j + f[0];
    }
    c = (b <= 0) ? '' : c;

    return f[0] + c + f[1];
}
function roundingNumbers(value, precision) {
    var val = Math.round(value * Math.pow(10, precision));
    val = val < 0 ? "" : val.toString();
    val = val.substring(0, val.length - precision) + "." + val.substring(val.length - precision, val.length);
    return val;
}
// кредитный калькулятор
function considerResultCredit() {
    var shema = $('#calc #shema').val();
    var singleFee = 0;
    var monthlyFee = 0;
    var yearPay = 0;
    var Pay = 0;
    var aPay = 0;
    var ePr = 0;
    var minV;
    var year;
    var balance, interest, monthPay;
    var summBalance = 0, interestOnLoan = 0, SummPayment = 0, z;

    var a = $('#calc #credit').val().replace(",", ".");
    var p = $('#calc #credit_interest_rate').val().replace(",", ".");
    var t = $('#calc #credit_term').val().replace(",", ".");
    var credit = a;

    switch (shema) {
        case "classic" :
            $('#result label[for="pay_header"]').html('Первый платеж');
            monthPay = a / t + a * p / 1200;
            break;
        case "annuitet" :
            $('#result label[for="pay_header"]').html('Ежемесячный платеж');
            monthPay = a * p / 1200 / (1 - Math.pow(1 + p / 1200, -t));
            break;
    }

    for (i = 1; i <= 3; i++) {
        Pay = Number($('#calc #pr' + i).val().replace(",", ".")) * a / 100;
        minV = Number($('#calc #com' + i).val().replace(",", "."));

        if (minV && Pay < minV)
            Pay = minV;
        if (i == 1)
            singleFee = singleFee + Pay;
        if (i == 2)
            monthlyFee = monthlyFee + Pay;
        if (i == 3)
            yearPay = yearPay + Pay;
    }

    balance = Number(roundingNumbers(a / t, 2));
    z = Number(roundingNumbers(a * p / 1200 / (1 - Math.pow(1 + p / 1200, -t)), 2));
    for (i = 1; i < t; i++) {
        switch (shema) {
            case "classic" :
                interest = Number(roundingNumbers(a * p / 1200, 2));
                z = Number(roundingNumbers(balance + interest, 2));
                a = a - balance;
                break;
            case "annuitet" :
                interest = Number(roundingNumbers(a * p / 1200, 2));
                balance = Number(roundingNumbers(z - interest, 2));
                a = a - balance;
                break;
            default :
                interest = "";
        }
        interestOnLoan += interest;
        summBalance += balance;
        SummPayment += z;
    }
    balance = a;
    interest = Number(roundingNumbers(balance * p / 1200, 2));
    z = Number(roundingNumbers(balance + interest, 2));
    interestOnLoan += interest;
    summBalance += balance;
    SummPayment += z;
    year = (Math.floor(t / 12) == (t / 12)) ? t / 12 : Math.floor(t / 12);
    aPay = singleFee + (monthlyFee + monthPay) * t + yearPay * year;
    var overpayment = SummPayment - credit + singleFee + monthlyFee * t + yearPay * year;
    var summAll = SummPayment + singleFee + monthlyFee * t + yearPay * year;
    var summMonthlyFee = monthlyFee * t;
    var summEearFee = yearPay * year;
    var overpaymentPercentage = overpayment / credit * 100;

    $('#result #pay_header').html(displaysNumbers(monthPay, 2, ".", " "));
    $('#result #monthly_fee').html(displaysNumbers(monthlyFee, 2, ".", " "));
    $('#result #all_pay').html('<strong>' + displaysNumbers(summAll, 2, ".", " ") + '</strong>');
    $('#result #overpayment').html('<strong>' + displaysNumbers(overpayment, 2, ".", " ") + '</strong>');
    $('#result #interest_on_loan').html(displaysNumbers(interestOnLoan, 2, ".", " "));
    $('#result #single_fee').html(displaysNumbers(singleFee, 2, ".", " "));
    $('#result #summ_monthly_fee').html(displaysNumbers(summMonthlyFee, 2, ".", " "));
    $('#result #summ_year_fee').html(displaysNumbers(summEearFee, 2, ".", " "));
    $('#result #overpayment_percentage').html('<strong>' + displaysNumbers(overpaymentPercentage, 2, ".", " ") + " %</strong>");
}
// график для кредитного калькулятора
function buildSchedule() {
    var credit = $('#calc #credit').val().replace(",", ".");
    var percent = $('#calc #credit_interest_rate').val().replace(",", ".");
    var term = $('#calc #credit_term').val().replace(",", ".");
    var shema = $('#calc #shema').val();
    var balance, interest, payment;
    var summBalance = 0, SummInterest = 0, SummPayment = 0;
    var text = "";
    text = text + "<b>График погашения кредита:</b><br><br>";
    text = text + "<table class='table table-bordered'>";
    text = text + "<thead><tr><th>Период</th><th>Общий взнос<br>по кредиту</th>";
    text = text + "<th>Погашение<br>кредита</th><th>Погашение<br>процентов</th><th>Остаток<br>задолженности</th></tr></thead><tbody>";
    balance = Number(roundingNumbers(credit / term, 2));
    payment = Number(roundingNumbers(credit * percent / 1200 / (1 - Math.pow(1 + percent / 1200, -term)), 2));
    var tyear = 0;
    for (i = 1; i <= term; i++) {
        switch (shema) {
            case "classic" :
                interest = Number(roundingNumbers(credit * percent / 1200, 2));
                payment = Number(roundingNumbers(balance + interest, 2));
                credit = credit - balance;
                break;
            case "annuitet" :
                interest = Number(roundingNumbers(credit * percent / 1200, 2));
                balance = Number(roundingNumbers(payment - interest, 2));
                credit = credit - balance;
                break;
            default :
                interest = "";
        }
        if ((i - 1) % 12 == 0) {
            tyear++;
            text = text + "<tr><td><b>" + tyear + "-й год" + "</b></nobr></td><td></td><td></td><td></td><td></td></tr>";
        }
        text = text + "<tr><td><nobr>" + i + " мес." + "</nobr></td><td><b>" + roundingNumbers(payment, 2) + "</b></td><td>" + roundingNumbers(balance, 2) + "</td><td>" + roundingNumbers(interest, 2) + "</td><td>" + roundingNumbers(credit, 2) + "</td></tr>";
        SummInterest += interest;
        summBalance += balance;
        SummPayment += payment;
    }
    text = text + "<tr><td><b>Всего:</b></td><td><b>" + roundingNumbers(SummPayment, 2) + "</b></td><td><b>" + roundingNumbers(summBalance, 2) + "</b></td><td><b>" + roundingNumbers(SummInterest, 2) + "</b></td><td></td></tr>";
    text = text + "</tbody></table><br>";

    $('div#table_data').html(text);
}

// effectine rate
function calculationEffectiveRate() {
    var sPay = 0
    var mPay = 0;
    var yPay = 0;
    var Pay = 0;
    var aPay = 0;
    var ePay = 0;
    var ePr = 0;
    var minV = 0;
    var year;
    var eff = 0.0;
    var emPay, effPay = 0;
    var a = Number($("#calc #er_amount").val().replace(",", "."));
    var p = Number($("#calc #er_interest_rate").val().replace(",", "."));
    var t = Number($("#calc #er_term").val().replace(",", "."));
    var d = a * p / 1200 / (1 - Math.pow(1 + p / 1200, -t));
    var year = (Math.floor(t / 12) == (t / 12)) ? t / 12 : Math.floor(t / 12) + 1;
    for (i = 1; i <= 3; i++) {
        Pay = Number($("#calc #er_pr" + i).val().replace(",", ".")) * a / 100;
        minV = Number($("#calc #er_com" + i).val().replace(",", "."));
        if (minV && Pay < minV)
            Pay = minV;
        if (i == 1)
            sPay = sPay + Pay;
        if (i == 2)
            mPay = mPay + Pay;
        if (i == 3)
            yPay = yPay + Pay;
    }
    aPay = sPay + (mPay + d) * t + yPay * year;
    ePay = aPay - a;
    ePr = ePay / a * 100;
    var ePry = ePr / year;
    emPay = aPay / t;
    while (emPay - effPay > 0) {
        eff = eff + 0.01;
        effPay = a * eff / 1200 / (1 - Math.pow(1 + eff / 1200, -t));
    }

    $("#result #er_comission_percent").html('<strong>' + displaysNumbers(eff, 1, ".", " ") + '%</strong>');
    $("#result #er_extra_pay").html(displaysNumbers(ePay, 0, ".", " "));
    $("#result #er_extra_percent").html(displaysNumbers(ePr, 1, ".", " ") + '%');
    $("#result #er_extra_percent_year").html('<strong>' + displaysNumbers(ePry, 1, ".", " ") + '%</strong>');
}
// депозитный калькулятор
function considerResult() {
    var summaDepozita = $('#calc #deposit').val().replace(",", ".");
    var dovlozenia = $('#calc #replenishment_summ').val().replace(",", ".");
    var srok = $('#calc #term').val().replace(",", ".");
    var stavka = $('#calc #interest_rate ').val().replace(",", ".") / 12 / 100;
    var replenishment = $('#calc #replenishment').val();
    var capitalization = $('#calc #capitalization').val();
    var dep = summaDepozita;
    var summMonthProts = 0;
    var summPop = 0, monthProts, popThisMonth;

    for (i = 1; i <= srok; i++) {
        monthProts = +summaDepozita * +stavka;
        summMonthProts = +summMonthProts + +monthProts;
        popThisMonth = 0;
        if (replenishment == 1)
            popThisMonth = 0;
        if (replenishment == 2)
            popThisMonth = (i !== srok) ? +dovlozenia : 0;
        if (replenishment == 3)
            popThisMonth = ((Math.round(i / 3) == i / 3) && i != srok) ? dovlozenia : 0;
        if (replenishment == 4)
            popThisMonth = ((Math.round(i / 12) == i / 12) && i != srok) ? dovlozenia : 0;

        summPop = +summPop + +popThisMonth;

        if (capitalization == 1 && i != srok)
            summaDepozita = +summaDepozita + +popThisMonth;
        if (capitalization == 2)
            summaDepozita = +summaDepozita + +monthProts + +popThisMonth;
        if (capitalization == 3)
            summaDepozita = ((Math.round(i / 3) == i / 3) && i != srok) ? +summaDepozita + +monthProts + +popThisMonth : +summaDepozita + +popThisMonth;
        if (capitalization == 4)
            summaDepozita = ((Math.round(i / 12) == i / 12) && i != srok) ? +summaDepozita + +monthProts + +popThisMonth : +summaDepozita + +popThisMonth;
    }
    var all = summPop + +summMonthProts + +dep;

    $('#result #deposit_rez').html(displaysNumbers(dep, 2, ".", " "));
    $('#result #replenishment_summ_rez').html(displaysNumbers(summPop, 2, ".", " "));
    $('#result #interest_rez').html('<strong>' + displaysNumbers(summMonthProts, 2, ".", " ") + '</strong>');
    $('#result #all_summ_rez').html('<strong>' + displaysNumbers(all, 2, ".", " ") + '</strong>');
}

// поиск по блокам
function doSearch(searchText, container) {
    //var searchText = document.getElementById('searchTerm').value;
    var target = document.getElementById(container);

    $.each(target.children, function (k, v) {
        if (v.textContent.toLowerCase().indexOf(searchText) == -1)
            $(this).hide();
        else
            $(this).show();
    });
}
// фильтр по банкам
function filterBanks() {
    var target = document.getElementById('banks');
    var searchText = document.getElementById('searchTerm').value;
    var problem_value = document.getElementById('problem').value;
    var capital_value = document.getElementById('capital').value;

    $.each(target.children, function (k, v) {
        if ((searchText != '' && v.textContent.toLowerCase().indexOf(searchText) == -1)
                || (problem_value != '' && $(this).attr('problem') != problem_value)
                || (capital_value != '' && $(this).attr('capital') != capital_value)
                )
            $(this).hide();
        else
            $(this).show();
    });
}
// поиск по первой букве
function letter_bank(dd) {
    var target = document.getElementById('banks');
    var letter = $(dd).parent().text().replace(/^\s+/, "").charAt(0);
    $.each(target.children, function (k, v) {
        var find_letter = $(v).text().replace(/^\s+/, "").charAt(0);

        if (String(find_letter) != String(letter))
            $(this).hide();
        else
            $(this).show();
    });
}
//
//function resetSelectors(container){
//    var selectors = document.getElementById(container).getElementsByTagName('select');
//    $.each(selectors, function(k, v){
//        
//    });
//    console.log(selectors);
//}
// графики (dashboard) для курсов валют

if (page_name === "kurs-nalichnoj-valyuty") {
    google.charts.load('current', {'packages': ['corechart', 'controls']});
    function drawVisualization() {
        var dashboard = new google.visualization.Dashboard(
                document.getElementById('dashboard')
                );

        var control = new google.visualization.ControlWrapper({
            'controlType': 'ChartRangeFilter',
            'containerId': 'control',
            'options': {
                'filterColumnIndex': 0,
                'ui': {
                    'chartType': 'LineChart',
                    'chartOptions': {
                        'chartArea': {'width': '90%'},
                        'hAxis': {'baselineColor': 'none'}
                    },
                    'chartView': {
                        'columns': [0, 2, 3]
                    },
                    //'minRangeSize': 86400000
                }
            },
            //'state': {'range': {'start': new Date(1993, 0, 1)}}
        });

        var filter = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'filter',
            'options': {
                'filterColumnIndex': 1,
                'ui': {
                    'labelStacking': 'horazontal',
                    'caption': 'Выберите значение',
                    'allowTyping': false,
                    'allowMultiple': false,
                    'allowNone': false,
                    'sortValues': false,
                }
            }
        });

        var chart = new google.visualization.ChartWrapper({
            'chartType': 'AreaChart',
            'containerId': 'chart',
            'options': {
                'chartArea': {'height': '90%', 'width': '90%'},
                'hAxis': {'slantedText': false},
                'legend': {'position': 'top'}
            },
            'view': {
                'columns': [
                    {
                        'calc': function (dataTable, rowIndex) {
                            return dataTable.getFormattedValue(rowIndex, 0);
                        },
                        'type': 'string'
                    }, 2, 3]
            }
        });

        var data = new google.visualization.DataTable(dashboard_data);

        dashboard.bind([control, filter], [chart]);
        dashboard.draw(data);
    }
    google.charts.setOnLoadCallback(drawVisualization);
    //google.charts.setOnLoadCallback(drawChart);
} else if (page_name === "kurs-bankovskikh-metallov") {
    google.charts.load('current', {'packages': ['corechart', 'controls']});
    function drawVisualization() {
        var dashboard = new google.visualization.Dashboard(
                document.getElementById('dashboard')
                );

        var control = new google.visualization.ControlWrapper({
            'controlType': 'ChartRangeFilter',
            'containerId': 'control',
            'options': {
                'filterColumnIndex': 0,
                'ui': {
                    'chartType': 'LineChart',
                    'chartOptions': {
                        'chartArea': {'width': '90%'},
                        'hAxis': {'baselineColor': 'none'}
                    },
                    'chartView': {
                        'columns': [0, 2]
                    },
                    //'minRangeSize': 86400000
                }
            },
            //'state': {'range': {'start': new Date(1993, 0, 1)}}
        });

        var filter = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'filter',
            'options': {
                'filterColumnIndex': 1,
                'ui': {
                    'labelStacking': 'horazontal',
                    'caption': 'Выберите значение',
                    'allowTyping': false,
                    'allowMultiple': false,
                    'allowNone': false,
                }
            }
        });

        var chart = new google.visualization.ChartWrapper({
            'chartType': 'AreaChart',
            'containerId': 'chart',
            'options': {
                'chartArea': {'height': '90%', 'width': '90%'},
                'hAxis': {'slantedText': false},
                'legend': {'position': 'none'}
            },
            'view': {
                'columns': [
                    {
                        'calc': function (dataTable, rowIndex) {
                            return dataTable.getFormattedValue(rowIndex, 0);
                        },
                        'type': 'string'
                    }, 2]
            }
        });

        var data = new google.visualization.DataTable(dashboard_data);

        dashboard.bind([control, filter], [chart]);
        dashboard.draw(data);
    }
    google.charts.setOnLoadCallback(drawVisualization);
    //google.charts.setOnLoadCallback(drawChart);
} else if (page_name === "kurs-valyut-nbu") {
    google.charts.load('current', {'packages': ['corechart', 'controls']});
    function drawVisualization() {
        var dashboard = new google.visualization.Dashboard(
                document.getElementById('dashboard')
                );

        var control = new google.visualization.ControlWrapper({
            'controlType': 'ChartRangeFilter',
            'containerId': 'control',
            'options': {
                'filterColumnIndex': 0,
                'ui': {
                    'chartType': 'LineChart',
                    'chartOptions': {
                        'chartArea': {'width': '90%'},
                        'hAxis': {'baselineColor': 'none'}
                    },
                    'chartView': {
                        'columns': [0, 2]
                    },
                    //'minRangeSize': 86400000
                }
            },
            //'state': {'range': {'start': new Date(1993, 0, 1)}}
        });

        var filter = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'filter',
            'options': {
                'filterColumnIndex': 1,
                'ui': {
                    'labelStacking': 'horazontal',
                    'caption': 'Выберите значение',
                    'allowTyping': false,
                    'allowMultiple': false,
                    'allowNone': false,
                }
            }
        });

        var chart = new google.visualization.ChartWrapper({
            'chartType': 'AreaChart',
            'containerId': 'chart',
            'options': {
                'chartArea': {'height': '90%', 'width': '90%'},
                'hAxis': {'slantedText': false},
                'legend': {'position': 'none'}
            },
            'view': {
                'columns': [
                    {
                        'calc': function (dataTable, rowIndex) {
                            return dataTable.getFormattedValue(rowIndex, 0);
                        },
                        'type': 'string'
                    }, 2]
            }
        });

        var data = new google.visualization.DataTable(dashboard_data);

        dashboard.bind([control, filter], [chart]);
        dashboard.draw(data);
    }
    google.charts.setOnLoadCallback(drawVisualization);
    //google.charts.setOnLoadCallback(drawChart);
}
// графики раздела "Каталог"
if (page_name === "zolotovalyutnye-rezervy") {
    google.charts.load('current', {'packages': ['corechart', 'controls']});
    function drawVisualization() {
        var dashboard = new google.visualization.Dashboard(
                document.getElementById('dashboard')
                );

        var control = new google.visualization.ControlWrapper({
            'controlType': 'ChartRangeFilter',
            'containerId': 'control',
            'options': {
                'filterColumnIndex': 1,
                'ui': {
                    'chartType': 'LineChart',
                    'chartOptions': {
                        'chartArea': {'width': '90%'},
                        'hAxis': {'baselineColor': 'none'}
                    },
                    'chartView': {
                        'columns': [1, 2]
                    },
                    'minRangeSize': 86400000
                }
            },
            'state': {'range': {'start': new Date(1993, 0, 1)}}
        });

        var filter = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'filter',
            'options': {
                'filterColumnIndex': 0,
                'ui': {
                    'labelStacking': 'horazontal',
                    'caption': 'Выберите значение',
                    'allowTyping': false,
                    'allowMultiple': false
                }
            }
        });

        var chart = new google.visualization.ChartWrapper({
            'chartType': 'AreaChart',
            'containerId': 'chart',
            'options': {
                'chartArea': {'height': '90%', 'width': '90%'},
                'hAxis': {'slantedText': false},
                'legend': {'position': 'top'}
            },
            'view': {
                'columns': [
                    {'calc': function (dataTable, rowIndex) {
                            return dataTable.getFormattedValue(rowIndex, 1);
                        },
                        'type': 'string'
                    }, 2, 3, 4, 5, 6]
            }
        });

        var data = new google.visualization.DataTable(dashboard_data);

        dashboard.bind([control, filter], [chart]);
        dashboard.draw(data);
    }

    function drawChart() {
        var data = new google.visualization.DataTable(chart_data);

        var options = {
            legend: {'position': 'none'},
            colors: ['#DB843D', '#004411'],
            isStacked: true,
            chartArea: {'height': '90%', 'width': '90%'},
            //vAxis: {'minValue': 12}
        };

        var chart_current = new google.visualization.ColumnChart(document.getElementById('table_year'));

        chart_current.draw(data, options);
    }
    google.charts.setOnLoadCallback(drawVisualization);
    google.charts.setOnLoadCallback(drawChart);

} else if (page_name === 'indeks-inflyatsii') {
    google.charts.load('current', {'packages': ['corechart', 'controls']});
    function drawVisualization() {
        var dashboard = new google.visualization.Dashboard(
                document.getElementById('dashboard')
                );

        var control = new google.visualization.ControlWrapper({
            'controlType': 'ChartRangeFilter',
            'containerId': 'control',
            'options': {
                'filterColumnIndex': 1,
                'ui': {
                    'chartType': 'LineChart',
                    'chartOptions': {
                        'chartArea': {'width': '90%'},
                        'hAxis': {'baselineColor': 'none'}
                    },
                    'chartView': {
                        'columns': [1, 2]
                    },
                    'minRangeSize': 86400000
                }
            },
            'state': {'range': {'start': new Date(1993, 0, 1)}}
        });

        var filter = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'filter',
            'options': {
                'filterColumnIndex': 0,
                'ui': {
                    'labelStacking': 'horazontal',
                    'caption': 'Выберите значение',
                    'allowTyping': false,
                    'allowMultiple': false
                }
            }
        });

        var chart = new google.visualization.ChartWrapper({
            'chartType': 'AreaChart',
            'containerId': 'chart',
            'options': {
                'chartArea': {'height': '90%', 'width': '90%'},
                'hAxis': {'slantedText': false},
                'legend': {'position': 'none'}
            },
            'view': {
                'columns': [
                    {'calc': function (dataTable, rowIndex) {
                            return dataTable.getFormattedValue(rowIndex, 1);
                        },
                        'type': 'string'
                    }, 2, ]
            }
        });

        var data = new google.visualization.DataTable(dashboard_data);

        dashboard.bind([control, filter], [chart]);
        dashboard.draw(data);
    }

    function drawChart() {
        var data = new google.visualization.DataTable(chart_data);

        var options = {
            legend: {'position': 'none'},
            colors: ['#008000', '#004411'],
            chartArea: {'height': '90%', 'width': '90%'},
            //vAxis: {'minValue': 12}
        };

        var chart_current = new google.visualization.AreaChart(document.getElementById('table_year'));

        chart_current.draw(data, options);
    }
    google.charts.setOnLoadCallback(drawVisualization);
    google.charts.setOnLoadCallback(drawChart);

} else if (page_name === 'vneshnij-dolg') {
    google.charts.load('current', {'packages': ['corechart', 'controls']});
    function drawVisualization() {
        var dashboard = new google.visualization.Dashboard(
                document.getElementById('dashboard')
                );

        var control = new google.visualization.ControlWrapper({
            'controlType': 'ChartRangeFilter',
            'containerId': 'control',
            'options': {
                'filterColumnIndex': 1,
                'ui': {
                    'chartType': 'LineChart',
                    'chartOptions': {
                        'chartArea': {'width': '90%'},
                        'hAxis': {'baselineColor': 'none'}
                    },
                    'chartView': {
                        'columns': [1, 2]
                    },
                    'minRangeSize': 86400000
                }
            },
            'state': {'range': {'start': new Date(1993, 0, 1)}}
        });

        var filter = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'filter',
            'options': {
                'filterColumnIndex': 0,
                'ui': {
                    'labelStacking': 'horazontal',
                    'caption': 'Выберите значение',
                    'allowTyping': false,
                    'allowMultiple': false
                }
            }
        });

        var chart = new google.visualization.ChartWrapper({
            'chartType': 'AreaChart',
            'containerId': 'chart',
            'options': {
                'chartArea': {'height': '90%', 'width': '90%'},
                'hAxis': {'slantedText': false},
                'legend': {'position': 'top'}
            },
            'view': {
                'columns': [
                    {'calc': function (dataTable, rowIndex) {
                            return dataTable.getFormattedValue(rowIndex, 1);
                        },
                        'type': 'string'
                    }, 2, 3, 4, 5, 6, 7, 8]
            }
        });

        var data = new google.visualization.DataTable(dashboard_data);

        dashboard.bind([control, filter], [chart]);
        dashboard.draw(data);
    }

    function drawChart() {
        var dashboard = new google.visualization.Dashboard(
                document.getElementById('dashboard_structure')
                );

        var filter = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'filter_structure',
            'options': {
                'filterColumnIndex': 2,
                'ui': {
                    'labelStacking': 'horazontal',
                    'sortValues': false,
                    'allowNone': false,
                    'allowTyping': false,
                    'allowMultiple': false
                }
            }
        });

        var chart = new google.visualization.ChartWrapper({
            'chartType': 'PieChart',
            'containerId': 'chart_structure',
            'options': {
                'chartArea': {'height': '90%', 'width': '90%'},
                'is3D': true
            }
        });

        var data = new google.visualization.DataTable(chart_data);

        dashboard.bind([filter], [chart]);
        dashboard.draw(data);
    }
    google.charts.setOnLoadCallback(drawVisualization);
    google.charts.setOnLoadCallback(drawChart);

} else if (page_name === 'inostrannye-investitsii') {
    google.charts.load('current', {'packages': ['corechart', 'controls']});
    function drawVisualization() {
        var dashboard = new google.visualization.Dashboard(
                document.getElementById('dashboard')
                );

        var filter = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'filter',
            'options': {
                'filterColumnIndex': 0,
                'ui': {
                    'labelStacking': 'horazontal',
                    'caption': 'Выберите значение',
                    'allowTyping': false,
                    'allowMultiple': false
                }
            }
        });

        var chart = new google.visualization.ChartWrapper({
            'chartType': 'ColumnChart',
            'containerId': 'chart',
            'options': {
                'chartArea': {'height': '90%', 'width': '90%'},
                'hAxis': {'slantedText': false},
                'legend': {'position': 'top'},
                'colors': ['#db843c', '#f7b58f'],
            },
            'view': {
                'columns': [
                    {'calc': function (dataTable, rowIndex) {
                            return dataTable.getFormattedValue(rowIndex, 1);
                        },
                        'type': 'string'
                    }, 2, 3]
            }
        });

        var data = new google.visualization.DataTable(dashboard_data);

        dashboard.bind([filter], [chart]);
        dashboard.draw(data);
    }

    function drawChart() {
        var data = new google.visualization.DataTable(chart_data);

        var options = {
            bar: {groupWidth: "90%"},
            legend: {'position': 'top'},
            colors: ['#db843c', '#f7b58f'],
            chartArea: {'height': '90%', 'width': '90%'}
        };

        var chart_current = new google.visualization.ColumnChart(document.getElementById('table_year'));

        chart_current.draw(data, options);
    }

    function drawChartStructure() {
        var data_from = new google.visualization.DataTable(structure_from);
        var data_to = new google.visualization.DataTable(structure_to);

        var options = {
            legend: {'position': 'none'},
            colors: ['#9cba58'],
            chartArea: {'height': '90%', 'width': '60%'}
        };

        var chart_from = new google.visualization.BarChart(document.getElementById('structure_from'));
        var chart_to = new google.visualization.BarChart(document.getElementById('structure_to'));

        chart_to.draw(data_to, options);
        chart_from.draw(data_from, options);
    }

    google.charts.setOnLoadCallback(drawChartStructure);
    google.charts.setOnLoadCallback(drawVisualization);
    google.charts.setOnLoadCallback(drawChart);

} else if (page_name === 'valovoj-vnutrennij-produkt') {
    google.charts.load('current', {'packages': ['corechart', 'controls']});
    function drawVisualization() {
        var dashboard = new google.visualization.Dashboard(
                document.getElementById('dashboard')
                );

        var filter = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'filter',
            'options': {
                'filterColumnIndex': 0,
                'ui': {
                    'labelStacking': 'horazontal',
                    'caption': 'Выберите значение',
                    'sortValues': false,
                    'allowNone': false,
                    'allowTyping': false,
                    'allowMultiple': false
                }
            }
        });

        var chart = new google.visualization.ChartWrapper({
            'chartType': 'ColumnChart',
            'containerId': 'chart',
            'options': {
                'chartArea': {'height': '90%', 'width': '90%'},
                'hAxis': {'slantedText': false},
                'legend': {'position': 'top'},
                'colors': ['#db843c', '#f7b58f'],
            },
            'view': {
                'columns': [
                    {'calc': function (dataTable, rowIndex) {
                            return dataTable.getFormattedValue(rowIndex, 1);
                        },
                        'type': 'string'
                    }, 2, 3]
            }
        });

        var data = new google.visualization.DataTable(dashboard_data);

        dashboard.bind([filter], [chart]);
        dashboard.draw(data);
    }

    function drawChart() {
        var dashboard = new google.visualization.Dashboard(
                document.getElementById('dashboard_currency')
                );

        var filter = new google.visualization.ControlWrapper({
            'controlType': 'CategoryFilter',
            'containerId': 'filter_currency',
            'options': {
                'filterColumnIndex': 1,
                'ui': {
                    'labelStacking': 'horazontal',
                    'sortValues': false,
                    'allowNone': false,
                    'allowTyping': false,
                    'allowMultiple': false
                }
            }
        });

        var chart = new google.visualization.ChartWrapper({
            'chartType': 'AreaChart',
            'containerId': 'chart_currency',
            'options': {
                'chartArea': {'height': '90%', 'width': '80%'},
                'legend': {'position': 'none'},
            },
            'view': {
                'columns': [0, 2]
            }
        });

        var data = new google.visualization.DataTable(chart_data);

        dashboard.bind([filter], [chart]);
        dashboard.draw(data);
    }
    google.charts.setOnLoadCallback(drawVisualization);
    google.charts.setOnLoadCallback(drawChart);

} else if (page_name === 'rejting-bankov-ukraini') {
    google.charts.load('current', {'packages': ['corechart', 'controls']});
    function drawChartStructure() {
        var data_aktiv = new google.visualization.DataTable(chart_aktiv);
        var data_dfl = new google.visualization.DataTable(chart_dfl);

        var options = {
            //is3D: true,
            //legend: {'position': 'none'},
            //colors: ['#975828', '#ac642d', '#be6f32', '#ce7837', '#f8d6c6'],
            chartArea: {'height': '90%', 'width': '90%'}
        };

        var chart_top10_aktiv = new google.visualization.PieChart(document.getElementById('top_10_aktiv'));
        var chart_top10_dfl = new google.visualization.PieChart(document.getElementById('top_10_dfl'));

        chart_top10_aktiv.draw(data_aktiv, options);
        chart_top10_dfl.draw(data_dfl, options);
    }

    google.charts.setOnLoadCallback(drawChartStructure);
    google.charts.setOnLoadCallback(drawVisualization);
    google.charts.setOnLoadCallback(drawChart);
}

// modules
// ответ на комментарий
$('a.comment_answer').click(function () {
    event.preventDefault();
    var id_comment = $(this).attr('id-comment');
	var href = $(this).attr('href');
	var offset = $(href).offset().top;
	$('html,body').animate({scrollTop: offset}, 1000);
    $('#module_comments_form').find('input#id_parent').val(id_comment);
    $('#module_comments_form').find('input#comment_name').focus();
});