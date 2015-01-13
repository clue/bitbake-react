# clue/bitbake-react [![Build Status](https://travis-ci.org/clue/php-bitbake-react.svg?branch=master)](https://travis-ci.org/clue/php-bitbake-react)

Programmatically control your [bitbake](https://github.com/openembedded/bitbake) build shell, built on top of [React PHP](http://reactphp.org/).

> Note: This project is in early alpha stage! Feel free to report any issues you encounter.

## Quickstart example

Once [installed](#install), you can use the following code to tell bitbake to
build the linux kernel:

```php
$loop = React\EventLoop\Factory::create();
$launcher = new Launcher($loop);
$launcher->setBinSsh('my-build-hostname.local', '~/path/to/bitbake');
$shell = $launcher->launchInteractiveShell();

$shell->build('linux')->then(function ($output) {
     echo 'Successfully compiled: ' . $output . PHP_EOL;
});

$shell->end();
$loop->run();
```

See also the [examples](examples).

## Install

The recommended way to install this library is [through composer](http://getcomposer.org). [New to composer?](http://getcomposer.org/doc/00-intro.md)

```JSON
{
    "require": {
        "clue/bitbake-react": "dev-master"
    }
}
```

## License

MIT
