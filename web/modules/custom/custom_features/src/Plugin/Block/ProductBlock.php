<?php

namespace Drupal\custom_features\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
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

class ProductBlock extends BlockBase implements ContainerFactoryPluginInterface {

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
    $count = $this->productCosts->getCosts();
    $build['content'] = [
      '#markup' => $this->t('Summary cost @count', ['@count' => $count]),
    ];
    return $build;
  }

}
