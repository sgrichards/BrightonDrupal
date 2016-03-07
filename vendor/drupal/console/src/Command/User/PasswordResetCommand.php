<?php
/**
 * @file
 * Contains \Drupal\Console\Command\User\PasswordResetCommand.
 */

namespace Drupal\Console\Command\User;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Command\ConfirmationTrait;
use Drupal\Console\Command\ContainerAwareCommand;
use Drupal\user\Entity\User;
use Drupal\Console\Style\DrupalStyle;

class PasswordResetCommand extends ContainerAwareCommand
{
    use ConfirmationTrait;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('user:password:reset')
            ->setDescription($this->trans('commands.user.password.reset.description'))
            ->setHelp($this->trans('commands.user.password.reset.help'))
            ->addArgument('user', InputArgument::REQUIRED, $this->trans('commands.user.password.reset.options.user-id'))
            ->addArgument('password', InputArgument::REQUIRED, $this->trans('commands.user.password.reset.options.password'));
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new DrupalStyle($input, $output);

        $uid = $input->getArgument('user');

        $user = User::load($uid);

        if (!$user) {
            $io->error(
                sprintf(
                    $this->trans('commands.user.password.reset.errors.invalid-user'),
                    $uid
                )
            );

            return;
        }

        $password = $input->getArgument('password');
        if (!$password) {
            $io->error(
                sprintf(
                    $this->trans('commands.user.password.reset.errors.empty-password'),
                    $uid
                )
            );

            return;
        }

        try {
            $user->setPassword($password);
            $user->save();
            // Clear all failed login attempts after setup new password to user account.
            $this->getChain()
                ->addCommand('user:login:clear:attempts', ['uid' => $uid]);
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return;
        }

        $io->success(
            sprintf(
                $this->trans('commands.user.password.reset.messages.reset-successful'),
                $uid
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $io = new DrupalStyle($input, $output);

        $user = $input->getArgument('user');
        if (!$user) {
            while (true) {
                $user = $io->ask(
                    $this->trans('commands.user.password.reset.questions.user'),
                    '',
                    function ($uid) use ($io) {
                        if ($uid) {
                            $uid = (int) $uid;
                            if (is_int($uid) && $uid > 0) {
                                return $uid;
                            } else {
                                $io->error(
                                    sprintf($this->trans('commands.user.password.reset.questions.invalid-uid'), $uid)
                                );

                                return false;
                            }
                        }
                    }
                );

                if ($user) {
                    break;
                }
            }

            $input->setArgument('user', $user);
        }

        $password = $input->getArgument('password');
        if (!$password) {
            while (true) {
                $password = $io->ask(
                    $this->trans('commands.user.password.hash.questions.password'),
                    '',
                    function ($pass) use ($io) {
                        if ($pass) {
                            if (!empty($pass)) {
                                return $pass;
                            } else {
                                $io->error(
                                    sprintf($this->trans('commands.user.password.hash.questions.invalid-pass'), $pass)
                                );

                                return false;
                            }
                        }

                    }
                );

                if ($password) {
                    break;
                }
            }


            $input->setArgument('password', $password);
        }
    }
}
