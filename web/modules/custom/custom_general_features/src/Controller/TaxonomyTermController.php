<?php

namespace Drupal\custom_general_features\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\taxonomy\TermInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

/**
 * Controller for handling taxonomy term redirections.
 */
class TaxonomyTermController extends ControllerBase {

  /**
   * Redirects to session list filtering .
   *
   * @param \Drupal\taxonomy\TermInterface $taxonomy_term
   *   The taxonomy term object.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   *   A redirect to the session list.
   */
  public function redirectToSessions(TermInterface $taxonomy_term) {
    $view_id = 'session_list';
    $view_display = 'page_1';

    $options = [
      'query' => [
        $taxonomy_term->bundle() => $taxonomy_term->id(),
      ],
    ];

    $url = Url::fromRoute("view.$view_id.$view_display", [], $options)
      ->toString(TRUE)
      ->getGeneratedUrl();

    return new RedirectResponse($url);
  }

  /**
   * Redirects to the session schedule page.
   *
   * @param \Drupal\taxonomy\TermInterface $taxonomy_term
   *   The taxonomy term object.
   *
   * @return \Symfony\Component\HttpFoundation\RedirectResponse
   *   A redirect to the session schedule page.
   */
  public function redirectToSchedule(TermInterface $taxonomy_term) {
    $view_id = 'session_schedule';
    $view_display = 'page_1';

    $options = [
      'query' => [
        $taxonomy_term->bundle() => $taxonomy_term->id(),
      ],
    ];

    $url = Url::fromRoute("view.$view_id.$view_display", [
      'arg_0' => '2025-09-19',
    ], $options)->toString();
    return new RedirectResponse($url);
  }

}
