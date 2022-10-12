<?php

namespace Drupal\custom_features\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\custom_features\ProductCosts;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a daria block.
 *
 * @Block(
 *   id = "custom_features_product_block",
 *   admin_label = @Translation("ProductBlock"),
 *   category = @Translation("Custom")
 * )
 */

class ProductBlock extends BlockBase {

  protected $productCosts;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->productCosts = $container->get('custom_features.get_costs');
    return $instance;
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    if(!$this->productCosts instanceof ProductCosts) {
      $build['content'] = [
        '#markup' => $this->t('Big problems'),
      ];
      return $build;
    }
    $s = \Drupal::service('custom_features.get_costs');
    // $count = $this->productCosts->getCosts();
    $count = $s->getCosts();
    $build['content'] = [
      '#markup' => 'Общая стоимость товаров: ' . $count,
    ];
    return $build;
  }

}
