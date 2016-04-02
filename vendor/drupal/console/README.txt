                        Drupal Console
	
  What is it?
  -----------
  The Drupal Console is a suite of tools run from a command line interface (CLI) 
  to generate boilerplate code for interact and debug with Drupal 8. 
  From the ground up, it has been built to utilize the same modern PHP 
  practices which were introduced in Drupal 8.

  The Drupal Console makes use of the Symfony Console and other third party 
  components which allows you to automatically generate most of the code needed 
  for a Drupal 8 module. In addition, Drupal Console helps you interact with 
  your Drupal installation 

  Latest Version
  ------------------
  Details of the latest version can be found on the Drupal Console
  project page under https://drupalconsole.com/.

  Releases Page
  ------------------  
  All notable changes to this project will be documented in the 
  [releases page](https://github.com/hechoendrupal/DrupalConsole/releases) 

  Documentation
  -------------  
  The most up-to-date documentation can be found at [bit.ly/console-book]
  (http://bit.ly/console-book).

  More information about using this project at the [official documentation]
  (https://hechoendrupal.gitbooks.io/drupal-console/content/en/using/project.html).  

  Required PHP Version
  -------------------- 
  PHP 5.5.9 or higher is required to use the Drupal Console application.

  Installation
  ------------  

    - Run this in your terminal to get the latest Console version:
      curl https://drupalconsole.com/installer -L -o drupal.phar

  	- Or if you don't have curl:
	  php -r "readfile('https://drupalconsole.com/installer');" > drupal.phar

  	- Accessing from anywhere on your system:
  	  mv drupal.phar /usr/local/bin/drupal

  	- Apply executable permissions on the downloaded file:
  	  chmod +x /usr/local/bin/drupal

	- Copy configuration files.
	  drupal init --override

	- Show all available commands.
      drupal check

	- Download, install and serve Drupal 8:
	  drupal chain --file=~/.console/chain/quick-start.yml

	- Create a new Drupal 8 project:
	  drupal site:new drupal8.dev 8.0.0

	- Lists all available commands:
	  drupal list

	- Update to the latest version.
      drupal self-update

  Support
  ------------ 
  You can ask for support at Drupal Console gitter chat room 
  [http://bit.ly/console-support](http://bit.ly/console-support).  

  Getting The Project To Contribute
  ---------------------------------   

	- Fork
	  Fork your own copy of the [Console](https://github.com/hechoendrupal/DrupalConsole/fork) 
	  repository to your account

	- Clone
	  Get a copy of your recently cloned version of console in your machine.
	  $ git clone git@github.com:[your-git-user-here]/DrupalConsole.git

	- Install dependencies
      Now that you have cloned the project, you need to download dependencies via 
      Composer.

	  $ cd /path/to/DrupalConsole
      $ composer install

	- Running the project
	  After using Composer to download dependencies, you can run the project by 
	  executing.

	  $ bin/drupal

	- Create a symbolic link
	  You can run this command to easily access the Drupal Console from anywhere 
	  on your system.

	  $ sudo ln -s /path/to/DrupalConsole/bin/drupal /usr/local/bin/drupal

	  NOTE: The name `drupal` is just an alias you can name it anything you like.

  More information about how to contribute with this project at the [official documentation]
  (https://hechoendrupal.gitbooks.io/drupal-console/content/en/contributing/new-features.html).

  Enabling Autocomplete
  ---------------------  
  You can enable autocomplete by executing drupal init

  Bash: Bash support depends on the http://bash-completion.alioth.debian.org/
  project which can be installed with your package manager of choice. Then add 
  this line to your shell configuration file.
  source "$HOME/.console/console.rc" 2>/dev/null

  Zsh: Add this line to your shell configuration file.
  source "$HOME/.console/console.rc" 2>/dev/null

  Fish: Create a symbolic link
  ln -s ~/.console/drupal.fish ~/.config/fish/completions/drupal.fish

  Supporting Organizations
  ------------------------

	- [FFW](https://ffwagency.com)  
	- [Indava](http://www.indava.com/)  
	- [Anexus](http://www.anexusit.com/)  


  > Drupal is a registered trademark of Dries Buytaert.
