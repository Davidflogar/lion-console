<?php

namespace Lion\LionConsole;

use Exception;

class CommandLoader
{
    /**
     * Command list.
     */
    private static ?CommandLoader $instance = null;

    /**
     * Base directory to search for classes.
     */

    private $base_dir;

    /**
     * Constructor.
     */
    function __construct($base_dir = null)
    {
        if(!is_null($base_dir))
        {
            $this->base_dir = $base_dir;
        }

        spl_autoload_register([$this, 'autoload']);
    }

    /**
     * Autoloader.
     */
    public function autoload($class)
    {
        $parts = explode('\\', $class);
        if ($parts[0] != 'Lion' || $parts[1] != 'LionConsole') {
            throw new Exception('All classes must be on "Lion\LionConsole" Namespace.
                                        '. "\n" . 'Namespace Used: ' . implode('\\', $parts));
        }

        unset($parts[0], $parts[1]);
        $filename = implode(DIRECTORY_SEPARATOR, $parts) . '.php';

        if(file_exists($this->base_dir . DIRECTORY_SEPARATOR . "Commands" . DIRECTORY_SEPARATOR . $filename))
        {
            require_once $this->base_dir . DIRECTORY_SEPARATOR . "Commands" . DIRECTORY_SEPARATOR . $filename;
        }
    }

    /**
     * Returns the instance.
     * 
     * @param string $base_dir
     * 
     * @return \Lion\LionConsole\CommandLoader
     */
    public static function getInstance($base_dir): CommandLoader
    {
        if (!self::$instance instanceof self) self::$instance = new self($base_dir);
        return self::$instance;
    }
}

?>