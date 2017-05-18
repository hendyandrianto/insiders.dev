<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="index, follow"/>
        <meta name="description" content="<?php echo $content['meta_desc'] ?>"/>
        <meta name="author" content="Leonid Ivanushenko">

        <link rel="icon" href="/views/img/insiders.ico" type="image/x-icon">

        <?php if ($content['meta_title'] != ''): ?>
            <title><?php echo $content['meta_title'] ?> | Инсайдер</title>
        <?php else: ?>
            <title><?php echo $content['title'] ?> | Инсайдер</title>
        <?php endif; ?>

        <?php global $modules; ?>
    </head>
    <body>
        <header>
            <div class="nav-container">
                <div class="container">
                    <div class="row">
                        <div class="col-5">
                            <a href="/"><img class="logo" src="/views/img/logo.png" alt="Инсайдер - все о банках"/></a>
                        </div>
                        <div class="col-7">

                            <nav class="navbar navbar-toggleable-md navbar-light">
                                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <!--a class="navbar-brand" href="#">Navbar</a-->
                                <div class="collapse navbar-collapse  justify-content-end" id="navbarNavDropdown">
                                    <ul class="navbar-nav">
                                        <li class="nav-item active mr-2">
                                            <a class="nav-link" href="/">Главная<span class="sr-only">(current)</span></a>
                                        </li>
                                        <li class="nav-item dropdown mr-2">
                                            <a class="nav-link dropdown-toggle" href="/banki/banki-ukrainy"  id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Банки</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink1">
                                                <a class="dropdown-item" href="/banki/banki-ukrainy">Банки Украины</a>
                                                <a class="dropdown-item" href="/banki/otzyvy-o-bankakh">Отзывы о банках</a>
                                                <a class="dropdown-item" href="/banki/rejting-bankov-ukraini">Рейтинги банков</a>                        
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="/banki/rejting-bankov-ukraini/rejting-bankov-nbu">Рейтинг НБУ</a>
                                                <a class="dropdown-item" href="/banki/rejting-bankov-ukraini/rejting-bankov-aub">Рейтинг АУБ</a>
                                            </div>
                                        </li>
                                        <li class="nav-item dropdown mr-2">
                                            <a class="nav-link dropdown-toggle" href="/banki/banki-ukrainy"  id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Кредиты</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink2">
                                                <a class="dropdown-item" href="/kredity/kredit-nalichnymi">Кредит наличными</a>
                                                <a class="dropdown-item" href="/kredity/kreditnie-karty">Кредитные карты</a>
                                                <!--a class="dropdown-item" href="#">Авто в кредит</a>
                                                <a class="dropdown-item" href="#">Ипотека</a-->
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="/kredity/kreditnyj-kalkulyator">Кредитный калькулятор</a>
                                                <a class="dropdown-item" href="/kredity/effektivnaya-stavka-po-kreditu">Эффективная ставка</a>
                                            </div>
                                        </li>
                                        <li class="nav-item dropdown mr-2">
                                            <a class="nav-link dropdown-toggle" href="/banki/banki-ukrainy"  id="navbarDropdownMenuLink3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Депозиты</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink3">
                                                <a class="dropdown-item" href="/depozity/depozity">Депозит</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="/depozity/depozitnyj-kalkulyator">Депозитный калькулятор</a>
                                            </div>
                                        </li>
                                        <li class="nav-item dropdown mr-2">
                                            <a class="nav-link dropdown-toggle" href="/banki/banki-ukrainy"  id="navbarDropdownMenuLink4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Валюта</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink4">
                                                <a class="dropdown-item" href="/kursy-valyut/kurs-nalichnoj-valyuty">Курс наличной валюты</a>
                                                <a class="dropdown-item" href="/kursy-valyut/kurs-valyut-nbu">Курс валют НБУ</a>
                                                <a class="dropdown-item" href="/kursy-valyut/kurs-bankovskikh-metallov">Курс банковских металлов</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="/kursy-valyut/konverter-valyut">Конвертр валют</a>
                                            </div>
                                        </li>
                                        <li class="nav-item dropdown mr-2">
                                            <a class="nav-link dropdown-toggle" href="/banki/banki-ukrainy"  id="navbarDropdownMenuLink5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Справочник</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink5">
                                                <a class="dropdown-item" href="/spravochnik/bankovskie-terminy">Банковские термины</a>
                                                <a class="dropdown-item" href="/spravochnik/indeks-inflyatsii">Индекс инфляции</a>
                                                <a class="dropdown-item" href="/spravochnik/zolotovalyutnye-rezervy">Золотовалютные резервы</a>
                                                <a class="dropdown-item" href="/spravochnik/valovoj-vnutrennij-produkt">ВВП</a>
                                                <a class="dropdown-item" href="/spravochnik/vneshnij-dolg">Внешний долг</a>
                                                <a class="dropdown-item" href="/spravochnik/inostrannye-investitsii">Иностранные нвестиции</a>
                                                <!--a class="dropdown-item" href="#">Учетная ставка</a-->
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

        </header>
        <section class="content">
            <div class="blog-header" id="<?php echo $content['slug'] . '-' . $content['id']; ?>">
                <div id="header_title" style="background: rgba(255, 255, 255, 0.32)">
                    <h1 class="blog-title"><?php echo $content['title']; ?></h1>
                    <?php if (isset($content['sub_title'])): ?>
                        <p class="lead blog-description"><?php echo $content['sub_title']; ?></p>
                    <?php endif; ?>
                </div>
            </div>


            <div id="slider">
                <h1>Инсайдер - все о банках</h1>
                <ul class="bxslider">
                    <li>Информация о банках Украины</li>
                    <li>Курсы валют</li>
                    <li>Рейтинги банков</li>
                    <li>Кредиты, депозиты, банковские карты</li>
                </ul>
            </div>
        </section>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    Copyright <?php echo Date('Y'); ?>
                </div>
            </div>
        </footer>

        <script type="text/javascript">
            var page_name = "<?php echo $content['slug']; ?>";
        </script>

        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-37596035-1']);
            _gaq.push(['_trackPageview']);
            setTimeout("_gaq.push(['_trackEvent', '15_seconds', 'read'])", 15000);

            (function () {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = '/views/js/external/dc.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();

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
        <?php endif; ?>

        <?php if ($content['category'] == 'kursy-valyut'): ?>
            <!--data table-->
            <link href="/views/css/jquery.dataTables.min.css" rel="stylesheet">
            <script src="/views/js/jquery.dataTables.min.js"></script>
        <?php endif; ?>

        <script src="/views/js/scripts.js"></script>

    </body>
</html>