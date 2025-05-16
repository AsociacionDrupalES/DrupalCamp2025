<?php

/**
 * @file
 * Provide views data for our General features module.
 */

/**
 * Implements hook_views_data().
 */
function custom_general_features_views_data(): array {
  $data['views']['propose_session_link'] = [
    'title' => t('Propose session link'),
    'help' => t('Provide a link to add a new session.'),
    'area' => [
      'id' => 'propose_session_link',
    ],
  ];
  return $data;
}
