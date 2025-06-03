<?php

declare(strict_types=1);

namespace Drupal\drupalcamppl_2025\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Hard difficulty modal form.
 */
final class ImpossibleModalForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'dc_2025_impossible_modal_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['input'] = [
      '#title' => $this->t('Input'),
      '#type' => 'textfield',
    ];

    $form['actions'] = ['#type' => 'actions'];

    $form['actions']['submit_modal'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'url' => Url::fromRoute('lms.modal_subform_endpoint'),
        'callback' => [\get_class($this), 'ajaxSubmit'],
        'options' => [
          'query' => [
            'plugin_id' => 'simple_drupalcamp_subform',
            'rebuild_parent' => TRUE,
            'dialog_operation' => 'close',
          ] + $form_state->getBuildInfo()['query'],
        ],
      ],
    ];

    return $form;
  }

  /**
   * Ajax callback.
   */
  public static function ajaxSubmit(array $form, FormStateInterface $form_state): AjaxResponse {
    return new AjaxResponse();
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Not needed for demonstration purposes.
  }

}
