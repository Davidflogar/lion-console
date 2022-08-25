<?php

namespace Lion\LionConsole;

use Symfony\Component\Console\Application;

/**
 * Main class for console commands.
 */
class Lion
{
    /**
     * App
     * @var \Symfony\Component\Console\Application
     */
    private $app;

    /**
     * The base directory to search for commands.
     * 
     * @var string
     */
    public const BASE_DIR = __DIR__;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->app = new Application();
    }

    /**
     * Registers all the commands.
     * 
     * @return void
     */
    public function register($path = self::BASE_DIR . DIRECTORY_SEPARATOR . "Commands"): void
    {
        //Here all folders within the "Commands" directory are read recursively.
        //
        //After that all the files inside those folders are read and the console commands are loaded.
        $folders = scandir($path);

        foreach($folders as $_ => $value)
        {
            if(is_dir($path . DIRECTORY_SEPARATOR. $value))
            {
                if ($value != "." && $value != "..")
                {
                    $this->register($path . DIRECTORY_SEPARATOR. $value);
                }
            }
            else
            {
                // $parent_dir is the parent folder of the file
                $parent_dir = explode(DIRECTORY_SEPARATOR, dirname($path . DIRECTORY_SEPARATOR. $value));
                $parent_dir = end($parent_dir);
                $parent_dir = str_replace(".php", "", $parent_dir . "\\" . $value);

                $full_namespace = "Lion\\LionConsole\\" . $parent_dir;

                $this->app->add(new $full_namespace);
            }
        }
    }

    /**
     * Sets the default command.
     * 
     * @return void
     */
    private function set_default_command(): void
    {
        $this->app->setDefaultCommand("welcome");
    }

    /**
     * Runs the app
     * 
     * @return void
     */
    public function roar(): void
    {
        $this->set_default_command();
        $this->app->setVersion("1.0.0");
        $this->app->setName("The Lion framework.");

        $this->app->run();
    }
}

?>