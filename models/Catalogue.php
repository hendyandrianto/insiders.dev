<?php

Class Catalogue extends Front {

    public static function tableAllZVR($json_table) {
        $table = json_decode($json_table, true);

        $tab_head = '<ul class="nav nav-tabs" role="tablist">';
        $table_tab = '';

        $i = 0;
        foreach (array_reverse($table, true) as $key => $value) {

            $active = $i == 0 ? 'active' : '';

            $tab_head .= '<li class="nav-item"><a class="nav-link ' . $active . '" href="#a' . $key . '" data-toggle="tab" role="tab">' . $key . '</a></li>';
            $table_tab .= '<div class="tab-pane ' . $active . '" id="a' . $key . '" role="tabpanel">'
                    . '<h2>Золотовалютный резерв (ЗВР) Украины и динамика его изменения в ' . $key . ' году</h2>';
            $table_tab .= '<table class="table table-hover table-responsive">';
            $table_tab .= '<thead><tr>'
                    . '<th>Дата</th><th>Размер, млрд. дол. США</th><th>Прирост, млрд. дол. США</th><th>Прирост, %</th>'
                    . '</tr></thead>'
                    . '<tbody>';
            foreach ($value as $key2 => $value2) {
                $class = ($value2[1] - (isset($temp) ? $temp : 0)) > 0 ? 'class="green"' : 'class="red"';

                $table_tab .= '<tr>';
                $table_tab .= '<td>' . $key2 . '</td>';
                $table_tab .= '<td>' . $value2[1] . '</td>';
                $table_tab .= '<td ' . $class . '>' . (isset($temp) ? round(($value2[1] - $temp), 2) : '') . '</td>';
                $table_tab .= '<td ' . $class . '>' . (isset($temp) ? round((($value2[1] - $temp) / $temp * 100), 2) : '') . '</td>';
                $table_tab .= '</tr>';

                $temp = $value2[1];
                //break;
            }
            unset($temp);
            $table_tab .= '</tbody></table></div>';

            $i++;

            if ($i == 10)
                break;
        }
        $tab_head .= '</ul>';

        $output = $tab_head . '<div class="tab-content">' . $table_tab . '</div>';

        return $output;
    }

    public static function tableYearZVR($json_table) {

        $table = json_decode($json_table);

        $output = '<h2>Размер Золотовалютных резервов Украины с 1993 года по ' . date('Y') . ' год выглядит следующим образом</h2>'
                . '<table class="table table-hover table-responsive">';
        $output .= '<thead><tr>'
                . '<th>Дата</th><th>Размер, млрд. дол. США</th><th>Прирост, млрд. дол. США</th><th>Прирост, %</th>'
                . '</tr></thead>'
                . '<tbody>';

        foreach ($table as $value) {
            foreach ($value as $key => $value2) {
                $class = ($value2[1] - (isset($temp) ? $temp : 0)) > 0 ? 'class="green"' : 'class="red"';
                $output .= '<tr>';
                $output .= '<td>' . $key . '</td>';
                $output .= '<td>' . $value2[1] . '</td>';
                $output .= '<td ' . $class . '>' . (isset($temp) ? ($value2[1] - $temp) : '') . '</td>';
                $output .= '<td ' . $class . '>' . (isset($temp) ? round((($value2[1] - $temp) / $temp * 100), 2) : '') . '</td>';
                $output .= '</tr>';
                $temp = $value2[1];
                break;
            }
        }

        $output .= '</tbody></table>';

        return $output;
    }

    public static function dashboardZVR($json_table, $all = false) {
        $table = json_decode($json_table, true);

        $table_ = array();
        $table_['cols'] = array(
            array('label' => 'Дата', 'type' => 'date'),
            array('label' => 'Золотовалютные резервы', 'type' => 'number'),
            array('label' => 'иностранная валюта в виде банкнот и монет или средства на счетах за рубежом', 'type' => 'number'),
            array('label' => 'резервная позиция в МВФ', 'type' => 'number'),
            array('label' => 'специальные права заимствования', 'type' => 'number'),
            array('label' => 'монетарное золото', 'type' => 'number'),
        );

        if ($all) {
            array_unshift($table_['cols'], array('label' => 'Год', 'type' => 'date'));
        }

        foreach ($table as $key_f => $dd) {
            if (count($dd) > 1 && $all)
                array_shift($dd);

            foreach ($dd as $key => $value) {
                $temp = array();
                preg_match('/(\d{2}).(\d{2}).(\d{4})/', $key, $match);
                $year = (int) $match[3];
                $month = (int) $match[2] - 1; // convert to zero-index to match javascript's dates
                $day = (int) $match[1];

                if ($all)
                    $temp[] = array('v' => $key_f);

                $temp[] = array('v' => "Date($year, $month, $day)");

                array_shift($value);

                if ($all) {
                    foreach ($value as $value2)
                        $temp[] = array('v' => $value2);
                } else {
                    $temp[] = array('v' => $value[0]);
                }
                $rows[] = array('c' => $temp);
                if (!$all)
                    break;
            }
        }
        $table_['rows'] = $rows;

        return json_encode($table_);
    }

    public static function summaryTableInfl($json_table) {
        $table = json_decode($json_table, true);

        $output = '<table class="table table-hover table-bordered table-responsive" id="table-inflyation"><thead><tr>'
                . '<th></th><th>Янв.</th><th>Фев.</th><th>Март</th><th>Апр.</th><th>Май</th><th>Июнь</th><th>Июль</th><th>Авг.</th><th>Сен.</th><th>Окт.</th><th>Ноя.</th><th>Дек.</th>'
                . '</tr></thead>'
                . '<tbody>';

        foreach ($table as $key => $value) {
            $output .= '<tr>';
            $output .= '<td><strong>' . $key . '</strong></td>';

            foreach ($value as $value2) {
                $output .= '<td>' . (isset($value2[2]) ? $value2[2] : '') . '</td>';
            }

            $output .= '</tr>';
        }

        $output .= '</tbody></table>';

        return $output;
    }

    public static function tableAllInfl($json_table) {
        $table = json_decode($json_table, true);

        $tab_head = '<ul class="nav nav-tabs" role="tablist">';
        $table_tab = '';

        $i = 0;
        foreach (array_reverse($table, true) as $key => $value) {

            $active = $i == 0 ? 'active' : '';

            $tab_head .= '<li class="nav-item"><a class="nav-link ' . $active . '" href="#a' . $key . '" data-toggle="tab" role="tab">' . $key . '</a></li>';
            $table_tab .= '<div class="tab-pane ' . $active . '" id="a' . $key . '" role="tabpanel">'
                    . '<h2>Индекс инфляции в Украине в ' . $key . ' году</h2>';
            $table_tab .= '<table class="table table-hover table-responsive">';
            $table_tab .= '<thead><tr>'
                    . '<th></th><th>К предыдущему месяцу</th><th>К декабрю предыдущего года</th><th>К соответствующему периоду (накопительным итогом)</th><th>К соответствующему месяцу предыдущего года</th>'
                    . '</tr></thead>'
                    . '<tbody>';
            foreach ($value as $key2 => $value2) {
                $table_tab .= '<tr>';
                $table_tab .= '<td>' . $value2[1] . '</td>';
                $table_tab .= '<td><strong>' . $value2[2] . '</strong></td>';
                $table_tab .= '<td>' . $value2[3] . '</td>';
                $table_tab .= '<td>' . $value2[4] . '</td>';
                $table_tab .= '<td>' . $value2[5] . '</td>';
                $table_tab .= '</tr>';
            }

            $table_tab .= '</tbody></table></div>';

            $i++;

            if ($i == 3)
                break;
        }
        $tab_head .= '</ul>';

        $output = $tab_head . '<div class="tab-content">' . $table_tab . '</div>';

        return $output;
    }

    public static function dashboardInfl($json_table, $cumulate) {
        $table = json_decode($json_table, true);

        $table_ = array();
        $table_['cols'] = array(
            array('label' => 'Дата', 'type' => 'date'),
            array('label' => 'Индекс инфляции', 'type' => 'number'),
        );

        if ($cumulate) {
            array_unshift($table_['cols'], array('label' => 'Год', 'type' => 'date'));
        }

        $i = 0;

        foreach ($table as $key_f => $dd) {
            foreach ($dd as $key => $value) {
                if (isset($value[2])) {
                    $temp = array();
                    preg_match('/(\d{2}).(\d{2}).(\d{4})/', $key, $match);
                    $year = (int) $match[3];
                    $month = (int) $match[2] - 1; // convert to zero-index to match javascript's dates
                    $day = (int) $match[1];

                    if ($cumulate)
                        $temp[] = array('v' => $key_f);

                    $temp[] = array('v' => "Date($year, $month, $day)");

                    if ($cumulate) {
                        $temp[] = array('v' => $value[2]);
                    } else {
                        if ($i == 0) {
                            $temp[] = array('v' => $value[2]);
                            $temp_cumul = $value[2];
                        } else {
                            $temp_cumul += ($value[2] - 100);
                            $temp[] = array('v' => $temp_cumul);
                        }
                    }

                    $i++;

                    $rows[] = array('c' => $temp);
                }
            }
        }
        $table_['rows'] = $rows;
        //var_dump($table_);
        return json_encode($table_);
    }

    public static function tableAllVVD($json_table) {
        $table = json_decode($json_table, true);

        $tab_head = '<ul class="nav nav-tabs" role="tablist">';
        $table_tab = '';

        $i = 0;
        foreach (array_reverse($table, true) as $key => $value) {

            $active = $i == 0 ? 'active' : '';

            $tab_head .= '<li class="nav-item"><a class="nav-link ' . $active . '" href="#a' . $key . '" data-toggle="tab" role="tab">' . $key . '</a></li>';
            $table_tab .= '<div class="tab-pane ' . $active . '" id="a' . $key . '" role="tabpanel">'
                    . '<h2>Внешний долг Украины и динамика его изменения в ' . $key . ' году</h2>';
            $table_tab .= '<table class="table table-hover">';
            $table_tab .= '<thead><tr>'
                    . '<th>Дата</th><th>Размер, млн. дол. США</th><th>Прирост, млн. дол. США</th><th>Прирост, %</th>'
                    . '</tr></thead>'
                    . '<tbody>';
            foreach ($value as $key2 => $value2) {
                $class = ($value2[1] - (isset($temp) ? $temp : 0)) > 0 ? 'class="red"' : 'class="green"';

                $table_tab .= '<tr>';
                $table_tab .= '<td>' . $key2 . '</td>';
                $table_tab .= '<td><strong>' . number_format($value2[1], 0, '.', ' ') . '</strong></td>';
                $table_tab .= '<td ' . $class . '>' . (isset($temp) ? number_format(($value2[1] - $temp), 2, '.', ' ') : '') . '</td>';
                $table_tab .= '<td ' . $class . '>' . (isset($temp) ? round((($value2[1] - $temp) / $temp * 100), 2) : '') . '</td>';
                $table_tab .= '</tr>';

                $temp = $value2[1];
                //break;
            }
            unset($temp);
            $table_tab .= '</tbody></table></div>';

            $i++;

            if ($i == 10)
                break;
        }
        $tab_head .= '</ul>';

        $output = $tab_head . '<div class="tab-content">' . $table_tab . '</div>';

        return $output;
    }

    public static function dashboardVVD($json_table) {

        $table = json_decode($json_table, true);

        $table_ = array();
        $table_['cols'] = array(
            array('label' => 'Год', 'type' => 'date'),
            array('label' => 'Дата', 'type' => 'date'),
            array('label' => 'Внешний долг (общий)', 'type' => 'number'),
            array('label' => 'Доллар США (доля в структуре долга)', 'type' => 'number'),
            array('label' => 'Евро (доля в структуре долга)', 'type' => 'number'),
            array('label' => 'СПЗ (доля в структуре долга)', 'type' => 'number'),
            array('label' => 'Рубль РФ (доля в структуре долга)', 'type' => 'number'),
            array('label' => 'Гривна (доля в структуре долга)', 'type' => 'number'),
            array('label' => 'Другие (доля в структуре долга)', 'type' => 'number'),
        );

        foreach ($table as $key_f => $dd) {
            if (count($dd) > 1)
                array_shift($dd);
			if(count($dd) == 1){		
				unset($dd);
				continue;
			}

            foreach ($dd as $key => $value) {
                $temp = array();
                preg_match('/(\d{2}).(\d{2}).(\d{4})/', $key, $match);
                $year = (int) $match[3];
                $month = (int) $match[2] - 1; // convert to zero-index to match javascript's dates
                $day = (int) $match[1];

                $temp[] = array('v' => $key_f);
                $temp[] = array('v' => "Date($year, $month, $day)");

                array_shift($value);

                if (isset($value[1])) {
                    $temp[] = array('v' => $value[0]);
                    $temp[] = array('v' => $value[0] * $value[1] / 100);
                    $temp[] = array('v' => $value[0] * $value[2] / 100);
                    $temp[] = array('v' => $value[0] * $value[3] / 100);
                    $temp[] = array('v' => $value[0] * $value[4] / 100);
                    $temp[] = array('v' => $value[0] * $value[5] / 100);
                    $temp[] = array('v' => $value[0] * $value[6] / 100);
                } else {
                    $temp[] = array('v' => $value[0]);
                }

                $rows[] = array('c' => $temp);
            }
        }
        $table_['rows'] = $rows;
        //var_dump($table_);
        return json_encode($table_);
    }

    public static function dashboardStuctureVVD($json_table) {

        $table = json_decode($json_table, true);

        $table_ = array();

        $table_['cols'] = array(
            array('label' => 'Структура', 'type' => 'string'),
            array('label' => 'Значение', 'type' => 'number'),
            array('label' => 'Дата', 'type' => 'string'),
        );

        foreach (array_reverse($table, true) as $key_f => $dd) {
			if (count($dd) > 1)
                array_shift($dd);
			if(count($dd) == 1){		
				unset($dd);
				continue;
			}

            foreach (array_reverse($dd, true) as $key => $value) {
                if (isset($value[2])) {
                    $temp_usd = array();
                    $temp_eur = array();
                    $temp_spz = array();
                    $temp_rub = array();
                    $temp_uah = array();
                    $temp_other = array();

                    $temp_usd[] = array('v' => 'Доллар США');
                    $temp_usd[] = array('v' => $value[2] * 100);
                    $temp_usd[] = array('v' => $key);

                    $temp_eur[] = array('v' => 'Евро');
                    $temp_eur[] = array('v' => $value[3] * 100);
                    $temp_eur[] = array('v' => $key);

                    $temp_spz[] = array('v' => 'СПЗ');
                    $temp_spz[] = array('v' => $value[4] * 100);
                    $temp_spz[] = array('v' => $key);

                    $temp_rub[] = array('v' => 'Рубль РФ');
                    $temp_rub[] = array('v' => $value[5] * 100);
                    $temp_rub[] = array('v' => $key);

                    $temp_uah[] = array('v' => 'Гривна');
                    $temp_uah[] = array('v' => $value[6] * 100);
                    $temp_uah[] = array('v' => $key);

                    $temp_other[] = array('v' => 'Прочее');
                    $temp_other[] = array('v' => $value[7] * 100);
                    $temp_other[] = array('v' => $key);

                    $rows[] = array('c' => $temp_usd);
                    $rows[] = array('c' => $temp_eur);
                    $rows[] = array('c' => $temp_spz);
                    $rows[] = array('c' => $temp_rub);
                    $rows[] = array('c' => $temp_uah);
                    $rows[] = array('c' => $temp_other);
                }
            }
        }
        $table_['rows'] = $rows;

        return json_encode($table_);
    }

    public static function tableAllPII($json_table) {
        $table = json_decode($json_table, true);

        $tab_head = '<ul class="nav nav-tabs" role="tablist">';
        $table_tab = '';

        $i = 0;
        foreach (array_reverse($table, true) as $key => $value) {

            $active = $i == 0 ? 'active' : '';

            $tab_head .= '<li class="nav-item"><a class="nav-link ' . $active . '" href="#a' . $key . '" data-toggle="tab" role="tab">' . $key . '</a></li>';
            $table_tab .= '<div class="tab-pane ' . $active . '" id="a' . $key . '" role="tabpanel">'
                    . '<h2>Прямые иностранные инвестиции (ПИИ) в Украине в ' . $key . ' году</h2>'
                    . '<p style="text-align:center">(в млн. долл. США, накопительным итогом)</p>';
            $table_tab .= '<table class="table table-hover">';
            $table_tab .= '<thead><tr>'
                    . '<th>Дата</th><th colspan="2">ПИИ в Украину</th><th colspan="2">ПИИ из Украины</th><th>Сальдо</th>'
                    . '</tr></thead>'
                    . '<tbody>';
            foreach ($value as $key2 => $value2) {

                $class = ($value2[1] - (isset($temp) ? $temp : 0)) > 0 ? 'class="green"' : 'class="red"';
                $class2 = ($value2[2] - (isset($temp2) ? $temp2 : 0)) > 0 ? 'class="green"' : 'class="red"';

                $table_tab .= '<tr>';
                $table_tab .= '<td>' . $key2 . '</td>';
                $table_tab .= '<td>' . number_format($value2[1], 1, '.', ' ') . '</td>';
                $table_tab .= '<td ' . $class . '>' . (isset($temp) ? round(($value2[1] - $temp), 2) : '') . '</td>';
                $table_tab .= '<td>' . number_format($value2[2], 1, '.', ' ') . '</td>';
                $table_tab .= '<td ' . $class2 . '>' . (isset($temp2) ? round(($value2[2] - $temp2), 2) : '') . '</td>';
                $table_tab .= '<td>' . number_format($value2[1] - $value2[2], 1, '.', ' ') . '</td>';
                $table_tab .= '</tr>';

                $temp = $value2[1];
                $temp2 = $value2[2];
            }
            unset($temp);
            unset($temp2);
            $table_tab .= '</tbody></table></div>';

            $i++;

            if ($i == 3)
                break;
        }
        $tab_head .= '</ul>';

        $output = $tab_head . '<div class="tab-content">' . $table_tab . '</div>';

        return $output;
    }

    public static function tableYearPII($json_table) {

        $table = json_decode($json_table, true);

        $output = '<table class="table table-hover table-responsive">';
        $output .= '<thead><tr>'
                . '<th>Дата</th>'
                . '<th>ПИИ в Украину</th>'
                . '<th colspan="2">Прирост</th>'
                . '<th>ПИИ из Украины</th>'
                . '<th colspan="2">Прирост</th>'
                . '<th>Сальдо</th>'
                . '</tr></thead>'
                . '<tbody>';

        foreach ($table as $key => $value) {
            if ($key == 'pii_to_ukraine' || $key == 'pii_from_ukraine')
                continue;

            if (count($value) > 1)
                $value = array_reverse($value);
            foreach ($value as $key => $value2) {
                $class = ($value2[1] - (isset($temp) ? $temp : 0)) > 0 ? 'class="green"' : 'class="red"';
                $class2 = ($value2[2] - (isset($temp2) ? $temp2 : 0)) > 0 ? 'class="green"' : 'class="red"';

                $output .= '<tr>';
                $output .= '<td>' . $key . '</td>';
                $output .= '<td><strong>' . number_format($value2[1], 2, '.', ' ') . '</strong></td>';
                $output .= '<td ' . $class . '>' . (isset($temp) ? number_format(($value2[1] - $temp), 1, '.', ' ') : '') . '</td>';
                $output .= '<td ' . $class . '>' . (isset($temp) ? number_format((($value2[1] - $temp) / $temp * 100), 1, '.', ' ') . '%' : '') . '</td>';
                $output .= '<td><strong>' . number_format($value2[2], 2, '.', ' ') . '</strong></td>';
                $output .= '<td ' . $class2 . '>' . (isset($temp2) ? number_format(($value2[2] - $temp2), 1, '.', ' ') : '') . '</td>';
                $output .= '<td ' . $class2 . '>' . (isset($temp2) ? number_format((($value2[2] - $temp2) / $temp2 * 100), 1, '.', ' ') . '%' : '') . '</td>';
                $output .= '<td><strong>' . number_format($value2[1] - $value2[2], 1, '.', ' ') . '</strong></td>';
                $output .= '</tr>';

                $temp = $value2[1];
                $temp2 = $value2[2];
                break;
            }
        }

        $output .= '</tbody></table>';

        return $output;
    }

    public static function dashboardPII($json_table, $all = false) {
        $table = json_decode($json_table, true);

        $table_ = array();
        $table_['cols'] = array(
            array('label' => 'Дата', 'type' => 'date'),
            array('label' => 'ПИИ в Украину, млн. долл. США', 'type' => 'number'),
            array('label' => 'ПИИ из Украины, млн. долл. США', 'type' => 'number'),
        );

        if ($all) {
            array_unshift($table_['cols'], array('label' => 'Год', 'type' => 'date'));
        }

        foreach ($table as $key_f => $dd) {
            if ($key_f == 'pii_to_ukraine' || $key_f == 'pii_from_ukraine')
                continue;

            if (count($dd) > 1 && $all)
                array_shift($dd);

            if (count($dd) > 1 && !$all)
                $dd = array_reverse($dd);

            if (count($dd) == 1 && $all)
                continue;

            foreach ($dd as $key => $value) {
                $temp = array();
                preg_match('/(\d{2}).(\d{2}).(\d{4})/', $key, $match);
                $year = (int) $match[3];
                $month = (int) $match[2] - 1; // convert to zero-index to match javascript's dates
                $day = (int) $match[1];

                if ($all)
                    $temp[] = array('v' => $key_f);

                $temp[] = array('v' => "Date($year, $month, $day)");

                array_shift($value);

                foreach ($value as $value2)
                    $temp[] = array('v' => $value2);

                $rows[] = array('c' => $temp);

                if (!$all)
                    break;
            }
        }
        $table_['rows'] = $rows;

        return json_encode($table_);
    }

    public static function dashboardStructurePII($json_table, $type) {
        $table = json_decode($json_table, true);

        $table_ = array();
        $table_['cols'] = array(
            array('label' => 'Страна', 'type' => 'string'),
            array('label' => 'Размер инвестиций', 'type' => 'number'),
        );

        if ($type === 'to')
            $data_array = $table['pii_to_ukraine'];
        else if ($type === 'from')
            $data_array = $table['pii_from_ukraine'];
        else
            return false;

        foreach ($data_array as $value) {
            $temp = array();
            $temp[] = array('v' => $value[0]);
            $temp[] = array('v' => $value[1]);
            $rows[] = array('c' => $temp);
        }

        $table_['rows'] = $rows;

        return json_encode($table_);
    }

    public static function tableAllVVP($json_table) {
        $table = json_decode($json_table, true);

        unset($table['VRP']);

        $tab_head = '<ul class="nav nav-tabs" role="tablist">';
        $table_tab = '';

        $i = 0;
        foreach (array_reverse($table, true) as $key => $value) {

            $active = $i == 0 ? 'active' : '';

            $tab_head .= '<li class="nav-item"><a class="nav-link ' . $active . '" href="#a' . $key . '" data-toggle="tab" role="tab">' . $key . '</a></li>';
            $table_tab .= '<div class="tab-pane ' . $active . '" id="a' . $key . '" role="tabpanel">'
                    . '<h2>Валовой внутренний продукт Украины в ' . $key . ' году  (млн. грн.)</h2>';
            $table_tab .= '<table class="table table-hover table-responsive">';
            $table_tab .= '<thead><tr>'
                    . '<th>Квартал</th><th>Номинальный ВВП</th><th>Реальный ВВП</th><th>разница ВВП (реальный - номинальный)</th>'
                    . '</tr></thead>'
                    . '<tbody>';
            foreach ($value as $key2 => $value2) {

                if (strripos((string) $key2, '01.01.') !== false)
                    $key2 = 'Итого';

                $class = ($value2[2] - $value2[1]) > 0 ? 'class="green"' : 'class="red"';

                $table_tab .= '<tr>';
                $table_tab .= '<td>' . $key2 . '</td>';
                $table_tab .= '<td><strong>' . number_format($value2[1], 0, '.', ' ') . '</strong></td>';
                $table_tab .= '<td><strong>' . number_format($value2[2], 0, '.', ' ') . '</strong></td>';
                $table_tab .= '<td ' . $class . '>' . number_format(($value2[2] - $value2[1]), 0, '.', ' ') . '</td>';
                $table_tab .= '</tr>';
            }

            $table_tab .= '</tbody></table></div>';

            $i++;

            if ($i == 4)
                break;
        }
        $tab_head .= '</ul>';

        $output = $tab_head . '<div class="tab-content">' . $table_tab . '</div>';

        return $output;
    }

    public static function tableYearVVP($json_table) {
        $table = json_decode($json_table, true);
        unset($table['VRP']);

        $output = '<table class="table table-hover table-responsive">';
        $output .= '<thead><tr>'
                . '<th>Дата</th><th>ВВП (млн. грн.)</th><th>ВВП (млн. долл. США)</th><th>ВВП в расчете на одного человека (грн.)</th><th>Прирост ВВП (млн. грн.)</th>'
                . '</tr></thead>'
                . '<tbody>';

        foreach ($table as $value) {
            if (count($value) > 1)
                $value = array_reverse($value);

            foreach ($value as $key => $value2) {
                if (strripos((string) $key, '01.01.') === false)
                    continue;

                $class = ($value2[1] - (isset($temp) ? $temp : 0)) > 0 ? 'class="green"' : 'class="red"';
                $output .= '<tr>';
                $output .= '<td>' . $key . '</td>';
                $output .= '<td><strong>' . number_format($value2[1], 0, '.', ' ') . '</strong></td>';
                $output .= '<td><strong>' . number_format($value2[3], 0, '.', ' ') . '</strong></td>';
                $output .= '<td><strong>' . ($value2[4] != '' ? number_format($value2[4], 0, '.', ' ') : '') . '</strong></td>';
                $output .= '<td ' . $class . '>' . (isset($temp) ? number_format(($value2[1] - $temp), 0, '.', ' ') : '') . '</td>';
                $output .= '</tr>';
                $temp = $value2[1];
                break;
            }
        }

        $output .= '</tbody></table>';

        return $output;
    }

    public static function tabledVRP($json_table) {
        $table = json_decode($json_table, true);

        $output = '<table id="vrp" class="table table-hover">';
        $output .= '<thead><tr>'
                . '<th>Область / город</th><th>ВРП (млн. грн.)</th><th>ВРП в расчете на одного человека (грн.)</th>'
                . '</tr></thead>'
                . '<tbody>';

        foreach ($table['VRP'] as $key => $value) {
            $output .= '<tr>';
            $output .= '<td>' . $key . '</td>';
            $output .= '<td>' . number_format($value[1], 0, '.', ' ') . '</td>';
            $output .= '<td>' . number_format($value[2], 0, '.', ' ') . '</td>';
            $output .= '</tr>';
        }
        $output .= '</tbody></table>';

        return $output;
    }

    public static function dashboardVVP($json_table, $all) {
        $table = json_decode($json_table, true);
        unset($table['VRP']);

        $table_ = array();

        if ($all) {
            $table_['cols'] = array(
                array('label' => 'Год', 'type' => 'date'),
                array('label' => 'Квартал', 'type' => 'string'),
                array('label' => 'Номинальный ВВП', 'type' => 'number'),
                array('label' => 'Реальный ВВП', 'type' => 'number'),
            );
            $table = array_reverse($table, true);
        } else {
            $table_['cols'] = array(
                array('label' => 'Дата', 'type' => 'date'),
                array('label' => 'Валюта', 'type' => 'string'),
                array('label' => 'ВВП', 'type' => 'number')
            );
        }

        foreach ($table as $key_f => $dd) {
            if (count($dd) == 1 && $all)
                continue;

            if (count($dd) > 1 && !$all)
                $dd = array_reverse($dd);

            $i = 0;
            foreach ($dd as $key => $value) {


                $temp = array();
                $temp_usd = array();
                $temp_uah = array();

                if ($all) {
                    $temp[] = array('v' => $key_f);
                    $temp[] = array('v' => $value[0] . ' квартал');
                    $temp[] = array('v' => $value[1]);
                    $temp[] = array('v' => $value[2]);
                    $rows[] = array('c' => $temp);
                } else {
                    if (!preg_match('/(\d{2}).(\d{2}).(\d{4})/', $key, $match))
                        continue;

                    $year = (int) $match[3];
                    $month = (int) $match[2] - 1; // convert to zero-index to match javascript's dates
                    $day = (int) $match[1];

                    $temp_usd[] = array('v' => "Date($year, $month, $day)");
                    $temp_usd[] = array('v' => 'Доллар США');
                    $temp_usd[] = array('v' => $value[3]);

                    $temp_uah[] = array('v' => "Date($year, $month, $day)");
                    $temp_uah[] = array('v' => 'Гривна');
                    $temp_uah[] = array('v' => $value[1]);

                    $rows[] = array('c' => $temp_uah);
                    $rows[] = array('c' => $temp_usd);
                }

                if (!$all)
                    break;

                $i++;
                if ($i == 4) {
                    break;
                }
            }
        }
        $table_['rows'] = $rows;

        return json_encode($table_);
    }

    public static function ratioVVPtoVVDdata() {
        $vvp_content = Catalogue::getContent('valovoj-vnutrennij-produkt', 'catalogue', '');
        $vvd_content = Catalogue::getContent('vneshnij-dolg', 'catalogue', '');

        $vvp_table = json_decode($vvp_content['table_data'], true);
        unset($vvp_table['VRP']);
        $vvd_table = json_decode($vvd_content['table_data'], true);

        foreach ($vvd_table as $key_vvd => $value_vvd) {
            foreach ($value_vvd as $value_vvd2) {
                $vvd_arr[$key_vvd][] = $value_vvd2[1];
                break;
            }
        }

        foreach ($vvp_table as $key_vvp => $value_vvp) {
            if ((int) $key_vvp < 2003)
                continue;

            if (count($value_vvp) > 1)
                $value_vvp = array_reverse($value_vvp);

            foreach ($value_vvp as $value_vvp2) {
                if ($value_vvp2[3] == '')
                    break;
                $vvp_arr[(int) $key_vvp + 1][] = $value_vvp2[3];
                break;
            }
        }

        $result = array();

        foreach ($vvp_arr as $key_vvp_r => $value_vvp_r)
            foreach ($vvd_arr as $key_vvd_r => $value_vvd_r)
                if ($key_vvd_r == $key_vvp_r) {
                    $result[$key_vvp_r][] = $value_vvp_r;
                    $result[$key_vvp_r][] = $value_vvd_r;
                }

        return $result;
    }

    public static function tableRatioVVP_VVD() {
        $table = Catalogue::ratioVVPtoVVDdata();

        $output = '<table id="vrp" class="table table-hover">';
        $output .= '<thead><tr>'
                . '<th>Дата</th><th>Валовой внешний долг</th><th>ВВП</th><th>Соотношение ВВП/ВВД</th>'
                . '</tr></thead>'
                . '<tbody>';

        foreach ($table as $key => $value) {

            $output .= '<tr>';
            $output .= '<td>' . '01.01.'. $key . '</td>';
            $output .= '<td>' . number_format($value[1][0], 0, '.', ' ') . '</td>';
            $output .= '<td>' . number_format($value[0][0], 0, '.', ' ') . '</td>';
            $output .= '<td><strong>' . number_format($value[1][0] / $value[0][0] * 100, 2, '.', ' ') . '%' . '</strong></td>';
            $output .= '</tr>';
        }
        $output .= '</tbody></table>';

        return $output;
    }
    
    // парсинг справичника (темп)
    public static function parseTermini(){
        $file = "content.csv";
        $data = FrontController::parseCSVTable($file);
        
        return $data;
    }

}
