<?php

/**
 * @file
 * Contains \Drupal\dcb_sessions\Controller\SessionFormController.
 */

namespace Drupal\dcb_sessions\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Class SessionFormController.
 *
 * @package Drupal\dcb_sessions\Controller
 */
class SessionFormController extends ControllerBase {

  /**
   * Build.
   * @return $form
   */
  public function build() {

    $node = Node::create(array(
      'type' => 'session',
      'title' => '',
      'langcode' => 'en',
      'uid' => '',
      'status' => 0,
      'field_fields' => array(),
    ));

    $form = $this->entityFormBuilder()->getForm($node, 'session_submission');
    $form['#title'] = $this->t('Submit a Session');

    return $form;
  }

}
