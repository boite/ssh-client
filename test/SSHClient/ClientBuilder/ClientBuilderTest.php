<?php
/**
 * @author jah
 * @license MIT License (Expat)
 */

namespace SSHClient\ClientBuilder;

use SSHClient\ClientBuilder\ClientBuilder;
use SSHClient\ClientConfiguration\ClientConfiguration;

use Symfony\Component\Process\ProcessBuilder;

class ClientBuilderTest extends \PHPUnit_Framework_TestCase
{
    private $config;
    private $processBuilder;

    public function setUp()
    {
        $this->config = $this->getMock(
            ClientConfiguration::class,
            array(
                'getPathToBinary',
                'getPathToScpBinary',
                'getSCPOptions',
                'getSSHOptions',
                'getOptions',
                'getUsername',
                'getHostname'
            ),
            array('my_hostname', 'my_user')
        );
        $this->processBuilder = $this->getMock(
            ProcessBuilder::class,
            array('setPrefix', 'setArguments', 'getProcess')
        );
    }

    public function testBuildClient()
    {
        $this
            ->config
            ->method('getPathToBinary')
            ->willReturn('ssh')
        ;
        $this
            ->config
            ->method('getOptions')
            ->willReturn(array())
        ;
        $this
            ->config
            ->method('getSSHOptions')
            ->willReturn(array())
        ;
        $this
            ->config
            ->method('getUsername')
            ->willReturn('my_user')
        ;
        $this
            ->config
            ->method('getHostname')
            ->willReturn('my_hostname')
        ;
        $this
            ->processBuilder
            ->expects($this->at(0))
            ->method('setPrefix')
            ->with(array('ssh', 'my_user@my_hostname'))
        ;

        $builder = new ClientBuilder($this->config);
        $builder
            ->setProcessBuilder($this->processBuilder)
            ->buildClient()
        ;
    }

    public function testBuildSecureCopyClient()
    {
        $this
            ->config
            ->method('getPathToScpBinary')
            ->willReturn('scp')
        ;
        $this
            ->config
            ->method('getOptions')
            ->willReturn(array())
        ;
        $this
            ->config
            ->method('getSCPOptions')
            ->willReturn(array())
        ;
        $this
            ->processBuilder
            ->expects($this->at(0))
            ->method('setPrefix')
            ->with(array('scp'))
        ;

        $builder = new ClientBuilder($this->config);
        $builder
            ->setProcessBuilder($this->processBuilder)
            ->buildSecureCopyClient()
        ;
    }

    public function testBuildSSHPrefix()
    {
        $this
            ->config
            ->expects($this->once())
            ->method('getPathToBinary')
            ->willReturn('/usr/bin/ssh')
        ;
        $this
            ->config
            ->expects($this->once())
            ->method('getOptions')
            ->willReturn(array('Port' => 12322))
        ;
        $this
            ->config
            ->expects($this->once())
            ->method('getSSHOptions')
            ->willReturn(array('q', 'c' => 'blowfish'))
        ;
        $this
            ->config
            ->expects($this->atLeast(1))
            ->method('getUsername')
            ->willReturn('my_user')
        ;
        $this
            ->config
            ->expects($this->once())
            ->method('getHostname')
            ->willReturn('my_hostname')
        ;

        $builder = new ClientBuilder($this->config);

        $this->assertEquals(
            array(
                '/usr/bin/ssh',
                '-o Port=12322',
                '-q',
                '-c blowfish',
                'my_user@my_hostname'
            ),
            $builder->buildSSHPrefix(),
            'buildSSHPrefix constructs the prefix portion of the ssh command line.'
        );
    }

    public function testBuildSCPPrefix()
    {
        $this
            ->config
            ->expects($this->once())
            ->method('getPathToScpBinary')
            ->willReturn('/usr/local/bin/scp')
        ;
        $this
            ->config
            ->expects($this->once())
            ->method('getOptions')
            ->willReturn(array('Port' => 12322))
        ;
        $this
            ->config
            ->expects($this->once())
            ->method('getSCPOptions')
            ->willReturn(array('v'))
        ;

        $builder = new ClientBuilder($this->config);

        $this->assertEquals(
            array(
                '/usr/local/bin/scp',
                '-o Port=12322',
                '-v'
            ),
            $builder->buildSCPPrefix(),
            'buildSCPPrefix constructs the prefix portion of the scp command line.'
        );
    }

    public function testGetRemotePathPrefixContainsUsernameIfAvailable()
    {
        $this
            ->config
            ->expects($this->once())
            ->method('getHostname')
            ->willReturn('rhost')
        ;
        $this
            ->config
            ->expects($this->exactly(2))
            ->method('getUsername')
            ->willReturn('ruser')
        ;

        $builder = new ClientBuilder($this->config);

        $this->assertEquals(
            'ruser@rhost:',
            $builder->getRemotePathPrefix(),
            'getRemotePathPrefix constructs a remote file system path prefix like "user@host:".'
        );
    }

    public function testGetRemotePathPrefixOmitsUsernameIfUnavailable()
    {
        $this
            ->config
            ->expects($this->once())
            ->method('getHostname')
            ->willReturn('rhost')
        ;
        $this
            ->config
            ->expects($this->once())
            ->method('getUsername')
            ->willReturn(null)
        ;

        $builder = new ClientBuilder($this->config);

        $this->assertEquals(
            'rhost:',
            $builder->getRemotePathPrefix(),
            'getRemotePathPrefix constructs a remote file system path prefix like "host:".'
        );
    }

    public function testSetArguments()
    {
        $this
            ->processBuilder
            ->expects($this->at(0))
            ->method('setArguments')
            ->with(array('ls', '-al'))
        ;

        $builder = new ClientBuilder($this->config);
        $builder
            ->setProcessBuilder($this->processBuilder)
            ->setArguments(array('ls', '-al'))
        ;
    }

    public function testGetProcess()
    {
        $this
            ->processBuilder
            ->expects($this->at(0))
            ->method('getProcess')
        ;

        $builder = new ClientBuilder($this->config);
        $builder
            ->setProcessBuilder($this->processBuilder)
            ->setArguments(array('ls', '-al'))
            ->getProcess()
        ;
    }
}