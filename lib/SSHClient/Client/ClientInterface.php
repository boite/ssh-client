<?php
/**
 * @author jah
 * @license MIT License (Expat)
 */

namespace SSHClient\Client;

interface ClientInterface
{
    /**
     * @api
     *
     * @param array $commandArguments
     * @param null|callable $callback
     *
     * @return \SSHClient\Client\ClientInterface
     */
    public function exec(array $commandArguments, $callback = null);

    /**
     * @api
     *
     * @param string $fromPath
     * @param string $toPath
     * @param null|callable $callback
     *
     * @return \SSHClient\Client\ClientInterface
     */
    public function copy($fromPath, $toPath, $callback = null);

    /**
     * @api
     *
     * @return string
     */
    public function getOutput();

    /**
     * @api
     *
     * @return string
     */
    public function getErrorOutput();

    /**
     * @api
     *
     * @return integer
     */
    public function getExitCode();
}