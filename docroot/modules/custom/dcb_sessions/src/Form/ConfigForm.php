<?php

/**
 * @file
 * Contains Drupal\dcb_sessions\Form\ConfigForm.
 */

namespace Drupal\dcb_sessions\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ConfigForm.
 *
 * @package Drupal\dcb_sessions\Form
 */
class ConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'dcb_sessions.config',
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
    $config = $this->config('dcb_sessions.config');
    $form['session_submissions_active'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Session submissions active?'),
      '#default_value' => $config->get('session_submissions_active'),
    ];
    $form['default_event'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Default event'),
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

    $this->config('dcb_sessions.config')
      ->set('session_submissions_active', $form_state->getValue('session_submissions_active'))
      ->set('default_event', $form_state->getValue('default_event'))
      ->save();
  }

}
