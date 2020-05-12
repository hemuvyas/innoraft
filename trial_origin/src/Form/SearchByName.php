<?php

/**
 * @file
 * Contains Drupal\trial\Form\SearchByName
 */
namespace Drupal\trial\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Class to display search form on top of the movie list page.
 */
class SearchByName extends FormBase {

  /**
   * Returns the unique form id.
   *
   * @return String
   *  Unique form id for this form.
   */
  public function getFormId() {
    return 'search_form';
  }

  /**
   *
   * @inheritdoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['search'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search'),
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    // $form['#theme'] = 'trial_filter';

    return $form;
  }

  /**
   * When form submitted, returns the search bar value to the url as query param.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $input = $form_state->getUserInput();
    $key = $input['search'];
    $url = Url::fromRoute('trial_movie', [], ['query' => ['word' => $key]]);
    $form_state->setRedirectUrl($url);
  }
}
?>
