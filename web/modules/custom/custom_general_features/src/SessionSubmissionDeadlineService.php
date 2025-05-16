<?php

namespace Drupal\custom_general_features;

use Drupal\config_pages\Entity\ConfigPages;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;

/**
 * Service to manage session submission deadlines.
 */
class SessionSubmissionDeadlineService {

  /**
   * Constructs a new SessionSubmissionDeadlineService object.
   *
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   The logger factory.
   */
  public function __construct(
    protected LoggerChannelFactoryInterface $loggerFactory,
  ) {}

  /**
   * Get the due date for the call for papers.
   *
   * @return int
   *   The due date timestamp.
   */
  public function getDueDateCpf(): int {
    $details_page = 'event_details';

    $config_page = ConfigPages::config($details_page);
    if ($config_page) {
      $date = $config_page->get('field_session_submission_deadlin')->value;
      return strtotime($date ?: '2025-12-31');
    }

    return strtotime('2025-12-31');
  }

  /**
   * Checks if session submission is still allowed.
   *
   * @return bool
   *   TRUE if submissions are allowed, FALSE otherwise.
   */
  public function isSubmissionAllowed(): bool {
    $due_date = $this->getDueDateCpf();
    $current_date = time();

    return $current_date <= $due_date;
  }

}
