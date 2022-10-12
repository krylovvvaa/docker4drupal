<?php

namespace Drupal\custom_features\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a daria block.
 *
 * @Block(
 *   id = "custom_features_daria",
 *   admin_label = @Translation("Daria"),
 *   category = @Translation("Custom")
 * )
 */

class DariaBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build['content'] = [
      '#markup' => $this->t(date('Y-m-d')),
    ];
    return $build;
  }

}
