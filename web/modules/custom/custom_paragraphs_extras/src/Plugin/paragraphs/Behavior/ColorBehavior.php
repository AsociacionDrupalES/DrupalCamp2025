<?php

declare(strict_types=1);

namespace Drupal\custom_paragraphs_extras\Plugin\paragraphs\Behavior;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;

/**
 * Provides a custom paragraph behavior to set a color.
 *
 * @ParagraphsBehavior(
 *   id = "custom_color",
 *   label = @Translation("Color"),
 *   description = @Translation("Adds a color class to the Paragraph entity."), weight = 0,
 * )
 */
final class ColorBehavior extends ParagraphsBehaviorBase {

  /**
   * Return list of colors.
   */
  public function getColors(): array {
    return [
      'primary'       => $this->t('Primary'),
      'secondary'     => $this->t('Secondary'),
      'primary-light' => $this->t('Primary light'),
      'white'         => $this->t('White'),
      'disabled'      => $this->t('Disabled'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state): array {
    $color = $paragraph->getBehaviorSetting($this->getPluginId(), 'color');
    $form['#attributes']['class'][] = 'paragraphs-subform';
    $form['color'] = [
      '#type'          => 'select',
      '#default_value' => $color ?? NULL,
      '#empty_option'  => $this->t('- None -'),
      '#empty_value'   => 'transparent',
      '#options'       => $this->getColors(),
      '#required'      => FALSE,
      '#title'         => $this->t('Color'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode): void {
    $color = $paragraph->getBehaviorSetting($this->getPluginId(), 'color');
    if ($color) {
      $build['#attributes']['class'][] = 'color--' . $color;
    }
  }

}
