<?php

class BanksRating extends Front {

    public static function bankFinRez($bank_id) {
        $bank_data = Bank::getBankData($bank_id);
        $bank_name = $bank_data['title'];

        $indicators = [
            'Активы' => 'aktivi',
            'Собственный капитал' => 'kapital',
            'Обязательства' => 'ob',
            'Прибыль/убыток' => 'finrez'
        ];

        $date = self::getLatestFile('nbu', 'aktivi', true);

        $finrez = '';
        foreach ($indicators as $key => $indicator) {
            $latest_file = self::getLatestFile('nbu', $indicator);
            $all_data = FrontController::parseCSVTable($latest_file['filename']);
            foreach ($all_data as $bank_data) {
                if ($bank_data["Банк"] == $bank_name) {
                    $finrez[$key] = $bank_data;
                    $finrez[$key]['date'] = $date;
                    break;
                }
            }
        }
        return $finrez;
    }

    public static function getLatestFile($rating = 'nbu', $indicator = 'aktivi', $return_date = false) {
        if ($rating == 'nbu')
            $dir = 'data/raiting_nbu/';
        else if ($rating == 'aub')
            $dir = 'data/raiting_aub/';

        $files = array_diff(scandir($dir), ['..', '.']);

        foreach ($files as $file) {
            $file = substr($file, 0, strpos($file, "."));
            $matches[] = explode('_', $file);
        }

        foreach ($matches as $matche) {
            $tmp['year'][] = $matche[2];
            $tmp['date'][] = $matche[1];
        }

        $max['year'] = max($tmp['year']);
        $max['date'] = max($tmp['date']);

        if ($return_date)
            return self::fileName($indicator, $max['date'], $max['year'], true);

        $filename = $indicator . '_' . $max['date'] . '_' . $max['year'] . '.csv';

        $out['filename'] = $dir . $filename;
        $out['header'] = self::fileName($indicator, $max['date'], $max['year']);

        return $out;
    }

    public static function fileName($indicator, $quarter, $year, $return_date = false) {
        $tmp_arr = [
            'aktivi' => 'Активы',
            'kapital' => 'Собственный капитал',
            'ob' => 'Обязательства',
            'finrez' => 'Финансовый результат'
        ];

        $tmp_arr2 = [
            1 => '31.03.',
            2 => '31.06.',
            3 => '31.09.',
            4 => '31.12.'
        ];

        if ($return_date)
            return $tmp_arr2[$quarter] . $year;

        $header = $tmp_arr[$indicator] . ' состоянием на ' . $tmp_arr2[$quarter] . $year . ' (тыс. грн.)';

        return $header;
    }

    public static function updateTop10Data() {
        $indicators = [
            'aktivi' => 'Всего активов',
            'kapital' => 'Всего собственного капитала',
            'ob' => 'Депозиты физических лиц',
            'finrez' => 'Всего Прибыль/убыток'
        ];

        $date = self::getLatestFile('nbu', 'aktivi', true);
        
        $table_names = [
            'Всего активов' => 'ТОП 10 банков по размеру активов на ' . $date . ', тыс. грн.',
            'Депозиты физических лиц' => 'ТОП 10 банков по размеру депозитного портфеля физических лиц на ' . $date . ', тыс. грн.',
            'Всего собственного капитала' => 'ТОП 10 банков по размеру собственного капитала на ' . $date . ', тыс. грн.',
            'Всего Прибыль/убыток' => 'ТОП 10 банков по размеру прибыли на ' . $date . ', тыс. грн.',
            //'Всего Прибыль/убыток' => 'ТОП 10 банков по размеру убытков',
        ];
        
        $exceptions = self::tableAttributes()['strong'];
        
        foreach ($indicators as $key => $indicator) {
            $file = self::getLatestFile('nbu', $key);
            $table = FrontController::parseCSVTable($file['filename']);

            foreach ($table as $value) {
                if($value["Банк"] === "ИТОГО")
                    $total = (float) $value[$indicators[$key]];
                
                if (empty($value[$indicators[$key]]) || in_array($value["Банк"], $exceptions))
                    continue;
                
                $arr[$table_names[$indicator]][$value["Банк"]] = (float) $value[$indicators[$key]];
            }
            
            unset($arr[$table_names[$indicator]]["Итого по банкам  иностранных банковских групп"]);
            
            if($key == 'finrez'){
                asort($arr[$table_names[$indicator]]);                
                $arr['ТОП 10 банков по размеру убытков на ' . $date . ', тыс. грн.'] = array_slice($arr[$table_names[$indicator]], 0, 10);
                //$summ_top_10 = array_sum($arr['ТОП 10 банков по размеру убытков на ' . $date . ', тыс. грн.']);
                //$summ_other = $total - $summ_top_10;
                //$arr['ТОП 10 банков по размеру убытков на ' . $date . ', тыс. грн.']['Остальные банки'] = $summ_other;
            }
            arsort($arr[$table_names[$indicator]]);
            $arr[$table_names[$indicator]] = array_slice($arr[$table_names[$indicator]], 0, 10);
            
            if($key == 'finrez')
                continue;
            
            $summ_top_10 = array_sum($arr[$table_names[$indicator]]);
            $summ_other = $total - $summ_top_10;
            $arr[$table_names[$indicator]]['Остальные банки'] = $summ_other;
        }
        
        $table_data = json_encode($arr);
        
        return Front::updateContent('banks_rating', 2, null, 'rejting-bankov-ukraini', null, null, null, null, null, $table_data);
    }

    public static function buildTop10Table($table, $inquiry){
        $date = self::getLatestFile('nbu', 'aktivi', true);
        $table_names = [
            'aktivi' => 'ТОП 10 банков по размеру активов на ' . $date . ', тыс. грн.',
            'dfl' => 'ТОП 10 банков по размеру депозитного портфеля физических лиц на ' . $date . ', тыс. грн.',
            'sk' => 'ТОП 10 банков по размеру собственного капитала на ' . $date . ', тыс. грн.',
            'profit' => 'ТОП 10 банков по размеру прибыли на ' . $date . ', тыс. грн.',
            'loss' => 'ТОП 10 банков по размеру убытков на ' . $date . ', тыс. грн.',
        ];
        
        $table_rez = '<h3>' . $table_names[$inquiry] . '</h3>'
                . '<table class="table table-bordered table-hover">'
                . '<tbody>';
        
        foreach ($table[$table_names[$inquiry]] as $key => $value){
            $table_rez .= '<tr>';
            $table_rez .= '<td><strong>' . $key . '</strong></td><td>' . number_format($value, 0, '.', ' ') . '</td>';
            $table_rez .= '</tr>';            
        }
        
        $table_rez .= '</tbody></table>';
        
        return $table_rez;
    }

    public static function chartData($table, $inquiry){
        $date = self::getLatestFile('nbu', 'aktivi', true);
        $table_names = [
            'aktivi' => 'ТОП 10 банков по размеру активов на ' . $date . ', тыс. грн.',
            'dfl' => 'ТОП 10 банков по размеру депозитного портфеля физических лиц на ' . $date . ', тыс. грн.',
            'sk' => 'ТОП 10 банков по размеру собственного капитала на ' . $date . ', тыс. грн.',
            'profit' => 'ТОП 10 банков по размеру прибыли на ' . $date . ', тыс. грн.',
            'loss' => 'ТОП 10 банков по размеру убытков на ' . $date . ', тыс. грн.',
        ];
        
        $table_ = [];
        $table_['cols'] = [
            ['label' => 'Банк', 'type' => 'string'],
            ['label' => 'Показатель', 'type' => 'number'],
        ];
        
        foreach ($table[$table_names[$inquiry]] as $key => $value) {
            $temp = array();
            $temp[] = array('v' => $key);
            $temp[] = array('v' => $value);
            $rows[] = array('c' => $temp);
        }
        
        $table_['rows'] = $rows;

        return json_encode($table_);
    }

    public static function tableAttributes() {
        return
                [
                    'strong' => [
                        "Банки с государственной долей",
                        "Итого по банкам с государственной долей",
                        "Банки иностранных банковских групп",
                        "Итого по банкам иностранных банковских групп",
                        "Банки с приватным капиталом",
                        "Итого по платежеспособным банкам",
                        "Итого по банкам с приватным капиталом",
                        "Неплатежеспособные банки",
                        "Итого по неплатежеспособным банкам",
                        "ИТОГО",
                    ],
                    'colspan' => [
                        "Банки с государственной долей",
                        "Банки иностранных банковских групп",
                        "Банки с приватным капиталом",
                        "Неплатежеспособные банки"
                    ]
        ];
    }

}
