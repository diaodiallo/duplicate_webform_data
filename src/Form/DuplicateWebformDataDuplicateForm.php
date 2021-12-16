<?php
/**
 * Created by PhpStorm.
 * User: ddiallo
 * Date: 2/13/20
 * Time: 5:14 PM
 */

namespace Drupal\duplicate_webform_data\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\duplicate_webform_data\DuplicateWebformDataService;
use Drupal\duplicate_webform_data\Util\DuplicateWebformDataUtility;


class DuplicateWebformDataDuplicateForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return "duplicate_webform_data_duplicate";
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['header']['#markup'] = t('Duplicating webform data');

    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a button to lunch duplication process.
    $form['actions']['duplicate'] = [
      '#type' => 'submit',
      '#value' => $this->t('Run duplication'),
    ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $config = \Drupal::service('config.factory')
      ->getEditable('duplicate_webform_data.settings');
    $duplicateWebformDataService = new DuplicateWebformDataService();
    $duplicateWebformDataUtility = new DuplicateWebformDataUtility();
    $number = 0;
    $webform_id = $config->get('webform_id');
    $tids = $config->get('tids');
    $tidsArray = $duplicateWebformDataUtility->splitTids($tids);
    foreach ($tidsArray as $tid) {
      $number = $number + $duplicateWebformDataService->duplicateData($webform_id, $tid);
    }

    $messenger = \Drupal::messenger();
    $messenger->addMessage('Number of duplication: ' . $number);
    \Drupal::logger('duplicate_webform_data')
      ->info($number . 'webform submission have been duplicated.');
    $form_state->setRedirect('duplicate_webform_data.settings');
  }

}