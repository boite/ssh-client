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

    public function exec(array $commandArguments, $callback = null)
    {
        $this->process = $this
            ->builder
            ->setArguments($commandArguments)
            ->getProcess()
        ;
        $this->process->run($callback);
        return $this;
    }

    public function copy($fromPath, $toPath, $callback = null)
    {
        $this->process = $this
            ->builder
            ->setArguments(array($fromPath, $toPath))
            ->getProcess()
        ;
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
}