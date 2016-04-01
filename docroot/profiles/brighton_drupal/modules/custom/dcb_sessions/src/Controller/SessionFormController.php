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

    $account = \Drupal::currentUser();

    $node = Node::create(array(
      'type' => 'session',
      'title' => '',
      'langcode' => 'en',
      'uid' => $account->id(),
      'status' => 0,
      'field_fields' => array(),
    ));

    // @todo: pre-populate event value
    // @todo detect if session submissions are open

    $form = $this->entityFormBuilder()->getForm($node, 'session_submission');

    return $form;
  }

}
