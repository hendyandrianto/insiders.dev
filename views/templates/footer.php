</div>
<?php $modules->getModules('bottomcontent', ['slug' => $content['slug'], 'table' => $this->table, 'category' => $content['category']])  ?>
</div>

<?php include ROOT . '/views/templates/right_sidebar.php'; ?>

</div>
</div>

</section>

<a href="#" class="scrollToTop"><img src="/views/img/top.png"></a>

<footer class="footer">
    <div class="container">
        <div class="row">
            Copyright <?php echo Date('Y'); ?>
        </div>
    </div>
</footer>

<!-- Modal credit-->
<div class="modal fade" id="finline" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="credit/send" method="post" answer="credits">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Онлайн-заявка на кредит</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="firstName" class="col-4 col-form-label">Имя</label>
                        <div class="col-8">
                            <input class="form-control" type="text" id="firstName" name="firstName" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lastName" class="col-4 col-form-label">Фамилия</label>
                        <div class="col-8">
                            <input class="form-control" type="text" id="lastName" name="lastName" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="birthDate" class="col-4 col-form-label">Дата рождения</label>
                        <div class="col-8">
                            <input format="dd.mm.yyyy" class="form-control" type="date" id="birthDate" name="birthDate" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="identCode" class="col-4 col-form-label">Идентификационный код</label>
                        <div class="col-8">
                            <input class="form-control" type="number" id="identCode" name="identCode" required>
                        </div>
                    </div>    
                    <div class="form-group row" id="amount_div">
                        <label for="amount" class="col-4 col-form-label">Сумма кредита</label>
                        <div class="col-8">
                            <input class="form-control" type="number" id="amount" name="amount">
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label for="city" class="col-4 col-form-label">Город</label>
                        <div class="col-8">
                            <input class="form-control" type="text" id="city" name="city" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="Phone" class="col-4 col-form-label">Мобильный номер телефона</label>
                        <div class="col-8">
                            <input class="form-control" type="text" placeholder="+380501234567" id="Phone" name="Phone" required>
                            <small class="form-text text-muted">Задается в универсальном формате, например: +380501234567.</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="employment" class="col-4 col-form-label">Трудоустройство</label>
                        <div class="col-8">
                            <select  class="form-control" id="employment" name="employment" required>
                                <option id="official" value="official">устроен официально</option>
                                <option id="unofficial" value="unofficial">устроен неофициально</option>
                                <option id="no" value="no">не трудоустроен</option>
                                <option id="officialPrivate" value="officialPrivate">официально в фирме через ФЛП</option>
                                <option id="private" value="private">ФЛП</option>
                                <option id="maternityLeave" value="maternityLeave">декретный отпуск</option>
                                <option id="pensioner" value="pensioner">пенсионер</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="aim" class="col-4 col-form-label">Цель кредита</label>
                        <div class="col-8">
                            <select  class="form-control" id="aim" name="aim" required>
                                <option id="usedCar" value="usedCar">покупка Б/У авто</option>
                                <option id="technics" value="technics">ремонт/покупка техники, мебели</option>
                                <option id="humanDeposit" value="humanDeposit">деньги под залог авто</option>
                                <option id="cure" value="cure">на лечение</option>
                                <option id="business" value="business">на бизнес</option>
                                <option id="otherCredit" value="otherCredit">погашение другого кредита</option>
                                <option id="untilSalary" value="untilSalary">деньги до зарплаты</option>
                                <option id="other" value="other">другое</option>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" name="partner" value="1798">
                    <input type="hidden" name="offerCode" id="offerCode" value="cashCard">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Отправить заявку</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var page_name = "<?php echo $content['slug']; ?>";
</script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','/views/js/external/analytics.js','ga');

  ga('create', 'UA-37596035-1', 'auto');
  ga('send', 'pageview');

</script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter23311768 = new Ya.Metrika({id: 23311768,
                    webvisor: true,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true});
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () {
                    n.parentNode.insertBefore(s, n);
                };
        s.type = "text/javascript";
        s.async = true;
        s.src = "/views/js/external/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/23311768" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!--LiveInternet counter--><script type="text/javascript"><!--
new Image().src = "//counter.yadro.ru/hit?r" +
            escape(document.referrer) + ((typeof (screen) == "undefined") ? "" :
            ";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
                    screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
            ";" + Math.random();//--></script><!--/LiveInternet-->

<link rel="stylesheet" href="/views/css/jquery-ui.min.css">
<link href="/views/css/style.css" rel="stylesheet">

<script src="/views/js/jquery-3.1.1.min.js"></script>

<link rel="stylesheet" href="/views/css/bootstrap.min.css">
<script src="/views/js/tether.min.js"></script>
<script src="/views/js/bootstrap.min.js"></script>

<script src="/views/js/jquery-ui.min.js"></script>

<?php if ($content['slug'] == 'home'): ?>
    <!-- bxSlider Javascript file -->
    <script src="/views/js/jquery.bxslider.min.js"></script>
<?php endif; ?>
<?php if ($content['category'] == 'spravochnik' || $content['category'] == 'kursy-valyut' || $content['slug'] == 'rejting-bankov-ukraini'): ?>
    <!--dashboard-->
    <script type="text/javascript" src="/views/js/loader.js"></script>
	<!--link href="/views/js/external/charts/controls.css" rel="stylesheet">
	<link href="/views/js/external/charts/tooltip.css" rel="stylesheet">
	<link href="/views/js/external/charts/util.css" rel="stylesheet">
	<script src="/views/js/external/charts/jsapi_compiled_format_module.js"></script>
	<script src="/views/js/external/charts/jsapi_compiled_default_module.js"></script>
	<script src="/views/js/external/charts/jsapi_compiled_ui_module.js"></script>
	<script src="/views/js/external/charts/jsapi_compiled_controls_module.js"></script>
	<script src="/views/js/external/charts/jsapi_compiled_corechart_module.js"></script-->	
<?php endif; ?>

<?php if ($content['category'] == 'kursy-valyut'): ?>
    <!--data table-->
    <link href="/views/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="/views/js/jquery.dataTables.min.js"></script>
<?php endif; ?>

<script src="/views/js/scripts.js"></script>

</body>
</html>