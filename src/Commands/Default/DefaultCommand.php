<?php

namespace Lion\LionConsole\Default;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\DescriptorHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'welcome', description: "Prints the welcome text.", hidden: true)]
class DefaultCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = new DescriptorHelper();
        $helper->describe($output, $this->getApplication());

        return 0;
    }
}

?>