<?php

/**
 * @file
 * Contains \Drupal\email_registration\Tests\EmailRegistrationTestCase.
 */

namespace Drupal\email_registration\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests the email registration module.
 *
 * @group email_registration
 */
class EmailRegistrationTestCase extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = array('email_registration');

  /**
   * Test various behaviors for anonymous users.
   */
  function testRegistration() {
    $user_config = $this->container->get('config.factory')->getEditable('user.settings');
    $user_config
      ->set('verify_mail', FALSE)
      ->set('register', USER_REGISTER_VISITORS)
      ->save();
    // Try to register a user.
    $name = $this->randomMachineName();
    $pass = $this->randomString(10);
    $register = array(
      'mail' => $name . '@example.com',
      'pass[pass1]' => $pass,
      'pass[pass2]' => $pass,
    );
    $this->drupalPostForm('/user/register', $register, t('Create new account'));
    $this->drupalLogout();

    $login = array(
      'name' => $name . '@example.com',
      'pass' => $pass,
    );
    $this->drupalPostForm('user/login', $login, t('Log in'));

    // Really basic confirmation that the user was created and logged in.
    $this->assertRaw('<title>' . $name . ' | Drupal</title>', t('User properly created, logged in.'));

    // Now try the immediate login.
    $this->drupalLogout();
    $user_config
      ->set('verify_mail', FALSE)
      ->save();
    $name = $this->randomMachineName();
    $pass = $this->randomString(10);
    $register = array(
      'mail' => $name . '@example.com',
      'pass[pass1]' => $pass,
      'pass[pass2]' => $pass,
    );
    $this->drupalPostForm('/user/register', $register, t('Create new account'));
    $this->assertRaw('Registration successful. You are now logged in.', t('User properly created, immediately logged in.'));
  }

}
