<?php

namespace Fillet\FilletBundle\Command;

use Fillet\Parser\ParserFactory;
use Sculpin\Core\Console\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Fillet\Fillet;

/**
 * Command for wrapping Fillet
 *
 * @package Fillet\FilletBundle\Command
 */
class FilletCommand extends ContainerAwareCommand
{
    /**
     * Configuration information
     */
    protected function configure()
    {
        $this
            ->setName('fillet:fillet')
            ->setDescription('Turns an export into a set of Sculpin HTML files')
            ->addOption('file', 'f', InputOption::VALUE_REQUIRED, 'File to process')
            ->addOption('parser', 'p', InputOption::VALUE_REQUIRED, 'Parser to use')
            ->addOption('sourcedir', 's', InputOption::VALUE_OPTIONAL, 'Location of the source directory')
        ;
    }

    /**
     * Calls Fillet
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getOption('file');
        $parser = $input->getOption('parser');
        $sourceDir = $input->getOption('sourcedir');

        $file = realpath($file);
        if(false === $file) {
            $output->writeln('File does not exist. Aborting.');
            return;
        }

        if(empty($sourceDir)) {
            $sourceDir = realpath(getcwd() . '/source');
        }

        $parser = ParserFactory::create($parser);

        if(!is_dir($sourceDir)) {
            $output->writeln('Could not determine the source directory to write to. Please pass a valid directory with --sourcedir=path/to/source');
            return;
        }

        $config = [
            'destinationFolders' => [
                'page' => $sourceDir . '/',
                'post' => $sourceDir . '/_posts/',
            ]
        ];

        $fillet = new Fillet($parser, $file, $config);
        $fillet->parse();

        $output->writeln('Finished processing. Make sure everything looks OK.');
    }
}