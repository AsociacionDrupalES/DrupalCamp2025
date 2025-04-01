<?php

declare(strict_types=1);

namespace Drupal\custom_paragraphs_extras\Plugin\paragraphs\Behavior;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;

/**
 * Provides a custom paragraph behavior to set a sdc variant.
 *
 * @ParagraphsBehavior(
 *   id = "custom_variant",
 *   label = @Translation("SDC variant"),
 *   description = @Translation("Allow select a SDC variant for the Paragraph entity."),
 *   weight = 0,
 * )
 */
final class VariantBehavior extends ParagraphsBehaviorBase {

  /**
   * Return list of variants.
   */
  public function getVariants(): array {
    return [
      'default'     => $this->t('Default'),
      'featured'    => $this->t('Featured'),
      'with-border' => $this->t('With border'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {
    $form['variants'] = [
      '#type'          => 'select',
      '#default_value' => $this->configuration['variants'] ?? NULL,
      '#empty_option'  => $this->t('- None -'),
      '#empty_value'   => '',
      '#multiple'      => TRUE,
      '#options'       => $this->getVariants(),
      '#size'          => 5,
      '#title'         => $this->t('Allowed variants'),
    ];
    return parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state): array {
    $variant = $paragraph->getBehaviorSetting($this->getPluginId(), 'variant');
    $form['#attributes']['class'][] = 'paragraphs-subform';

    /* Quiero quedarme de VARIANTS solo lo que hay en $this->configuration['variants'] */
    $variants = array_intersect_key($this->getVariants(), array_flip($this->configuration['variants']));

    $form['variant'] = [
      '#type'          => 'select',
      '#default_value' => $variant ?? reset($variants),
      '#options'       => $variants,
      '#required'      => TRUE,
      '#title'         => $this->t('Variant'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode): void {
    $variant = $paragraph->getBehaviorSetting($this->getPluginId(), 'variant');
    if ($variant) {
      $build['#attributes']['class'][] = 'variant--' . $variant;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state): void {
    $this->configuration['variants'] = $form_state->getValue('variants');
    parent::submitConfigurationForm($form, $form_state);
  }

}
