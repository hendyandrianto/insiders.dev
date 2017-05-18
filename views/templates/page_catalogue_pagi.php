<?php foreach ($list as $item): ?>
    <div class="row pt-3 pb-3 border-bottom">
        <div class="col-12">
            <a href="<?php echo $item["category"] . '/' . $item["slug"]; ?>"><strong><?php echo $item["title"]; ?></strong></a>
        </div>
    </div>
<?php endforeach; ?>