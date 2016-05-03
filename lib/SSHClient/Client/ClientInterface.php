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
     * @param integer $timeout in seconds
     * @param bool $disableTimeout
     *
     * @return \SSHClient\Client\ClientInterface
     */
    public function exec(
        array $commandArguments,
        $callback = null,
        $timeout = null,
        $disableTimeout = false
    );

    /**
     * @api
     *
     * @param string $fromPath
     * @param string $toPath
     * @param null|callable $callback
     * @param integer $timeout in seconds
     * @param bool $disableTimeout
     *
     * @return \SSHClient\Client\ClientInterface
     */
    public function copy(
        $fromPath,
        $toPath,
        $callback = null,
        $timeout = null,
        $disableTimeout = false
    );

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

    /**
     * Get the path to a remote file system resource.
     *
     * @api
     *
     * @param string $path
     *
     * @return string
     */
    public function getRemotePath($path);
}