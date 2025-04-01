<?php

namespace Drupal\custom_paragraphs_extras;

use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorInterface;

/**
 * Behavior for paragraphs view mode interface.
 */
interface ViewModeBehaviorInterface extends ParagraphsBehaviorInterface {

  /**
   * Allow plugin to alter the paragraph view mode.
   *
   * @param string $view_mode
   *   The current view mode.
   * @param \Drupal\paragraphs\ParagraphInterface $paragraph
   *   The paragraph.
   */
  public function entityViewModeAlter(string &$view_mode, ParagraphInterface $paragraph): void;

}
