<?php

declare(strict_types=1);

namespace Drupal\custom_general_features\Hook;

use Drupal\Core\Hook\Attribute\Hook;

/**
 * Contains custom hooks for general features.
 */
class CustomGeneralFeaturesHooks {

  /**
   * Implements hook_entity_type_alter().
   *
   * Adds custom link templates to the taxonomy_term entity type.
   */
  #[Hook('entity_type_alter')]
  public function entityTypeAlter(array &$entity_types): void {
    /** @var \Drupal\Core\Entity\EntityTypeInterface[] $entity_types */
    if (isset($entity_types['taxonomy_term'])) {
      $entity_types['taxonomy_term']->setLinkTemplate('event_platform:sessions', '/taxonomy/term/{taxonomy_term}/sessions');
      $entity_types['taxonomy_term']->setLinkTemplate('event_platform:schedule', '/taxonomy/term/{taxonomy_term}/schedule');
    }
  }

}
