<?php include ROOT . '/views/templates/header.php'; ?>

<?php echo $content['text']; ?>

<?php if (isset($dashboard) || isset($chart)): ?>
    <script type="text/javascript">
        var dashboard_data = <?php echo $dashboard; ?>;
        var chart_data = <?php echo $chart ?>;
    </script>
<?php endif ?>
<?php if ($content['slug'] == 'inostrannye-investitsii'): ?>
    <script type="text/javascript">
        var structure_to = <?php echo $chart_structure_to; ?>;
        var structure_from = <?php echo $chart_structure_from; ?>;
    </script>
<?php endif; ?>


<?php include ROOT . '/views/templates/footer.php'; ?>