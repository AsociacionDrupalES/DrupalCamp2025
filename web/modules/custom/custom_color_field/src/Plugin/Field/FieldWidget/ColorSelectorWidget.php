<?php

namespace Drupal\custom_color_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\StringTextfieldWidget;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines the 'custom_color_field_color_selector' field widget.
 *
 * @FieldWidget(
 *   id = "custom_color_selector",
 *   label = @Translation("Color selector"),
 *   field_types = {"custom_color"},
 * )
 */
final class ColorSelectorWidget extends StringTextfieldWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $element['value'] = $element +
      [
        '#attributes'    => [
          'class' => ['custom-color-selector-widget'],
        ],
        '#type'          => 'custom_color',
        '#default_value' => $items[$delta]->value ?? NULL,
      ];
    return $element;
  }

}
