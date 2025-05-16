<?php

namespace Drupal\custom_general_features\Controller;

use Drupal\Core\Access\AccessResultAllowed;
use Drupal\Core\Access\AccessResultNeutral;
use Drupal\Core\Controller\ControllerBase;
use Drupal\custom_general_features\SessionSubmissionDeadlineService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Controller for the proposal session redirect.
 */
class ProposeSessionRedirect extends ControllerBase {

  /**
   * Constructs a ProposeSessionRedirect object.
   *
   * @param \Drupal\custom_general_features\SessionSubmissionDeadlineService $submissionDeadlineService
   *   The session submission deadline service.
   */
  public function __construct(
    protected SessionSubmissionDeadlineService $submissionDeadlineService,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): static {
    return new static(
      $container->get('custom_general_features.submission_deadline')
    );
  }

  /**
   * Redirects to the session proposal page if the deadline is not passed.
   */
  public function redirectPage(): RedirectResponse|Response {
    if ($this->submissionDeadlineService->isSubmissionAllowed()) {
      return new RedirectResponse($this->redirect('node.add', ['node_type' => 'session'])->getTargetUrl());
    }
    return new Response($this->t('The deadline for the call for papers has passed.'), 403);
  }

  /**
   * Check access to the proposal session page.
   */
  public function access(AccountInterface $account): AccessResultNeutral|AccessResult|AccessResultAllowed {
    return AccessResult::allowedIf($this->submissionDeadlineService->isSubmissionAllowed())
      ->addCacheableDependency('config_pages:event_details');
  }

}
