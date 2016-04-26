<?php
/**
 * @author jah
 * @license MIT License (Expat)
 */

namespace SSHClient\ClientBuilder;

use SSHClient\Client\Client;

class ClientBuilder extends ClientBuilderAbstract
{
    public function buildClient()
    {
        $this->getProcessBuilder()->setPrefix($this->buildSSHPrefix());

        return new Client($this);
    }

    public function buildSecureCopyClient()
    {
        $this->getProcessBuilder()->setPrefix($this->buildSCPPrefix());

        return new Client($this);
    }
}