<?php

/**
 * @file
 * Contains Drupal\bd_sessions\Form\ConfigForm.
 */

namespace Drupal\bd_sessions\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm.
 *
 * @package Drupal\bd_sessions\Form
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'bd_sessions.config',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('bd_sessions.config');
    $form['submissions_enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Submissions enabled?'),
      '#description' => $this->t('Check to enable session submissions'),
      '#default_value' => $config->get('submissions_enabled'),
    ];
    $form['default_event'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Default event'),
      '#description' => $this->t('Select the default event for new session submissions'),
      '#default_value' => $config->get('default_event'),
      '#target_type' => 'event',
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('bd_sessions.config')
      ->set('submissions_enabled', $form_state->getValue('submissions_enabled'))
      ->set('default_event', $form_state->getValue('default_event'))
      ->save();
  }

}
