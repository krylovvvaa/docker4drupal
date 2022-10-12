<?php

namespace Drupal\custom_features;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;

/**
 * Class ProductCosts
 *
 * @package Drupal\custom_features
 */
class ProductCosts {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * @param EntityTypeManagerInterface $entityTypeManager
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;

  }

  /**
   * Gets count.
   *
   * @return float
   */
  public function getCosts(): float {
    $cost = 0;
    /** @var ContentEntityStorageInterface $storage */
    $storage = $this->entityTypeManager->getStorage('node');

    /*$query = $storage->getQuery();
    $storage->load(1);
    $entities = $storage->loadByProperties(['status' => TRUE, 'type' => 'products']);
    $storage->loadMultiple(); */

    $query = $storage->getQuery()
      ->condition('status', TRUE)
      ->condition('type', 'products')
      ->execute();
    /** @var NodeInterface[] $entities */
    $entities = $storage->loadMultiple($query);

    foreach ($entities as $product) {
      $price = $product->get('field_price')->value;
      $count = $product->get('field_count')->value;
      $cost += $price * $count;
    }
    return $cost;
  }

}
