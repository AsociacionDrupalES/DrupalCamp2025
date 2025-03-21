<?php

declare(strict_types=1);

namespace Drupal\custom_general_features\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a become a sponsor block.
 */
#[Block(
  id: 'custom_general_features_become_sponsor',
  admin_label: new TranslatableMarkup('Do you want to be a sponsor?'),
  category: new TranslatableMarkup('Custom'),
)]
final class BecomeSponsorBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs the plugin instance.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    private readonly ThemeExtensionList $extensionListTheme,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): self {
    return new self(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('extension.list.theme'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration(): array {
    return [
      'title' => $this->t('Do you want to be a sponsor?'),
      'body' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state): array {
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $this->configuration['title'] ?? '',
    ];
    $form['body'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Body'),
      '#format' => $this->configuration['body']['format'],
      '#default_value' => $this->configuration['body']['value'] ?? '',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state): void {
    $this->configuration['title'] = $form_state->getValue('title');
    $this->configuration['body'] = $form_state->getValue('body');
  }

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    $build['content'] = [
      '#type' => 'component',
      '#component' => 'drupalcamp:become_sponsor',
      '#props' => [
        'title' => $this->configuration['title'] ?? '',
        'logo_svg' => file_get_contents($this->extensionListTheme->getPath('drupalcamp') . '/logo-gradient.svg'),
      ],
      '#slots' => [
        'text' => $this->configuration['body']['value'] ?? '',
      ],
    ];
    return $build;
  }

}
