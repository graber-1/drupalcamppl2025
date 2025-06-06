<?php

declare(strict_types=1);

namespace Drupal\drupalcamppl_2025\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogWithUrl;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;

/**
 * Hard Modal form example form builder.
 */
final class HardForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'dc_2025_hard_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['input'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Some textfield'),
    ];
    $form['container'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'container-1',
      ],
      'content' => [
        '#markup' => 'Content of container 1',
      ],
    ];

    $form['container_2'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'container-2',
      ],
      'content' => [
        '#markup' => 'Content of container 2',
      ],
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['ajax'] = [
      '#type' => 'button',
      '#value' => $this->t('Open modal'),
      '#ajax' => [
        'callback' => '::ajaxCallback',
      ],
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Normal submit'),
    ];

    return $form;
  }

  /**
   * Ajax callback.
   */
  public function ajaxCallback(array $form, FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();
    $url = Url::fromRoute('drupalcamppl_2025.hard.form');
    $response->addCommand(new OpenModalDialogWithUrl($url->toString(), ['width' => '75%']));
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $form_state->cleanValues();
    $this->messenger()->addStatus(Markup::create('Values: <pre>' . \print_r($form_state->getValues(), TRUE) . '</pre>'));
    $this->messenger()->addStatus(Markup::create('User input: <pre>' . \print_r($form_state->getUserInput(), TRUE) . '</pre>'));
  }

}
