<?php
/**
 * @author jah
 * @license MIT License (Expat)
 */

namespace SSHClient\ClientBuilder;

use Symfony\Component\Process\ProcessBuilder;

interface ClientBuilderInterface
{
    /**
     * Get an SSH client, configured with options and arguments and ready for
     * calling its exec method.
     *
     * @api
     *
     * @return \SSHClient\Client\ClientInterface
     */
    public function buildClient();

    /**
     * Get a SCP client, configured with options and arguments and ready for
     * calling its copy method.
     *
     * @api
     *
     * @return \SSHClient\Client\ClientInterface
     */
    public function buildSecureCopyClient();
}