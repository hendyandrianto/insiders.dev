<?php foreach ($list as $item): ?>
    <div class="row pt-3 pb-3 border-bottom" capital="<?php echo $item["table_data"]['Капитал'] ?>" problem="<?php echo $item["table_data"]['Статус'] ?>">
        <div class="col-12 col-md-4">
            <a href="<?php echo $item["category"] . '/' . $item["slug"]; ?>"><strong><?php echo $item["title"]; ?></strong></a>
        </div>
        <div class="col-12 col-md-4">
            <?php if (!empty($item["table_data"]['Статус'])): ?>
                <span class="badge badge-danger">
                    <?php echo $item["table_data"]['Статус'] ?>
                </span>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>