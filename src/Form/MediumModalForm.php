<?php

declare(strict_types=1);

namespace Drupal\drupalcamppl_2025\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Medium difficulty form.
 */
final class MediumModalForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'dc_2025_medium_modal_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['text'] = ['#markup' => 'Press the button below.'];
    $form['actions'] = ['#type' => 'actions'];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::ajaxSubmit',
        'wrapper' => 'container-1',
        'progress' => [
          'type' => 'bar',
          'message' => $this->t('Ajaxing'),
        ],
        'effect' => 'fade',
        'speed' => 'slow',
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Not needed for demonstration purposes.
  }

  /**
   * {@inheritdoc}
   */
  public function ajaxSubmit(array $form, FormStateInterface $form_state): array {
    $end_date = new \DateTime('2025-06-07 12:45:00');
    $diff = $end_date->diff(new \DateTime('now'));
    $minutes = $diff->i;
    return [
      '#type' => 'container',
      '#attributes' => ['id' => 'container-1-1'],
      'content' => [
        '#markup' => $this->t('New container 1 content. You still have @time minutes until the end of the presentastion.', [
          '@time' => $minutes,
        ]),
      ],
    ];
  }

}
