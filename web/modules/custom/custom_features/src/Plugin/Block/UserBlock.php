<?php

namespace Drupal\custom_features\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a user block.
 *
 * @Block(
 *   id = "custom_features_user",
 *   admin_label = @Translation("User"),
 *   category = @Translation("Custom")
 * )
 */
class UserBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;
  protected $entityTypeManager;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->currentUser = $container->get('current_user');
    $instance->entityTypeManager = $container->get('entity_type.manager');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    if(!$this->currentUser->isAuthenticated()) {
      $build['content'] = [
        '#markup' => $this->currentUser->getAccountName(),
      ];
      return $build;
    }
    $storage = $this->entityTypeManager->getStorage('user');
    $user = $storage->load($this->currentUser->id());
    $viewBuilder=$this->entityTypeManager->getViewBuilder('user');
    $build['content'] = $viewBuilder->view($user, 'card');
    return $build;
  }
  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return['user.roles'];
  }
}
