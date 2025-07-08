<?php

namespace Drupal\custom_general_features;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Logger\LoggerChannelFactory;

/**
 * Service to check if the schedule is published.
 */
class SchedulePublicationService {

  /**
   * Constructs a new SchedulePublicationService object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory.
   * @param \Drupal\Core\Logger\LoggerChannelFactory $loggerChannelFactory
   *   The logger channel factory.
   */
  public function __construct(
    protected EntityTypeManagerInterface $entityTypeManager,
    protected ConfigFactoryInterface $configFactory,
    protected LoggerChannelFactory $loggerChannelFactory,
  ) {}

  /**
   * Checks if the schedule is published.
   *
   * @return bool
   *   TRUE if the schedule is published, FALSE otherwise.
   */
  public function isSchedulePublished(): bool {
    try {
      /** @var \Drupal\config_pages\ConfigPagesInterface|null $config_pages */
      $config_pages = $this->entityTypeManager
        ->getStorage('config_pages')
        ->load('event_details');

      if (!$config_pages || !$config_pages->hasField('field_schedule_published')) {
        return FALSE;
      }

      return (bool) $config_pages->get('field_schedule_published')->value;
    }
    catch (\Exception $e) {
      $this->loggerChannelFactory->get('custom_general_features')->error('Error checking schedule publication status: @message', [
        '@message' => $e->getMessage(),
      ]);
      return FALSE;
    }
  }

}
