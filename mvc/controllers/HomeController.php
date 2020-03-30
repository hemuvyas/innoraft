<?php

/**
 * @file
 * This is the controller of home file.
 */

/**
 * Class for home page model and it's view.
 */
class HomeController {

  function __construct () {

  }

  /**
   * Display home page by getting proper data and its view.
   * @return mixed
   *  Renders the home page.
   */
  function home() {
    include ('model/homeModel.php');
    $model = new HomeModel();
    $res = $model->data();
    include ('view/homeView.php');
    $view = new HomeView();
    $view->display($res);
  }
}
?>
