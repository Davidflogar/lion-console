<?php

namespace Lion\LionConsole\Controllers;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'create:controller', description: "Creates a new controller.")]
class CreateController extends Command
{

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // get root path and controller name
        $root = getcwd();
        $name = $input->getArgument("name");

        $progressBar = new ProgressBar($output, 100);

        // start and display the progress bar
        $output->writeln("Creating controller...");
        $progressBar->start();

        /**
         * Create the file
         */
        $file = fopen("$root/src/Controllers/$name.php", "w");

        $progressBar->advance(25);

        // catch error
        if ($file != false)
        {

        /**
         * Write in the file
         */
        $controller = "<?php

namespace App\Controller;

class $name extends Controller
{

}

?>
";

            fwrite($file, $controller);

            $progressBar->advance(25);

            /**
             * Close the file
             */
            fclose($file);
            $progressBar->advance(25);

            $progressBar->finish();

            $output->writeln("");

            $io = new SymfonyStyle($input, $output);

            $io->success("Controller created");

            return Command::SUCCESS;
        }
        else
        {
            $io = new SymfonyStyle($input, $output);

            $io->writeln("");

            // Write to the error output
            $io->getErrorStyle()->error([
                'Cannot create controller.',
                'Check that the directories (src/Controllers) for the controller exist and that you have the necessary permissions.'
            ]);

            return Command::FAILURE;
        }
    }

    protected function configure(): void
    {
        $this
            ->setHelp("This command creats a new controller.")
            ->addArgument("name", InputArgument::REQUIRED, "The name of the controller.")
        ;
    }
}

?>