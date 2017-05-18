<h2><?php echo $file_name?></h2>
<table class="table table-bordered">
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
                            <?php echo  $key == 'Банк' ? $index2 : number_format((float)$index2, 0, '.', ' '); ?>
                        <?php if (in_array($index2, $attributes['strong']) != false): ?></strong><?php endif; ?>
                    </td>  
                    <?php if (!empty($colspan)) {$colspan = ''; break;} ?>
                <?php endforeach; ?>     
            </tr>
        <?php endforeach; ?>        
    </tbody>
</table>