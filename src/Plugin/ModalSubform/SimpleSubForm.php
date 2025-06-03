<?php

declare(strict_types=1);

namespace Drupal\drupalcamppl_2025\Plugin\ModalSubform;

use Drupal\Core\Form\FormInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\lms\Attribute\ModalSubform;
use Drupal\drupalcamppl_2025\Form\ImpossibleForm;
use Drupal\drupalcamppl_2025\Form\ImpossibleModalForm;
use Drupal\lms\Plugin\ModalSubformBase;

/**
 * Modal LMS entity bundle selection form.
 */
#[ModalSubform(
  id: 'simple_drupalcamp_subform',
)]
final class SimpleSubForm extends ModalSubformBase {

  /**
   * {@inheritdoc}
   */
  protected function getFormObject(): FormInterface {
    $class = \array_key_exists('parent_form', $this->configuration) ? ImpossibleForm::class : ImpossibleModalForm::class;
    return $this->classResolver->getInstanceFromDefinition($class);
  }

  /**
   * {@inheritdoc}
   */
  public function getSubmissionData(): array {
    return $this->formState->cleanValues()->getValues();
  }

  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $currentUser): bool {
    return $currentUser->hasPermission('access content');
  }

  /**
   * {@inheritdoc}
   */
  public function getDialogId(): string {
    return '#modal-drupalcamp-subform';
  }

}
