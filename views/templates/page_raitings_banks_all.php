<?php include ROOT . '/views/templates/header.php'; ?>

<?php echo $content['text']; ?>           

<script type="text/javascript">
    var chart_aktiv = <?php echo $chart_aktiv; ?>;
    var chart_dfl = <?php echo $chart_dfl; ?>;
</script>

<?php include ROOT . '/views/templates/footer.php'; ?>