<?php

namespace Clue\React\Bitbake;

use React\EventLoop\LoopInterface;
use Clue\React\Shell\ProcessLauncher;

class Launcher
{
    private $processLauncher;
    private $bin = 'bitbake -i';

    public function __construct(LoopInterface $loop, ProcessLauncher $processLauncher = null)
    {
        if ($processLauncher === null) {
            $processLauncher = new ProcessLauncher($loop);
        }

        $this->processLauncher = $processLauncher;
    }

    /**
     * Set path to bitbake executable/binary
     *
     * @param string $bin
     */
    public function setBinLocal($bin = 'bitbake')
    {
        $bin .= ' -i 2>&1';
        $this->bin = $bin;
    }

    /**
     * Set path to bitbake executable via SSH
     *
     * Uses "script" to run bitbake within a pseudo terminal (pty) to enforce interactive
     * behavior. The "-i" argument will be added to the bitbake binary automatically.
     *
     * @param string $host
     * @param string $bin
     * @link http://unix.stackexchange.com/a/61833 for source
     */
    public function setBinSsh($host, $bin = 'bitbake')
    {
        $bin .= ' -i 2>&1';
        $this->bin = 'ssh -tq ' . escapeshellarg($host) . ' ' . escapeshellarg('script -q -c ' . escapeshellarg($bin) . ' /dev/null');
    }

    public function launchInteractiveShell()
    {
        $shell = $this->processLauncher->createDeferredShell($this->bin);
        $shell->setBounding('shell echo {{ bounding }}');

        return new InteractiveShell($shell);
    }
}
