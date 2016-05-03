<?php
/**
 * @author jah
 * @license MIT License (Expat)
 */

namespace SSHClient\Client;

use SSHClient\ClientBuilder\ClientBuilderInterface;

class Client implements ClientInterface
{
    /**
     * @var \Symfony\Component\Process\Process
     */
    protected $process;

    protected $builder;

    public function __construct(ClientBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function exec(
        array $commandArguments,
        $callback = null,
        $timeout = null,
        $disableTimeout = false
    ) {
        $this->process = $this
            ->builder
            ->setArguments($commandArguments)
            ->getProcess()
        ;

        if ($disableTimeout) {
            $this->process->setTimeout(null);
        } else if ($timeout) {
            $this->process->setTimeout($timeout);
        }

        $this->process->run($callback);

        return $this;
    }

    public function copy(
        $fromPath,
        $toPath,
        $callback = null,
        $timeout = null,
        $disableTimeout = false
    ) {
        $this->process = $this
            ->builder
            ->setArguments(array($fromPath, $toPath))
            ->getProcess()
        ;

        if ($disableTimeout) {
            $this->process->setTimeout(null);
        } else if ($timeout) {
            $this->process->setTimeout($timeout);
        }

        $this->process->run($callback);

        return $this;
    }

    public function getOutput()
    {
        return $this->process ? $this->process->getOutput() : null;
    }

    public function getErrorOutput()
    {
        return $this->process ? $this->process->getErrorOutput() : null;
    }

    public function getExitCode()
    {
        return $this->process ? $this->process->getExitCode() : null;
    }

    public function getRemotePath($path)
    {
        return $this->builder->getRemotePathPrefix() . $path;
    }
}