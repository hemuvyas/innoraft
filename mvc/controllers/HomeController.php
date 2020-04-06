<?php

/**
 * @file
 * This is the controller of home file.
 */
namespace Controller;

use Model\HomeModel;
use View\HomeView;
/**
 * Class for home page model and it's view.
 */
class HomeController {

  /**
   * Display home page by getting proper data and its view.
   * @return mixed
   *  Renders the home page.
   */
  function home() {
    $model = new HomeModel();
    $res = $model->data();
    $view = new HomeView();
    $view->display($res);
  }
}
?>
