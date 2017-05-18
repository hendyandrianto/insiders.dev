<?php

class Currency extends Front {
/*
    public static function getContent($slug, $table, $where) {
        return parent::getContent($slug, $table, $where);
    }
*/
    public static function tableNBU($json_table) {
        $table = json_decode($json_table, true);

        $date = $table['@attributes']['OfficialDate'];

        $curr_arr = ['CHF', 'GBP', 'RUB', 'EUR', 'USD'];

        $h2_1 = '<h2>Курс НБУ основных валют на ' . date('d.m.Y', strtotime($date)) . '</h2>';
        $h2_2 = '<h2>Курс остальных валют на ' . date('d.m.Y', strtotime($date)) . '</h2>';

        $table_begin = '<table class="table table-hover table-responsive display">'
                . '<thead><tr>'
                . '<th>Код валюты</th><th>Название</th><th>Курс</th><th>Прирост</th>'
                . '</tr></thead>'
                . '<tbody>';

        $table_body_1 = $table_body_2 = '';

        foreach ($table['Currency'] as $row) {
            $class = (float) $row['ChangeAbs'] >= 0 ? 'class="green"' : 'class="red"';

            if (in_array($row['Code'], $curr_arr)) {
                $table_body_1 .= '<tr>';
                $table_body_1 .= '<td>' . $row['Code'] . '</td>';
                $table_body_1 .= '<td><strong>' . $row['Name'] . '</strong></td>';
                $table_body_1 .= '<td><strong>' . $row['Rate'] . '</strong></td>';
                $table_body_1 .= '<td ' . $class . ' >' . $row['ChangeAbs'] . '</td>';
                $table_body_1 .= '</tr>';
            } else {
                $table_body_2 .= '<tr>';
                $table_body_2 .= '<td>' . $row['Code'] . '</td>';
                $table_body_2 .= '<td><strong>' . $row['Name'] . '</strong></td>';
                $table_body_2 .= '<td><strong>' . $row['Rate'] . '</strong></td>';
                $table_body_2 .= '<td ' . $class . ' >' . $row['ChangeAbs'] . '</td>';
                $table_body_2 .= '</tr>';
            }
        }

        $table_end = '</tbody></table>';

        $output = $h2_1 . $table_begin . $table_body_1 . $table_end;
        $output .= $h2_2 . $table_begin . $table_body_2 . $table_end;

        return $output;
    }

    public static function dashboardNBU($slug) {
        $data = self::getDataFromBD($slug);

        $curr_arr = ['CHF', 'GBP', 'RUB', 'EUR', 'USD'];
        
        $table = array();
        $table['cols'] = array(
            array('label' => 'Дата', 'type' => 'date'),
            array('label' => 'Валюта', 'type' => 'string'),
            array('label' => 'Курс', 'type' => 'number'),
        );
        
        foreach ($data as $value) {
            $table_data = json_decode($value['table_data'], true);

            foreach ($table_data['Currency'] as $value2) {
                if(!in_array($value2['Code'], $curr_arr))
                    continue;
                $temp = array();
                preg_match('/(\d{4})-(\d{2})-(\d{2})/',$value2['Date'], $match);
                $year = (int) $match[1];
                $month = (int) $match[2] - 1; // convert to zero-index to match javascript's dates
                $day = (int) $match[3];
                $temp[] = array('v' => "Date($year, $month, $day)");
                $temp[] = array('v' => $value2['Name']);
                $temp[] = array('v' => (float) $value2['Rate']);
                $rows[] = array('c' => $temp);
                $table['rows'] = $rows;
            }
                   }
                   return json_encode($table);
    }
    
    public static function tableMetall($json_table) {
        $table = json_decode($json_table, true);
        
        $date = $table["item"][0]["date"];
        
        $output = '<h2>Курс банковских металлов на ' . date('d.m.Y', strtotime($date)) . '</h2>';
        
        $output .= '<table class="table table-hover table-responsive display">'
                . '<thead><tr>'
                . '<th>Код</th><th>Количество унций</th><th>Название</th><th>Курс</th><th>Прирост</th>'
                . '</tr></thead>'
                . '<tbody>';
        
        foreach ($table["item"] as $item){
            $class = (float)$item["change"] >= 0 ? 'class="green"' : 'class="red"';
            
            $output .= '<tr>';
            $output .= '<td>' . $item["char3"] . '</td>';
            $output .= '<td>' . $item["size"] . '</td>';
            $output .= '<td><strong>' . $item["name"] . '</strong></td>';
            $output .= '<td><strong>' . number_format($item["rate"], 2, '.', ' ') . '</strong></td>';
            $output .= '<td ' . $class . '>' . number_format($item["change"], 2, '.', ' ') . '</td>';
            $output .= '</tr>';
        }
        $output .= '</tbody></table>';
        
        return $output;
    }

    public static function dashboardMetall($slug) {
        $data = self::getDataFromBD($slug);

        $table = array();
        
        $table['cols'] = array(
            array('label' => 'Дата', 'type' => 'date'),
            array('label' => 'Название металла', 'type' => 'string'),
            array('label' => 'Курс', 'type' => 'number'),
        );
        
        foreach ($data as $value) {
            $table_data = json_decode($value['table_data'], true);

            foreach ($table_data['item'] as $value2) {

                $temp = array();
                preg_match('/(\d{4})-(\d{2})-(\d{2})/',$value2['date'], $match);
                $year = (int) $match[1];
                $month = (int) $match[2] - 1; // convert to zero-index to match javascript's dates
                $day = (int) $match[3];
                $temp[] = array('v' => "Date($year, $month, $day)");
                $temp[] = array('v' => $value2['name']);
                $temp[] = array('v' => (float) $value2['rate']);
                $rows[] = array('c' => $temp);
                $table['rows'] = $rows;
            }
            
        }
        return json_encode($table);
    }
    
    public static function tableCache($json_table) {
        $table = json_decode($json_table, true);

        $tab_head = '<ul class="nav nav-tabs" role="tablist">';
        $table_tab = '';

        $currency_names = [
            'usd' => ['Доллар США', 'Доллара США'],
            'eur' => ['Евро', 'Евро'],
            'rub' => ['Российский рубль', 'рубля РФ'],
            'chf' => ['Швейцарский франк', 'швейцарского франка'],
            'gbp' => ['Английский фунт', 'английского фунта стерлингов'],
        ];

        $i = 0;
        foreach ($table as $key => $value) {
            $active = $i == 0 ? 'active' : '';

            $tab_head .= '<li class="nav-item"><a class="nav-link ' . $active . '" href="#' . $key . '" data-toggle="tab" role="tab">' . $currency_names[$key][0] . '</a></li>';

            $table_tab .= '<div class="tab-pane ' . $active . '" id="' . $key . '" role="tabpanel">'
                    . '<h2>Курс ' . $currency_names[$key][1] . ' (' . $key . ') ' . ' на ' . date('d.m.Y', strtotime($value[0]['@attributes']['CashDate'])) . '</h2>';
            $table_tab .= '<table class="table table-hover table-responsive display">';
            $table_tab .= '<thead><tr>'
                    . '<th>Банк</th><th>Покупка</th><th>Прирост</th><th>Продажа</th><th>Прирост</th>'
                    . '</tr></thead>'
                    . '<tbody>';
            foreach ($value[0]['Bank'] as $value2) {
                $class_ch_buy = (float) $value2['BuyChangeRel'] >= 0 ? 'class="green"' : 'class="red"';
                $class_ch_sell = (float) $value2['SaleChangeRel'] >= 0 ? 'class="green"' : 'class="red"';

                $table_tab .= '<tr>';
                $table_tab .= '<td>' . $value2['Name'] . '</td>';
                $table_tab .= '<td><strong>' . $value2['Buy'] . '</strong></td>';
                $table_tab .= '<td ' . $class_ch_buy . '>' . round($value2['BuyChangeRel'], 2) . '</td>';
                $table_tab .= '<td><strong>' . $value2['Sale'] . '</strong></td>';
                $table_tab .= '<td ' . $class_ch_sell . '>' . round($value2['SaleChangeRel'], 2) . '</td>';
                $table_tab .= '</tr>';
            }
            $table_tab .= '</tbody></table></div>';

            $i++;
        }
        $tab_head .= '</ul>';

        $output = $tab_head . '<div class="tab-content">' . $table_tab . '</div>';

        return $output;
    }

    public static function dashboardCache($slug) {
        $average_array = self::getAverageRate($slug);

        $table = array();
        $table['cols'] = array(
            array('label' => 'Дата', 'type' => 'date'),
            array('label' => 'Валюта', 'type' => 'string'),
            array('label' => 'Покупка', 'type' => 'number'),
            array('label' => 'Продажа', 'type' => 'number')
        );

        foreach ($average_array as $key => $value) {
            preg_match('/(\d{4})-(\d{2})-(\d{2})/', $key, $match);
            $year = (int) $match[1];
            $month = (int) $match[2] - 1; // convert to zero-index to match javascript's dates
            $day = (int) $match[3];

            foreach ($value as $key2 => $value2) {
                $temp = array();
                $temp[] = array('v' => "Date($year, $month, $day)");
                $temp[] = array('v' => $key2);
                $temp[] = array('v' => $value2['average_buy']);
                $temp[] = array('v' => $value2['average_sell']);
                $rows[] = array('c' => $temp);
                $table['rows'] = $rows;
            }
        }

        return json_encode($table);
    }

    private static function getAverageRate($slug, $cache = true) {
        $data = self::getDataFromBD($slug);

        foreach ($data as $value) {
            $rates_table = json_decode($value['table_data'], true);

            foreach ($rates_table as $rates) {
                $date = $rates[0]['@attributes']['CashDate'];
                $summ_buy = 0;
                $summ_sell = 0;
                $kol = 0;

                foreach ($rates[0]['Bank'] as $bank) {
                    $summ_buy += $bank['Buy'];
                    $summ_sell += $bank['Sale'];
                    $currency = $bank['Currency'];
                    $kol++;
                }

                $average_array[$date][$currency]['average_buy'] = $summ_buy / $kol;
                $average_array[$date][$currency]['average_sell'] = $summ_sell / $kol;
            }
        }
        return $average_array;
    }

    public static function dataConverterCache(){
        $data = self::getDataFromBD('kurs-nalichnoj-valyuty');
        $data = array_reverse($data);
        $data = $data[0]["table_data"];
        $data = json_decode($data, true);
        
        $currency_names = [
            'usd' => 'USD - Доллар США',
            'eur' => 'EUR - Евро',
            'rub' => 'RUB - Российский рубль',
            'chf' => 'CHF - Швейцарский франк',
            'gbp' => 'GBP - Английский фунт стерлингов',
        ];
        
        foreach ($data as $currecy){
            foreach ($currecy[0]["Bank"] as $bank){ 
                $arr['UAH - Украинская гривна'][$bank["Name"]]["Buy"] = '1';
                $arr['UAH - Украинская гривна'][$bank["Name"]]["Sale"] = '1';
                
                $name = $currency_names[$bank["Currency"]];
                $arr[$name][$bank["Name"]]["Buy"] = $bank["Buy"];
                $arr[$name][$bank["Name"]]["Sale"] = $bank["Sale"];                
            }            
        }
        
        return json_encode($arr);
    }
    
    public static function dataConverterNBU(){
        $data = self::getDataFromBD('kurs-valyut-nbu');
        $data = array_reverse($data);
        $data = $data[0]["table_data"];
        $data = json_decode($data, true);
        
        $arr['UAH - Украинская гривна'] = '1';
        foreach ($data["Currency"] as $currecy){
           $arr[$currecy["Code"]." - ".$currecy["Name"]] = $currecy["Rate"];
        }
        return json_encode($arr);
    }

    public static function getDataFromBD($slug) {
        $db = DB::getConnection();
        $sql = 'SELECT * FROM `currency_rate` WHERE `slug` = :slug ORDER BY  `date` ASC ';
        $result = $db->prepare($sql);
        $result->bindParam(':slug', $slug, PDO::PARAM_STR);
        $result->setFetchMode(PDO::FETCH_BOTH);
        $result->execute();
        return $result->fetchAll();
    }
/*
    public static function putDataInDB($files, $table, $curr_type) {
        return parent::parseXML($files, $table, $curr_type);
    }
*/
}
