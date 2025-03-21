<?php

namespace Drupal\custom_paragraphs_extras\Plugin\paragraphs\Behavior;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityDisplayRepositoryInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_paragraphs_extras\ViewModeBehaviorInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a custom paragraph behavior to set view mode.
 *
 * @ParagraphsBehavior(
 *   id = "custom_view_mode_behavior",
 *   label = @Translation("View mode behavior"),
 *   description = @Translation("Adds a 'view mode' selector field to the Paragraph entity."),
 *   weight = 0,
 * )
 */
class ViewModeBehavior extends ParagraphsBehaviorBase implements ViewModeBehaviorInterface {

  /**
   * Constructs a ViewModeBehavior object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager.
   * @param \Drupal\Core\Entity\EntityDisplayRepositoryInterface $entityDisplayRepository
   *   The entity display repository.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityFieldManagerInterface $entity_field_manager,
    protected EntityDisplayRepositoryInterface $entityDisplayRepository,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $entity_field_manager);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): ViewModeBehavior {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_field.manager'),
      $container->get('entity_display.repository')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $view_modes = $this->entityDisplayRepository->getViewModeOptions('paragraph');
    $form['override_available'] = [
      '#type'          => 'checkboxes',
      '#title'         => $this->t('Select which view modes are allowable'),
      '#options'       => $view_modes,
      '#default_value' => $this->configuration['override_available'],
    ];
    $form['override_default'] = [
      '#type'          => 'select',
      '#title'         => $this->t('Select default view mode for content to use'),
      '#options'       => $view_modes,
      '#default_value' => $this->configuration['override_default'],
    ];
    return parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state): void {
    parent::validateConfigurationForm($form, $form_state);
    $default = $form_state->getValue('override_default');
    $allowed = array_filter($form_state->getValue('override_available'));

    if (!in_array($default, $allowed, TRUE)) {
      $form_state->setError($form['override_default'], 'Default view mode must also be selected in allowed view modes');
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state): void {
    $this->configuration['override_available'] = array_filter($form_state->getValue('override_available'));
    $this->configuration['override_default'] = $form_state->getValue('override_default');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    $configuration = [
      'override_available' => ['default' => 'Default'],
      'override_default'   => 'default',
    ];
    return parent::defaultConfiguration() + $configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state): array {
    $all_modes = $this->entityDisplayRepository->getViewModeOptions('paragraph');
    $available_modes = array_filter($this->configuration['override_available']);
    $mode = $paragraph->getBehaviorSetting($this->pluginId, 'view_mode', $this->configuration['override_default']);
    $mode_options = array_intersect_key($all_modes, $available_modes);
    $form['view_mode'] = [
      '#type'          => 'select',
      '#title'         => $this->t('Select which view mode to use for this paragraph'),
      '#options'       => $mode_options,
      '#default_value' => $mode,
    ];
    return parent::buildBehaviorForm($paragraph, $form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode): array {
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary(Paragraph $paragraph): array|null {
    $all_modes = $this->entityDisplayRepository->getViewModeOptions('paragraph');
    if ($value = $paragraph->getBehaviorSetting($this->getPluginId(), 'view_mode')) {
      return [$this->t('View mode: @view_mode', ['@view_mode' => $all_modes[$value]])];
    }
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function entityViewModeAlter(&$view_mode, ParagraphInterface $paragraph): void {
    $view_mode = $paragraph->getBehaviorSetting($this->pluginId, 'view_mode', $this->configuration['override_default']);
  }

}
