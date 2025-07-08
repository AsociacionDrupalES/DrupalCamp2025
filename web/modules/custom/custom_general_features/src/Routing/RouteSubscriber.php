<?php

declare(strict_types=1);

namespace Drupal\custom_general_features\Routing;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\RouteProviderInterface;
use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Subscriber for Custom General Features routes.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * Constructs a new RouteSubscriber object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   * @param \Drupal\Core\Routing\RouteProviderInterface $routerProvider
   *   The router service.
   */
  public function __construct(
    protected EntityTypeManagerInterface $entityTypeManager,
    protected RouteProviderInterface $routerProvider,
  ) {}

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection): void {
    $taxonomy_term_definition = $this->entityTypeManager->getDefinition('taxonomy_term');
    if (!$taxonomy_term_definition) {
      return;
    }

    $route = $this->getTermSessionListRoute($taxonomy_term_definition);
    if ($route instanceof Route) {
      $collection->add('entity.taxonomy_term.event_platform:sessions', $route);
    }

    $route = $this->getTermSessionScheduleRoute($taxonomy_term_definition);
    if ($route instanceof Route) {
      $collection->add('entity.taxonomy_term.event_platform:schedule', $route);
    }
  }

  /**
   * Get the route for the session list.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $taxonomy_term_definition
   *   The taxonomy terms entity type definition.
   */
  protected function getTermSessionListRoute(EntityTypeInterface $taxonomy_term_definition): ?Route {
    $event_platform_sessions = $taxonomy_term_definition->getLinkTemplate('event_platform:sessions');
    if (is_bool($event_platform_sessions)) {
      return NULL;
    }

    $route = new Route($event_platform_sessions);
    $route
      ->addDefaults([
        '_controller' => '\Drupal\custom_general_features\Controller\TaxonomyTermController::redirectToSessions',
        '_title' => 'Link to sessions list',
      ])
      ->addRequirements([
        '_permission' => 'access content',
      ])
      ->setOption('parameters', [
        'taxonomy_term' => ['type' => 'entity:taxonomy_term'],
      ]);
    return $route;
  }

  /**
   * Get the route for the session schedule.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $taxonomy_term_definition
   *   The taxonomy terms entity type definition.
   */
  protected function getTermSessionScheduleRoute(EntityTypeInterface $taxonomy_term_definition): ?Route {
    $event_platform_schedule = $taxonomy_term_definition->getLinkTemplate('event_platform:schedule');
    if (is_bool($event_platform_schedule)) {
      return NULL;
    }

    $route = new Route($event_platform_schedule);
    $route
      ->addDefaults([
        '_controller' => '\Drupal\custom_general_features\Controller\TaxonomyTermController::redirectToSchedule',
        '_title' => 'Link to schedule page',
      ])
      ->addRequirements([
        '_permission' => 'access content',
      ])
      ->setOption('parameters', [
        'taxonomy_term' => ['type' => 'entity:taxonomy_term'],
      ]);
    return $route;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    $events = parent::getSubscribedEvents();
    $events[RoutingEvents::ALTER] = ['onAlterRoutes', 100];
    return $events;
  }

}
