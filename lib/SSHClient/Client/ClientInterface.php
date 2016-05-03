<?php
/**
 * @author jah
 * @license MIT License (Expat)
 */

namespace SSHClient\Client;

interface ClientInterface
{
    /**
     * Execute commands on a remote host.
     *
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
     * Non-blocking command execution.
     *
     * This method will return immediately.
     * @api
     *
     * @param array $commandArguments
     * @param null|callable $callback
     * @param integer $timeout in seconds
     * @param bool $disableTimeout
     *
     * @return \SSHClient\Client\ClientInterface
     */
    public function startExec(
        array $commandArguments,
        $callback = null,
        $timeout = null,
        $disableTimeout = false
    );

    /**
     * Copy files between hosts.
     *
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
     * Non-blocking copy.
     *
     * This method will return immediately.
     *
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
    public function startCopy(
        $fromPath,
        $toPath,
        $callback = null,
        $timeout = null,
        $disableTimeout = false
    );

    /**
     * Get the standard output of an exec or copy operation.
     *
     * @api
     *
     * @return null|string
     */
    public function getOutput();

    /**
     * Get the standard error output of an exec or copy operation.
     *
     * @api
     *
     * @return null|string
     */
    public function getErrorOutput();

    /**
     * Get the exit code of an exec or copy operation.
     *
     * @api
     *
     * @return null|integer
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

    /**
     * Find out if an exec or copy operation has timed-out.
     *
     * @api
     *
     * @return null|boolean
     */
    public function isTimedOut();

    /**
     * Find out if a non-blocking exec or copy operation is running.
     *
     * @api
     *
     * @return null|boolean
     */
    public function isRunning();
}