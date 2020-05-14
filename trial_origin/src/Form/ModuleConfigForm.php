<?php

namespace Drupal\trial\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures forms module settings.
 */
class ModuleConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'trial_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'trial.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('trial.settings');
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('title'),
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#rows' => 4,
      '#cols' => 5,
      '#resizable' => TRUE,
      '#default_value' => $config->get('description'),
    ];

    $form['image'] = [
      '#type' => 'managed_file',
      '#title' => 'Image',
      '#name' => 'my_custom_file',
      '#description' => $this->t('Image to Upload'),
      '#default_value' => $config->get('image'),
      '#upload_location' => 'public://profile-pictures',
      '#upload_validators' => array(
          'file_validate_extensions' => array('gif png jpg jpeg'),
          // 'file_validate_size' => array(25600000),
      ),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    parent::validateForm($form, $form_state);
    $values = $form_state->getValues();
    $desc = explode(" ", $values['description']);
    // Check If title fieldis not empty.
    if ($values['title'] == '') {
      $form_state->setErrorByName('title', $this->t('Cannot Leave Empty'));
    }
    // Check the word length of description field.
    elseif (!isset($desc[9])) {
      $form_state->setErrorByName('description', $this->t('Description must be of atleast 10 words'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('trial.settings')
      ->set('title', $form_state->getValue('title'))
      ->set('description', $form_state->getValue('description'))
      ->set('image', $form_state->getValue('image'))
      ->save();
    parent::submitForm($form, $form_state);
    // kint($config);
    // drupal_set_message($config->get('title'));
    // drupal_set_message($config->get('description'));
    // drupal_set_message($config->get('image[0]'));
  }

}

?>
