<?php

namespace Drupal\trial\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
// use Drupal\paragraphs\Entity\Paragraph;
// use Drupal\node\Entity\Node;
// use Drupal\Core\Link;
// use Drupal\trial\Controller\PhpController;


class SearchByName extends FormBase {

  public function getFormId() {
    return 'search_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    // $a = new PhpController;
    // $result = $a->movielist();
    $form['search'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    // $form['movie_result'] = [
    //   '#type' => 'item',
    //   '#value' => $result,
    // ];
    // if (empty($form_state->getValues('search'))) {
    //   $list = $form_state->getValues('movie_result');
    //   drupal_set_message($list);
    // }
    // else {
    //   drupal_set_message("not empty");
    // }
    // drupal_set_message($result);
    // $form['#theme'] = 'trial_filter';

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $input = $form_state->getUserInput();
    // drupal_set_message($input['search']);
    $key = $input['search'];
    $url = Url::fromRoute('trial_movie', [], ['query' => ['word' => $key]]);
    $form_state->setRedirectUrl($url);
    // $form_state->setRebuild();
    // $result = $form_state->getValues('movie_result');
    // foreach ($result as $value) {
    //   foreach ($value as $value1) {
    //     drupal_set_message($value1);
    //   }
    // }
    // drupal_set_message($result);
    // $obj = new PhpController;
    // $movie = $form_state->getValues('search');
    // if ($movie != ''){
    //   drupal_set_message($obj->movielist($movie));
    // }
    // $movie = 'Ram';
    // drupal_set_message($obj->movielist($movie));

  }

}
?>
