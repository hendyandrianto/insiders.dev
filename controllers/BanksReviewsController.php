<?php

class BanksReviewsController extends FrontController {

    public function __construct() {
        parent::__construct();
        $this->table = 'bank_reviews';
    }

    public function actionContent() {
        $content = BanksReviews::getContent('otzyvy-o-bankakh', $this->table, '');
        $reviews_list = BanksReviews::getList($this->table, ' category = "otzyvy-o-bankakh"', 'date_add', 'DESC');
        foreach ($reviews_list as $key => $list){
            $bank_data = Bank::getBankData ($list['bank']);
            $reviews_list[$key]['bank_name'] = $bank_data['title'];
            $reviews_list[$key]['bank_link'] = $bank_data['slug'];
        }
        
        $banks_list = Bank::getBanksList();
        require_once(ROOT . '/views/templates/page_banks_reviews.php');

        return true;
    }

    public function actionView($slug){
        $content = Credit::getContent($slug, $this->table);
        $rating_bank = BanksReviews::getRatingData($content['bank']);
        $bank_data = Bank::getBankData ($content['bank']);
        require_once(ROOT . '/views/templates/page_review.php');
        return TRUE;
    }

    public function actionReview() {
        $title = $_POST['subject'];
        $bank = $_POST['bank'];
        $name = $_POST['name'];
        $text = $_POST['review'];
        if(isset($_POST['rating']))
            $rating = $_POST['rating'];
        else
            $rating = 0;

        if (BanksReviews::insertReview($title, $bank, $name, $text, $rating))
            die('<div class="alert alert-success" role="alert">Ваш отзыв успешно добавлен</div>');
        else
            die('<div class="alert alert-danger" role="alert">Возникла ошибка. Попробуйте позже</div>');
    }

}
