<?php

declare(strict_types=1);

namespace Drupal\custom_paragraphs_extras\Plugin\paragraphs\Behavior;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\custom_color_field\Element\Color;
use Drupal\file\FileInterface;
use Drupal\media\MediaInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a custom paragraph behavior to set a background.
 *
 * @ParagraphsBehavior(
 *   id = "custom_background_behavior",
 *   label = @Translation("Background"),
 *   description = @Translation("Adds a background to the Paragraph entity."),
 *   weight = 0,
 * )
 */
final class BackgroundBehavior extends ParagraphsBehaviorBase {

  /**
   * The media types.
   */
  public const MEDIA_TYPES = ['image', 'vector_image'];

  /**
   * Blend modes.
   */
  public const BLEND_MODES = ['overlay' => 'overlay'];

  /**
   * Image sizes.
   */
  public const SIZES = ['cover' => 'cover', 'contain' => 'contain'];

  /**
   * The node storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected EntityStorageInterface $mediaStorage;

  /**
   * The image style storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected EntityStorageInterface $imageStyleStorage;

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
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity display repository.
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $fileUrlGenerator
   *   The file URL generator.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    EntityFieldManagerInterface $entity_field_manager,
    EntityTypeManagerInterface $entity_type_manager,
    protected FileUrlGeneratorInterface $fileUrlGenerator,
    protected RendererInterface $renderer,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $entity_field_manager);
    $this->mediaStorage = $entity_type_manager->getStorage('media');
    $this->imageStyleStorage = $entity_type_manager->getStorage('image_style');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): BackgroundBehavior {
    return new BackgroundBehavior(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_field.manager'),
      $container->get('entity_type.manager'),
      $container->get('file_url_generator'),
      $container->get('renderer')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $form['image_style'] = [
      '#type' => 'select',
      '#default_value' => $this->configuration['image_style'] ?? NULL,
      '#empty_option' => $this->t('- None -'),
      '#empty_value' => '',
      '#options' => $this->getImageStyles(),
      '#required' => FALSE,
      '#title' => $this->t('Image style'),
    ];
    return parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state): array {
    $options = $paragraph->getBehaviorSetting($this->getPluginId(), 'background');

    $form['#attributes']['class'][] = 'paragraphs-subform';
    $form['background'] = [
      '#type'  => 'details',
      '#title' => $this->t('Background settings'),
      '#open'  => TRUE,
    ];
    $form['background']['color'] = [
      '#type'          => 'custom_color',
      '#title'         => $this->t('Color'),
      '#default_value' => $options['color'] ?? NULL,
    ];
    $form['background']['media_file'] = [
      '#type'            => 'media_library',
      '#allowed_bundles' => self::MEDIA_TYPES,
      '#title'           => $this->t('Upload your background image'),
      '#default_value'   => $options['media_file'] ?? NULL,
    ];
    $form['background']['image_blend_mode'] = [
      '#type' => 'select',
      '#default_value' => $options['image_blend_mode'] ?? NULL,
      '#empty_option' => $this->t('- None -'),
      '#empty_value' => 'normal',
      '#options' => $this::BLEND_MODES,
      '#required' => FALSE,
      '#title' => $this->t('Image blend mode'),
    ];
    $form['background']['image_size'] = [
      '#type' => 'select',
      '#default_value' => $options['image_size'] ?? NULL,
      '#empty_option' => $this->t('- None -'),
      '#empty_value' => 'auto',
      '#options' => $this::SIZES,
      '#required' => FALSE,
      '#title' => $this->t('Image size'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode): void {
    $options = $paragraph->getBehaviorSetting($this->getPluginId(), 'background');

    if (isset($options['color']) && $options['color'] !== 'transparent' && Color::isValidColor($options['color'])) {
      $build['#attributes']['class'][] = 'component-background-color component-background-color-' . $options['color'];
      $build['#attached']['library'][] = 'custom_paragraphs_extras/behaviors.background_color.view';
    }

    if (isset($options['media_file'])) {
      $imageStyle = NULL;
      if ($this->configuration['image_style']) {
        /** @var \Drupal\image\ImageStyleInterface $imageStyle */
        $imageStyle = $this->imageStyleStorage->load($this->configuration['image_style']);
      }
      $media = $this->mediaStorage->load($options['media_file']);
      if ($media instanceof MediaInterface && $media->hasField('field_media_image')) {
        $image = $media->get('field_media_image')->entity;
        if ($image instanceof FileInterface && $uri = $image->getFileUri()) {
          $urlAbsolute = ('vector_image' === $media->bundle() || !$imageStyle)
            ? $this->fileUrlGenerator->generateAbsoluteString($uri)
            : $imageStyle->buildUrl($uri);
          $build['#attributes']['class'][] = 'component-background-image';
          $build['#attributes']['style'][] = '--bg-img: url(' . $urlAbsolute . ');';
          if (isset($options['image_blend_mode'])) {
            $build['#attributes']['style'][] = '--bg-img-blend-mode: ' . $options['image_blend_mode'] . ';';
          }
          if (isset($options['image_size'])) {
            $build['#attributes']['style'][] = '--bg-img-size: ' . $options['image_size'] . ';';
          }
        }
      }
    }

  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state): void {
    $this->configuration['image_style'] = $form_state->getValue('image_style');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * Get image styles options.
   *
   * @return array
   *   The image style options.
   */
  private function getImageStyles(): array {
    $options = [];
    foreach ($this->imageStyleStorage->loadMultiple() as $imageStyle) {
      $options[$imageStyle->id()] = $imageStyle->label();
    }
    return $options;
  }

}
