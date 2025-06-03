<?php

declare(strict_types=1);

namespace Drupal\drupalcamppl_2025\Form;

use Drupal\Core\Ajax\AjaxFormHelperTrait;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\CloseModalDialogCommand;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Html;

/**
 * Medium difficulty form.
 */
final class MediumModalForm extends FormBase {
  use AjaxFormHelperTrait;

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
    $form['command'] = [
      '#title' => $this->t('Command'),
      '#type' => 'radios',
      '#required' => TRUE,
      '#options' => [
        'replace' => $this->t('Replace some content'),
        'remove' => $this->t('Remove some content'),
        'append' => $this->t('Append some content'),
      ],
    ];

    $form['actions'] = ['#type' => 'actions'];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#ajax' => [
        'callback' => '::ajaxSubmit',
      ],
    ];

    // Core issue: https://www.drupal.org/node/2897377.
    $form['#id'] = Html::getId($form_state->getBuildInfo()['form_id']);

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
  protected function successfulAjaxSubmit(array $form, FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();

    $command = $form_state->getValue('command');

    if ($command === 'replace') {
      $response->addCommand(new ReplaceCommand('#container-1', [
        '#type' => 'container',
        '#attributes' => ['id' => 'container-1'],
        'content' => [
          '#markup' => $this->t('Replaced content of Container 1'),
        ],
      ]));
    }
    elseif ($command === 'remove') {
      $response->addCommand(new RemoveCommand('#container-2'));
    }
    elseif ($command === 'append') {
      $response->addCommand(new AppendCommand('#container-1', [
        '#type' => 'container',
        '#attributes' => ['id' => 'container-1-1'],
        'content' => [
          '#markup' => $this->t('Content appended to container 1'),
        ],
      ]));
    }

    $response->addCommand(new CloseModalDialogCommand());

    return $response;
  }

}
