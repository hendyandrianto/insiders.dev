<?php include ROOT . '/views/templates/header.php'; ?>

<?php echo $content['text']; ?>
<div id="calc">
    <form action="banks/raitings" method="post" answer="ratings">
        <div class="form-group row">
            <label for="indicator" class="col-4 col-form-label">Показатель</label>
            <div class="col-8">
                <select  class="form-control" id="indicator" name="indicator">
                    <option value="aktivi">Активы</option>
                    <option value="kapital">Собственный капитал</option>
                    <option value="ob">Обязательства</option>
                    <option value="finrez">Прибыли и убытки</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="year" class="col-4 col-form-label">Год</label>
            <div class="col-8">
                <select  class="form-control" id="year" name="year">
                    <option value="2016">2016</option>
                    <option value="2017">2017</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="quarter" class="col-4 col-form-label">Квартал</label>
            <div class="col-8">
                <select  class="form-control" id="quarter" name="quarter">
                    <option value="1">I</option>
                    <option value="2">II</option>
                    <option value="3">III</option>
                    <option value="4">IV</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Показать</button>
    </form>
</div>
<div id="table">
    <h2><?php echo $latest_file['header'] ?></h2>
    <table class="table table-bordered table-responsive">
        <thead>
            <tr>
                <?php $i = 0; ?>
                <?php foreach ($table[0] as $key => $value): ?>
                    <th class="text-center">
                        <?php echo $key; ?>
                    </th>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>        
            <?php foreach ($table as $index): ?>            
                <tr>
                    <?php foreach ($index as $key => $index2): ?>
                        <?php in_array($index2, $attributes['colspan']) != false ? $colspan = ' colspan="' . $i . '"' : $colspan = '' ?>                        
                        <td <?php echo $colspan; ?>>
                            <?php if (in_array($index2, $attributes['strong']) != false): ?><strong><?php endif; ?>
                                <?php echo $key == 'Банк' ? $index2 : number_format((float) $index2, 0, '.', ' '); ?>
                                <?php if (in_array($index2, $attributes['strong']) != false): ?></strong><?php endif; ?>
                        </td>  
                        <?php if (!empty($colspan)) {
                            $colspan = '';
                            break;
                        } ?>
    <?php endforeach; ?>     
                </tr>
<?php endforeach; ?>        
        </tbody>
    </table>
</div>

<?php include ROOT . '/views/templates/footer.php'; ?>