<?php
/**
 * @author jah
 * @license MIT License (Expat)
 */

namespace SSHClient\Client;

use SSHClient\ClientBuilder\ClientBuilder;
use SSHClient\ClientConfiguration\ClientConfiguration;

use Symfony\Component\Process\Process;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    private $process;
    private $config;
    private $builder;

    public function setUp()
    {
        $this->process = $this
            ->getMockBuilder(Process::class)
            ->setMethods(array('run', 'getOutput', 'getErrorOutput', 'getExitCode'))
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->config = new ClientConfiguration(
            'some_hostname', 'some_username'
        );
        $this->builder = $this->getMock(
            ClientBuilder::class,
            array('getProcess', 'setArguments'),
            array($this->config)
        );
    }

    public function testExec()
    {
        $commandArgs = array('ls', '-ahl');

        $client = $this->builder->buildClient();

        $this
            ->builder
            ->expects($this->once())
            ->method('setArguments')
            ->with($commandArgs)
            ->will($this->returnSelf())
        ;
        $this
            ->builder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($this->process))
        ;
        $this
            ->process
            ->expects($this->once())
            ->method('run')
        ;

        $client->exec($commandArgs);
    }

    public function testCopy()
    {
        $fromPath = 'from_path';
        $toPath = 'to_path';

        $client = $this->builder->buildSecureCopyClient();

        $this
            ->builder
            ->expects($this->once())
            ->method('setArguments')
            ->with(array($fromPath, $toPath))
            ->will($this->returnSelf())
        ;
        $this
            ->builder
            ->expects($this->once())
            ->method('getProcess')
            ->will($this->returnValue($this->process))
        ;
        $this
            ->process
            ->expects($this->once())
            ->method('run')
        ;

        $client->copy($fromPath, $toPath);
    }

    public function testGetOutput()
    {
        $commandArgs = array('ls', '-ahl');

        $client = $this->builder->buildClient();

        $this
            ->builder
            ->method('setArguments')
            ->with($commandArgs)
            ->will($this->returnSelf())
        ;
        $this
            ->builder
            ->method('getProcess')
            ->will($this->returnValue($this->process))
        ;
        $this
            ->process
            ->expects($this->once())
            ->method('getOutput')
            ->will($this->returnValue('hi'))
        ;

        $this->assertEquals('hi', $client->exec($commandArgs)->getOutput());
    }

    public function testGetErrorOutput()
    {
        $commandArgs = array('ls', '-ahl');

        $client = $this->builder->buildClient();

        $this
            ->builder
            ->method('setArguments')
            ->with($commandArgs)
            ->will($this->returnSelf())
        ;
        $this
            ->builder
            ->method('getProcess')
            ->will($this->returnValue($this->process))
        ;
        $this
            ->process
            ->expects($this->once())
            ->method('getErrorOutput')
            ->will($this->returnValue('error'))
        ;

        $this->assertEquals(
            'error', $client->exec($commandArgs)->getErrorOutput()
        );
    }

    public function testGetExitCode()
    {
        $commandArgs = array('ls', '-ahl');

        $client = $this->builder->buildClient();

        $this
            ->builder
            ->method('setArguments')
            ->with($commandArgs)
            ->will($this->returnSelf())
        ;
        $this
            ->builder
            ->method('getProcess')
            ->will($this->returnValue($this->process))
        ;
        $this
            ->process
            ->expects($this->once())
            ->method('getExitCode')
            ->will($this->returnValue(0))
        ;

        $this->assertEquals(
            0, $client->exec($commandArgs)->getExitCode()
        );
    }
}