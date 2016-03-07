<?php

/**
 * @file
 * Contains \Drupal\Console\Command\Create\TermsCommand.
 */

namespace Drupal\Console\Command\Create;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Drupal\Console\Command\ContainerAwareCommand;
use Drupal\Console\Style\DrupalStyle;

/**
 * Class TermsCommand
 * @package Drupal\Console\Command\Generate
 */
class TermsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('create:terms')
            ->setDescription($this->trans('commands.create.terms.description'))
            ->addArgument(
                'vocabularies',
                InputArgument::IS_ARRAY,
                $this->trans('commands.create.terms.arguments.vocabularies')
            )
            ->addOption(
                'limit',
                null,
                InputOption::VALUE_OPTIONAL,
                $this->trans('commands.create.terms.options.limit')
            )
            ->addOption(
                'name-words',
                null,
                InputOption::VALUE_OPTIONAL,
                $this->trans('commands.create.terms.options.name-words')
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $io = new DrupalStyle($input, $output);

        $vocabularies = $input->getArgument('vocabularies');
        if (!$vocabularies) {
            $vocabularies = $this->getDrupalApi()->getVocabularies();
            $vids = $io->choice(
                $this->trans('commands.create.terms.questions.vocabularies'),
                array_values($vocabularies),
                null,
                true
            );

            $vids = array_map(
                function ($vid) use ($vocabularies) {
                    return array_search($vid, $vocabularies);
                },
                $vids
            );

            $input->setArgument('vocabularies', $vids);
        }

        $limit = $input->getOption('limit');
        if (!$limit) {
            $limit = $io->ask(
                $this->trans('commands.create.terms.questions.limit'),
                25
            );
            $input->setOption('limit', $limit);
        }

        $nameWords = $input->getOption('name-words');
        if (!$nameWords) {
            $nameWords = $io->ask(
                $this->trans('commands.create.terms.questions.name-words'),
                5
            );

            $input->setOption('name-words', $nameWords);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new DrupalStyle($input, $output);

        $vocabularies = $input->getArgument('vocabularies');
        $limit = $input->getOption('limit')?:25;
        $nameWords = $input->getOption('name-words')?:5;

        if (!$vocabularies) {
            $vocabularies = array_keys($this->getDrupalApi()->getVocabularies());
        }

        $createTerms = $this->getDrupalApi()->getCreateTerms();
        $terms = $createTerms->createTerm(
            $vocabularies,
            $limit,
            $nameWords
        );

        $tableHeader = [
          $this->trans('commands.create.terms.messages.term-id'),
          $this->trans('commands.create.terms.messages.vocabulary'),
          $this->trans('commands.create.terms.messages.name'),
        ];

        $io->table($tableHeader, $terms['success']);

        $io->success(
            sprintf(
                $this->trans('commands.create.terms.messages.created-terms'),
                $limit
            )
        );
    }
}
