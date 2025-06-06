<?php

declare(strict_types=1);

namespace Drupal\drupalcamppl_2025\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

/**
 * DC Demo Controller.
 */
final class DCController extends ControllerBase {

  /**
   * Easy mode.
   */
  public function easy(): array {
    $results = $this->entityTypeManager()->getStorage('node')->getQuery()
      ->accessCheck(TRUE)
      ->range(0, 1)
      ->sort('nid', 'DESC')
      ->execute();
    if (\count($results) === 0) {
      return [
        '#markup' => $this->t('There are no nodes.'),
      ];
    }
    return [
      '#type' => 'link',
      '#title' => $this->t('Display last node.'),
      '#url' => Url::fromRoute('entity.node.canonical', [
        'node' => \reset($results),
      ]),
      '#ajax' => [
        'dialogType' => 'modal',
        'dialog' => ['height' => 'auto', 'width' => '80%'],
      ],
    ];
  }

  /**
   * Medium mode.
   */
  public function medium(): array {
    $renderable = [];

    $renderable['content'] = [
      'container_1' => [
        '#type' => 'container',
        '#attributes' => ['id' => 'container-1'],
        'content' => [
          '#markup' => $this->t('Content of Container 1'),
        ],
      ],
      'container_2' => [
        '#type' => 'container',
        '#attributes' => ['id' => 'container-2'],
        'content' => [
          '#markup' => $this->t('Content of Container 2'),
        ],
      ],
    ];

    $renderable['link'] = [
      '#type' => 'link',
      '#title' => $this->t('Open modal form.'),
      '#url' => Url::fromRoute('drupalcamppl_2025.medium.form'),
      '#ajax' => [
        'dialogType' => 'dialog',
        'dialog' => [
          'height' => 'auto',
          'width' => '300',
        ],
      ],
    ];

    return $renderable;
  }

}
