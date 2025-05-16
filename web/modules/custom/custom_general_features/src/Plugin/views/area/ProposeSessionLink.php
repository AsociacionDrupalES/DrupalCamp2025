<?php

namespace Drupal\custom_general_features\Plugin\views\area;

use Drupal\add_content_by_bundle\Plugin\views\area\AddContentByBundle;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a link to propose a session.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("propose_session_link")
 */
class ProposeSessionLink extends AddContentByBundle {

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state): void {
    $this->options['bundle'] = 'session';
    parent::buildOptionsForm($form, $form_state);
    $form['bundle']['#access'] = FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE): ?array {
    if ($empty && empty($this->options['empty'])) {
      return [];
    }

    $element = parent::render($empty);
    if ($element) {
      $element['#url'] = Url::fromRoute('custom_general_features.propose_session');
      $element['#access'] = $this->accessManager->checkNamedRoute('custom_general_features.propose_session');
    }
    return $element;
  }

}
