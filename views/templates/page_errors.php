<?php include ROOT . '/views/templates/header.php'; ?>

<div class="container blog-content">
    <div class="row">               
        <div class="col-12">

            <div class="blog-post">
			<div class="alert alert-danger" role="alert"><strong>Ошибка </strong> <?php echo http_response_code(); ?></div>
                <a href="/" type="button" class="btn btn-primary btn-lg btn-block">На главную</a>
            </div>

        </div>
    </div>

    <?php include ROOT . '/views/templates/footer.php'; ?>