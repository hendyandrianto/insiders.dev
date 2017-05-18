<?php

class CreditController extends FrontController {

    public function __construct() {
        parent::__construct();
        $this->table = 'credit';
    }

    public function actionContent($slug) {
        $content = Credit::getContent($slug, $this->table, '');
        
        switch ($slug) {
            case "kreditnyj-kalkulyator":
                require_once(ROOT . '/views/templates/page_credit_calc.php');
                break;
            case "effektivnaya-stavka-po-kreditu":
                require_once(ROOT . '/views/templates/page_effective_rate.php');
                break;
            default: 
                $list = Credit::getList($this->table, ' category LIKE ' . '"' . $slug . '"');
                require_once(ROOT . '/views/templates/page_credits_view.php');
                break;
        }
        return true;
    }

    public function actionView($category, $slug) {
        $content = Credit::getContent($slug, $this->table, '');
        $credit_data = json_decode($content['table_data'], true);
        $img = $credit_data['Банк'];
        unset($credit_data['Банк']);
        require_once(ROOT . '/views/templates/page_credit.php');
        return true;
    }

    public function actionAjaxSendQuery() {
        $url = 'http://partner.finline.ua/api/applyWeb/v2/';

        $originalDate = $_POST["birthDate"];
        $newDate = date("d.m.Y", strtotime($originalDate));

        $params_post = [
            "employment" => $_POST["employment"],
            "firstName" => $_POST["firstName"],
            "identCode" => $_POST["identCode"],
            "lastName" => $_POST["lastName"],
            "phone" => $_POST["Phone"],
            "birthDate" => $newDate,
            "city" => $_POST["city"],
            "aim" => $_POST["aim"],
            "partner" => $_POST["partner"],
            "offerCode" => $_POST["offerCode"],
        ];

        if ($_POST["amount"] != '')
            $params_post["amount"] = $_POST["amount"];

        $curl = curl_init();
        $params = http_build_query($params_post);

        if ($curl) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
            $out = curl_exec($curl);
            curl_close($curl);
        }

        $curl_response = json_decode($out, true);

        $false_response = [
            'Empty offerCode' => 'Пустой параметр кода оффера',
            'Empty amount param' => 'Пустой параметр сумы кредита.',
            'No such offer code' => 'Не правильно указанный код оффера, или такого кода не существует.',
            'Empty phone param' => 'Пустой параметр телефона',
            'Empty FirstName param' => 'Пустой параметр имени',
            'Empty LastName param' => 'Пустой параметр фамилии',
            'Wrong amount param format' => 'Неверно указанный формат запрашиваемых денег на кредит',
            'Empty partner param' => 'Пустое поле партнёра',
            'Wrong partner format' => 'Неверный форма параметра партнёра',
            'No such partner' => 'Такого партнёра не существует',
            'Empty employment format' => 'Пустой параметр трудоустройства',
            'Wrong employment format' => 'Неверный формат трудоустройства',
            'Wrong birthDate format' => 'Неверный формат даты рождения',
        ];

        $customer_message = 'Заявка отправлена';
        if ($curl_response['result'] == 'false') {
            $customer_message = '<div class="alert alert-warning" role="alert">'
                    . '<p>Заявка не принята.</p>'
                    . '<p>Причина: <strong>' . $false_response[$curl_response['error']] . '</strong></p>'
                    . '<p>Исправте ошибку, и попробуйте оправить еще раз.</p>'
                    . '</div>';
        } else {
            if ($curl_response['state'] == 'reject') {
                $customer_message = '<div class="alert alert-danger" role="alert">'
                        . '<p>По вашей заявке отказано.</p>'
                        . '<p>Причина отказа: <strong>' . $curl_response['message'] . '</strong></p>'
                        . '</div>';
            } elseif ($curl_response['state'] == 'ok' || $curl_response['state'] == 'sink') {
                $customer_message = '<div class="alert alert-success" role="alert">'
                        . '<p>Заявка успешно отправлена. В ближайшее время с Вами свяжется менеджер банка.</p>'
                        . '</div>';
            }
        }

        //
        $headers = 'From: insiders <info@insiders.com.ua>' . "\r\n";
        $message = '';
        if (isset($curl_response)) {
            foreach ($curl_response as $key => $value) {
                $message .= $key . ": " . $value . "\r\n";
            }
        }else{
            $message .= 'no curl_response' . "\r\n";
        }
        $message .= 'Customer:' . "\r\n";
        foreach ($params_post as $key2 => $param) {
            $message .= $key2 . ": " . $param . "\r\n";
        }
        mail('lloonnyyaa@gmail.com', 'Заявка на кредит', $message . strip_tags($customer_message));

        die($customer_message);
    }

    /*
     * парсиг кредитов
     * пример ссылки http://new.insiders.com.ua/parsing/crediti?key=key
     */

    public function actionParsingCredit() {
        $dir = 'data/crediti/';
        return parent::actionParsings($dir, $this->table);
    }

}
