<?php
/**
 * @author jah
 * @license MIT License (Expat)
 */

namespace SSHClient\ClientBuilder;

use Symfony\Component\Process\ProcessBuilder;

use SSHClient\ClientConfiguration\ClientConfigurationInterface;

abstract class ClientBuilderAbstract implements ClientBuilderInterface
{
    protected $config;
    protected $processBuilder;

    public function __construct(ClientConfigurationInterface $config)
    {
        $this->config = $config;
    }

    abstract public function buildClient();

    abstract public function buildSecureCopyClient();

    /**
     * @internal
     *
     * @return array
     */
    public function buildSSHPrefix()
    {
        $prefix = array_merge(
            array($this->config->getPathToBinary()),
            $this->buildSSHOptionOptions($this->config->getOptions()),
            $this->buildOptions($this->config->getSSHOptions())
        );

        if ($this->config->getUsername()) {
            $prefix[] = sprintf(
                '%s@%s', $this->config->getUsername(), $this->config->getHostname()
            );
        } else {
            $prefix[] = $this->config->getHostname();
        }


        return $prefix;
    }

    /**
     * @internal
     *
     * @return array
     */
    public function buildSCPPrefix()
    {
        $prefix = array_merge(
            array($this->config->getPathToScpBinary()),
            $this->buildSSHOptionOptions($this->config->getOptions()),
            $this->buildOptions($this->config->getSCPOptions())
        );

        return $prefix;
    }

    /**
     * @internal
     *
     * @return \Symfony\Component\Process\ProcessBuilder
     */
    public function getProcessBuilder()
    {
        if (!$this->processBuilder) {
            $this->processBuilder = new ProcessBuilder();
        }

        return $this->processBuilder;
    }

    /**
     * This method is used in tests; calling it is not ordinarily required.
     *
     * @param \Symfony\Component\Process\ProcessBuilder
     *
     * @return \SSHClient\ClientBuilder\ClientBuilderInterface
     */
    public function setProcessBuilder(ProcessBuilder $builder)
    {
        $this->processBuilder = $builder;

        return $this;
    }

    /**
     * This method is called from a configured Client to set task-specific
     * arguments before calling getting a client process and running it.
     *
     * @return \SSHClient\ClientBuilder\ClientBuilderInterface
     */
    public function setArguments(array $arguments)
    {
        $this->getProcessBuilder()->setArguments($arguments);

        return $this;
    }

    /**
     * This method is called from a configured Client, after setting arguments,
     * so that the process can be run.
     *
     * @return \Symfony\Component\Process
     */
    public function getProcess()
    {
        return $this->getProcessBuilder()->getProcess();
    }

    private function buildOptions($options)
    {
        $opts = array();
        foreach ($options as $name => $value) {
            if (is_int($name)) {
                $opts[] = sprintf('-%s', $value);
            } else {
                $opts[] = sprintf('-%s %s', $name, $value);
            }
        }

        return $opts;
    }

    private function buildSSHOptionOptions($options)
    {
        $opts = array();
        foreach ($options as $name => $value) {
            $opts[] = sprintf('-o %s=%s', $name, $value);
        }

        return $opts;
    }
}