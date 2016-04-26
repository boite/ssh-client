Invoke OpenSSH from PHP.

    $ cat example.php
    require_once 'path/to/vendor/autoload.php';

    use SSHClient\ClientConfiguration\ClientConfiguration;
    use SSHClient\ClientBuilder\ClientBuilder;

    # Create a config for the target host

    $config = new ClientConfiguration('myhost.example.com', 'boite');
    $config->setOptions(array(
        'IdentityFile' => '~/.ssh/id_ed25519',
        'IdentitiesOnly' => 'yes',
    ));

    # Use the config to create a client builder for the target host

    $builder = new ClientBuilder($config);

    # build a Secure Copy client and copy some files to the target host

    $config->setSCPOptions(array('r'));
    $scp_client = $builder->buildSecureCopyClient();
    $scp_client->copy('path/to/somedir', 'boite@myhost.example.com:~/');

    # build an SSH client and run a command on the target host

    $ssh_client = $builder->buildClient();
    print($ssh_client->exec(array('cat', '~/somedir/test.txt'))->getOutput());
    # end example.php

    $ mkdir -p path/to/somedir
    $ echo "Let's perform a quirkafleeg." > path/to/somedir/test.txt
    $ php example.php
    Let's perform a quirkafleeg.
    $

OpenSSH's config file can be relied on for configuration of SSH and
SCP clients:-

    $ cat ~/.ssh/config
    Host attic attic.example.com
        Hostname attic.example.com
        Port 10022
        IdentitiesOnly yes
        IdentityFile ~/.ssh/id_ed25519
        User willy

    $ cat another-example.php
    require_once 'path/to/vendor/autoload.php';

    use SSHClient\ClientConfiguration\ClientConfiguration;
    use SSHClient\ClientBuilder\ClientBuilder;

    $config = new ClientConfiguration('attic', 'willy');
    $builder = new ClientBuilder($config);

    $ssh_client = $builder->buildClient();
    print($ssh_client->exec(array('hostname'))->getOutput());
    print($ssh_client->exec(array('whoami'))->getOutput());
    # end another-example.php

    $ php another-example.php
    attic.example.com
    willy
    $

