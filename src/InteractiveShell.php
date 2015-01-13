<?php

namespace Clue\React\Bitbake;

use Clue\React\Shell\DeferredShell;
use Clue\React\Bitbake\Launcher;

class InteractiveShell
{
    private $shell;

    public function __construct(DeferredShell $shell)
    {
        $this->shell = $shell;
    }

    public function build($providee)
    {
        return $this->exec('build ' . $providee);
    }

    public function clean($providee)
    {
        return $this->exec('clean ' . $providee);
    }

    public function compile($providee)
    {
        return $this->exec('compile ' . $providee);
    }

    public function fetch($providee)
    {
        return $this->exec('fetch ' . $providee);
    }

    public function help()
    {
        return $this->exec('help');
    }

    public function parse()
    {
        return $this->exec('parse');
    }

    public function peek($providee, $variable)
    {
        return $this->exec('peek ' . $providee . ' ' . $variable);
    }

    public function poke($providee, $variable, $value)
    {
        return $this->exec('poke ' . $providee . ' ' . $variable . ' ' . $value);
    }

    public function rebuild($providee)
    {
        return $this->exec('rebuild ' . $providee);
    }

    public function reparse($providee)
    {
        return $this->exec('reparse ' . $providee);
    }

    public function which($providee)
    {
        return $this->exec('which ' . $providee);
    }

    public function shell($command)
    {
        return $this->exec('shell ' . $command);
    }

    public function end()
    {
        return $this->shell->end();
    }

    public function close()
    {
        return $this->shell->close();
    }

    private function exec($command)
    {
        return $this->shell->execute($command)->then(array($this, 'parseResult'));
    }

    /** @internal */
    public function parseResult($val)
    {
        // "\nBB>> "
        return substr($val, 6, -6);
    }
}