<?php

/**
 * @file
 * Theme setting callbacks for the da_vinci theme.
 */

/**
 * Implements hook_form_FORM_ID_alter().
 */
function da_vinci_form_system_theme_settings_alter(&$form, &$form_state) {

  $form['da_vinci_settings'] = [
    '#type'        => 'vertical_tabs',
    '#title'       => '<h3>' . t('Da Vinci Settings') . '</h3>',
    '#collapsible' => FALSE,
    '#collapsed'   => FALSE,
  ];

  // Main Tabs.
  // Main Tabs -> General.
  $form['general'] = [
    '#type'  => 'details',
    '#title' => t('General'),
    '#group' => 'da_vinci_settings',
  ];

  // Main Tabs -> Custom Styling.
  $form['css'] = [
    '#type'  => 'details',
    '#title' => t('Custom Styling'),
    '#group' => 'da_vinci_settings',
  ];

  $form['general']['search-placeholder'] = [
    '#type'          => 'checkbox',
    '#title'         => t('Check me if you want Search placeholder.'),
    '#default_value' => theme_get_setting('search-placeholder', 'da_vinci'),
    '#description'   => t("Check me if you want the search to have a placeholder."),
  ];

  $form['general']['responsive-project'] = [
    '#type'          => 'checkbox',
    '#title'         => t('Check me if you want Responsive Project.'),
    '#default_value' => theme_get_setting('responsive-project', 'da_vinci'),
    '#description'   => t("Troll Note: Of course is 100% mobile first and responsive, this Check will add the NyanCat Ascii logo into the html."),
  ];

  // Settings under Custom Styling tab.
  $form['css']['styling'] = [
    '#type'          => 'checkbox',
    '#title'         => t('Enable custom css'),
    '#default_value' => theme_get_setting('styling', 'da_vinci'),
    '#description'   => t("Check this option to enable custom styling."),
  ];

  $form['css']['styling_code'] = [
    '#type'          => 'textarea',
    '#title'         => t('Custom CSS Codes'),
    '#default_value' => theme_get_setting('styling_code', 'da_vinci'),
    '#description'   => t('Please enter your custom css codes in this text box. You can use it to customize the appearance of your site.'),
  ];

}
