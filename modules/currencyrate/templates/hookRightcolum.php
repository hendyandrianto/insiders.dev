<table class="table" id="currencys">
    <thead>
        <tr>
            <th></th>
            <th><a href="/kursy-valyut/kurs-nalichnoj-valyuty">Наличный курс>></a></th>
            <th><a href="/kursy-valyut/kurs-valyut-nbu">Курс НБУ>></a></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($content as $currency => $rate): ?>
            <tr>
                <th scope="row"><img src="<?php echo '/modules/currencyrate/templates/img/' . $currency . '.png' ?>"> <?php echo strtoupper($currency) ?></th>
                <td><?php echo number_format($rate['average_buy'], 3, '.', ' ') . ' / ' . number_format($rate['average_sell'], 3, '.', ' ') ?></td>
                <td><?php echo number_format($rate['nbu'], 3, '.', ' ') ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
