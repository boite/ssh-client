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
        $this->builder = $this
            ->getMockBuilder(ClientBuilder::class)
            ->setConstructorArgs(array($this->config))
            ->setMethods(array('setArguments', 'getProcess', 'getRemotePathPrefix'))
            ->getMock()
        ;
    }

    public function testExec()
    {
        $commandArgs = array('ls', '-ahl');

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

        $this->builder->buildClient()->exec($commandArgs);
    }

    public function testCopy()
    {
        $fromPath = 'from_path';
        $toPath = 'to_path';

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

        $this->builder->buildSecureCopyClient()->copy($fromPath, $toPath);
    }

    public function testGetRemotePath()
    {
        $path = 'path';

        $this
            ->builder
            ->expects($this->once())
            ->method('getRemotePathPrefix')
            ->willReturn('some_prefix:')
        ;

        $this->assertEquals(
            'some_prefix:path',
            $this->builder->buildSecureCopyClient()->getRemotePath($path)
        );
    }

    public function testGetOutput()
    {
        $commandArgs = array('ls', '-ahl');

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

        $this->assertEquals(
            'hi',
            $this->builder->buildClient()->exec($commandArgs)->getOutput()
        );
    }

    public function testGetErrorOutput()
    {
        $commandArgs = array('ls', '-ahl');

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
            'error',
            $this->builder->buildClient()->exec($commandArgs)->getErrorOutput()
        );
    }

    public function testGetExitCode()
    {
        $commandArgs = array('ls', '-ahl');

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
            0, $this->builder->buildClient()->exec($commandArgs)->getExitCode()
        );
    }
}