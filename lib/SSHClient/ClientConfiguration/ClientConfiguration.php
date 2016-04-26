<?php
/**
 * @author jah
 * @license MIT License (Expat)
 */

namespace SSHClient\ClientConfiguration;

class ClientConfiguration implements ClientConfigurationInterface
{
    const DEFAULT_SCP_BINARY_PATH = 'scp';
    const DEFAULT_SSH_BINARY_PATH = 'ssh';

    protected $hostname;
    protected $username;
    protected $scpOptions = array();
    protected $sshOptions = array();
    protected $options = array();
    protected $pathToBinary;
    protected $pathToScpBinary;

    public function __construct(
        $hostname,
        $username = null,
        $sshBinaryPath = self::DEFAULT_SSH_BINARY_PATH,
        $scpBinaryPath = self::DEFAULT_SCP_BINARY_PATH
    ) {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->pathToBinary = $sshBinaryPath;
        $this->pathToScpBinary = $scpBinaryPath;
    }

    public function getHostname()
    {
        return $this->hostname;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSCPOptions()
    {
        return $this->scpOptions;
    }

    public function setSCPOptions($options)
    {
        $this->scpOptions = $options;
        return $this;
    }

    public function getSSHOptions()
    {
        return $this->sshOptions;
    }

    public function setSSHOptions($options)
    {
        $this->sshOptions = $options;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    public function getPathToBinary()
    {
        return $this->pathToBinary;
    }

    public function getPathToScpBinary()
    {
        return $this->pathToScpBinary;
    }
}