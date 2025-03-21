<?php

namespace Drupal\custom_color_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\Plugin\Field\FieldType\StringItem;
use Drupal\Core\Form\FormStateInterface;
use Drupal\custom_color_field\Element\Color;

/**
 * Defines the 'custom_color_field_color' field type.
 *
 * @FieldType(
 *   id = "custom_color",
 *   label = @Translation("Color"),
 *   description = @Translation("A color field."),
 *   category = "color",
 *   cardinality = 1,
 *   default_widget = "custom_color_selector",
 *   default_formatter = "string"
 * )
 */
final class ColorItem extends StringItem {

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition): array {
    $values['value'] = array_rand(Color::getColors());
    return $values;
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data): array {
    return [];
  }

}
