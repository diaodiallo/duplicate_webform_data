<?php
/**
 * Created by PhpStorm.
 * User: ddiallo
 * Date: 2/12/20
 * Time: 1:28 PM
 */

namespace Drupal\duplicate_webform_data\Form;

use \Drupal\Core\Form\ConfigFormBase;
use \Drupal\Core\Form\FormStateInterface;

class DuplicateWebformDataSettingForm extends configFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'duplicate_webform_data_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['duplicate_webform_data.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('duplicate_webform_data.settings');

    $form['duplicate_webform_data_settings'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Duplicate webform data settings'),
    ];

    $form['duplicate_webform_data_settings']['webform_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter the webform id to use'),
      '#size' => 50,
      '#maxlength' => 50,
      '#default_value' => $config->get('webform_id'),
      '#required' => TRUE,
    ];

    $form['duplicate_webform_data_settings']['tids'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter IT tids to duplicate'),
      '#description' => $this->t('Use coma to separate them i.e: 1,2,3'),
      '#size' => 100,
      '#maxlength' => 100,
      '#default_value' => $config->get('tids'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);

  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::service('config.factory')
      ->getEditable('duplicate_webform_data.settings');
    $config->set('webform_id', $form_state->getValue('webform_id'));
    $config->set('tids', $form_state->getValue('tids'));
    $config->save();

    parent::submitForm($form, $form_state);
  }
}