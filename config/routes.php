<?php

return array(
    //кеширование
    'build/cache'                               =>  ['class' => 'FrontController', 'method' => 'buildCache'],
    // карта сайта
    'build/sitemap'                             =>  ['class' => 'FrontController', 'method' => 'actionSitemap'],
    
    // загрузка внешних скриптов
    'download/external-js'			=>  ['class' => 'FrontController', 'method' => 'actionDownloadJS'],
    // parsing    
    'parsing/catalogue'                         =>  ['class' => 'CatalogueController', 'method' => 'actionParsing'],
    'parsing/currency'                          =>  ['class' => 'CurrencyController', 'method' => 'actionParsing'],
    'parsing/crediti'                           =>  ['class' => 'CreditController', 'method' => 'actionParsingCredit'],
    'parsing/banks'                             =>  ['class' => 'BankController', 'method' => 'actionParsingBanks'],   
    
    // ajax
    'currency/history'                          =>  ['class' => 'CurrencyController', 'method' => 'actionAjaxCurrency'],
    'credit/send'                               =>  ['class' => 'CreditController', 'method' => 'actionAjaxSendQuery'],
    'bank/review'                               =>  ['class' => 'BanksReviewsController', 'method' => 'actionReview'],
    'banks/raitings'                            =>  ['class' => 'BanksRatingController', 'method' => 'actionAjaxContent'],
    'catalogue/glossary'                        =>  ['class' => 'CatalogueController', 'method' => 'actionAjaxGlossary'],
    //все формы модулей
    'module-form/([A-z-]+)'                     =>  ['class' => 'ModuleController', 'method' => 'formsProcessing'],
    
    //удаление комментария
    'module/([A-z-]+)/([A-z-]+)/([0-9]+)'       =>  ['class' => 'ModuleController', 'method' => 'noAjaxRequest'],
    
    //динамическа подгрузка
    'dynamic/loading'                           =>  ['class' => 'FrontController', 'method' => 'dynamicLoadingContent'],
    
    'banki/rejting-bankov-ukraini/([A-z-0-9]+)' =>  ['class' => 'BanksRatingController', 'method' => 'actionView'],
    'banki/rejting-bankov-ukraini'              =>  ['class' => 'BanksRatingController', 'method' => 'actionContent'],
    'banki/otzyvy-o-bankakh/([A-z-0-9]+)'       =>  ['class' => 'BanksReviewsController', 'method' => 'actionView'],
    'banki/otzyvy-o-bankakh'                    =>  ['class' => 'BanksReviewsController', 'method' => 'actionContent'],    
    'banki/([A-z-]+)/([A-z-0-9]+)'              =>  ['class' => 'BankController', 'method' => 'actionView'],
    'banki/([A-z-]+)'                           =>  ['class' => 'BankController', 'method' => 'actionContent'],
    
    'kursy-valyut/([A-z-]+)'                    =>  ['class' => 'CurrencyController', 'method' => 'actionContent'],
    
    'spravochnik/bankovskie-terminy/([A-z-0-9]+)'  =>  ['class' => 'CatalogueController', 'method' => 'actionContent'],
    'spravochnik/bankovskie-terminy'            =>  ['class' => 'CatalogueController', 'method' => 'actionList'],
    'spravochnik/([A-z-]+)'                     =>  ['class' => 'CatalogueController', 'method' => 'actionContent'],
    
    'depozity/([A-z-]+)'                        =>  ['class' => 'DepositController', 'method' => 'actionContent'],
    
    'kredity/([A-z-]+)/([A-z-0-9]+)'            =>  ['class' => 'CreditController', 'method' => 'actionView'],    
    'kredity/([A-z-]+)'                         =>  ['class' => 'CreditController', 'method' => 'actionContent'],
     
//    ''                                          =>  ['class' => 'HomeController', 'method' => 'actionContent'],
    '/'                                         =>  ['class' => 'HomeController', 'method' => 'actionContent'],
);
