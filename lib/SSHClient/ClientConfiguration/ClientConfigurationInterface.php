<?php
/**
 * @author jah
 * @license MIT License (Expat)
 */

namespace SSHClient\ClientConfiguration;

interface ClientConfigurationInterface
{
    /**
     * @api
     *
     * @return string
     */
    public function getHostname();

    /**
     * @api
     *
     * @return string
     */
    public function getUsername();

    /**
     * Get scp command line options.
     *
     * @api
     *
     * @return array
     */
    public function getSCPOptions();

    /**
     * Set scp command line options.
     *
     * @api
     *
     * @param array $options
     *
     * @return \SSHClient\ClientConfiguration\ClientConfigurationInterface
     */
    public function setSCPOptions($options);

    /**
     * Get ssh command line options.
     *
     * @api
     *
     * @return array
     */
    public function getSSHOptions();

    /**
     * Set ssh command line options.
     *
     * @api
     *
     * @param array $options
     *
     * @return \SSHClient\ClientConfiguration\ClientConfigurationInterface
     */
    public function setSSHOptions($options);

    /**
     * Get OpenSSH ssh_options (i.e. those such as -o Port=22).
     *
     * @api
     *
     * @return array
     */
    public function getOptions();

    /**
     * Set OpenSSH ssh_options (i.e. those such as -o Port=22).
     *
     * @api
     *
     * @param array $options
     *
     * @return \SSHClient\ClientConfiguration\ClientConfigurationInterface
     */
    public function setOptions($options);

    /**
     * @api
     *
     * @return string
     */
    public function getPathToBinary();

    /**
     * @api
     *
     * @return string
     */
    public function getPathToScpBinary();
}