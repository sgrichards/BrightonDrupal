<?php

namespace Unish;

/**
 * Generate makefile tests
 *
 * @group make
 * @group slow
 */
class generateMakeCase extends CommandUnishTestCase {
  function testGenerateMake() {
    $sites = $this->setUpDrupal(1, TRUE);
    $major_version = UNISH_DRUPAL_MAJOR_VERSION . '.x';

    $options = array(
      'yes' => NULL,
      'pipe' => NULL,
      'root' => $this->webroot(),
      'uri' => key($sites),
      'cache' => NULL,
      'strict' => 0, // Don't validate options
    );
    // Omega requires these core modules.
    $this->drush('pm-enable', array('block', 'search', 'help'), $options);
    $this->drush('pm-download', array('omega', 'devel'), $options);
    $this->drush('pm-enable', array('omega', 'devel'), $options);

    $makefile = UNISH_SANDBOX . '/dev.make.yml';

    // First generate a simple makefile with no version information
    $this->drush('generate-makefile', array($makefile), array('exclude-versions' => NULL) + $options);
    $expected = <<<EOD
core: $major_version
api: 2
projects:
  drupal: {  }
  devel: {  }
  omega: {  }
EOD;
    $actual = trim(file_get_contents($makefile));

    $this->assertEquals($expected, $actual);

    // Next generate a simple makefile with no version information in .ini format
    $makefile = UNISH_SANDBOX . '/dev.make';
    $this->drush('generate-makefile', array($makefile), array('exclude-versions' => NULL, 'format' => 'ini') + $options);
    $expected = <<<EOD
; This file was auto-generated by drush make
core = $major_version
api = 2

; Core
projects[] = "drupal"
; Modules
projects[] = "devel"
; Themes
projects[] = "omega"
EOD;
    $actual = trim(file_get_contents($makefile));

    $this->assertEquals($expected, $actual);

    // Download a module to a 'contrib' directory to test the subdir feature
    mkdir($this->webroot() + '/sites/all/modules/contrib');
    $this->drush('pm-download', array('libraries'), array('destination' => 'sites/all/modules/contrib') + $options);
    $this->drush('pm-enable', array('libraries'), $options);
    $makefile = UNISH_SANDBOX . '/dev.make.yml';
    $this->drush('generate-makefile', array($makefile), array('exclude-versions' => NULL) + $options);
    $expected = <<<EOD
core: $major_version
api: 2
projects:
  drupal: {  }
  devel: {  }
  libraries:
    subdir: contrib
  omega: {  }
EOD;
    $actual = trim(file_get_contents($makefile));

    $this->assertEquals($expected, $actual);

    // Again in .ini format.
    $makefile = UNISH_SANDBOX . '/dev.make';
    $this->drush('generate-makefile', array($makefile), array('exclude-versions' => NULL, 'format' => 'ini') + $options);
    $expected = <<<EOD
; This file was auto-generated by drush make
core = $major_version
api = 2

; Core
projects[] = "drupal"
; Modules
projects[] = "devel"
projects[libraries][subdir] = "contrib"

; Themes
projects[] = "omega"
EOD;
    $actual = trim(file_get_contents($makefile));

    $this->assertEquals($expected, $actual);

    // Generate a makefile with version numbers (in .ini format).
    $this->drush('generate-makefile', array($makefile), array('format' => 'ini') + $options);
    $actual = file_get_contents($makefile);
    $this->assertContains('projects[devel][version] = "', $actual);
  }
}