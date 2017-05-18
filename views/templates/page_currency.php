<?php include ROOT . '/views/templates/header.php'; ?>

<?php echo $content['text']; ?>

<form class="form-inline mb-3 mt-3" action="currency/history" method="post" answer="currency">
    <input class="form-control" type="date" min="2017-01-01" max="<?php echo date('Y-m-d'); ?>" name="currencydate">                    
    <!--input class="form-control" type="text" id="datepicker" name="currencydate" placeholder="Дата"-->
    <input class="btn btn-success" type="submit" name="viewdate" value="Показать">
    <input type="hidden" name="currency_type" value="<?php echo $content['slug']; ?>">
</form>

<div id="table">
    <?php echo $content['table'] ?>
</div>

<h2>График</h2>
<div id="dashboard">
    <div id="filter" style='width: 100%; height: 50px;'></div>
    <div id="chart" style='width: 100%; height: 400px;'></div>
    <div id="control" style='width: 100%; height: 50px;'></div>
</div>
<p class="p-3">Курсы валют предоставлены сайтом&nbsp;<a href="http://sravnibank.com.ua" target="_blank"><img src="/views/img/sravni.png" alt="sravni"></a></p>

<script type="text/javascript">
    var dashboard_data = <?php echo $dashboard; ?>;
</script>

<?php include ROOT . '/views/templates/footer.php'; ?>