<?php

use Clue\React\Bitbake\InteractiveShell;
use React\Promise\Deferred;

class InteractiveShellTest extends TestCase
{
    private $shell;
    private $interactive;

    public function setUp()
    {
        $this->shell = $this->getMockBuilder('Clue\React\Shell\DeferredShell')->disableOriginalConstructor()->getMock();
        $this->interactive = new InteractiveShell($this->shell);
    }

    public function testBuild()
    {
        $value = 'build output';

        $this->expectExecuteWillReturn('build a', $value);
        $this->expectPromiseResolveWith($value, $this->interactive->build('a'));
    }

    public function testClean()
    {
        $value = 'clean output';

        $this->expectExecuteWillReturn('clean a', $value);
        $this->expectPromiseResolveWith($value, $this->interactive->clean('a'));
    }

    public function testCompile()
    {
        $value = 'compile output';

        $this->expectExecuteWillReturn('compile a', $value);
        $this->expectPromiseResolveWith($value, $this->interactive->compile('a'));
    }

    public function testFetch()
    {
        $value = 'fetch output';

        $this->expectExecuteWillReturn('fetch a', $value);
        $this->expectPromiseResolveWith($value, $this->interactive->fetch('a'));
    }

    public function testHelp()
    {
        $value = 'help output';

        $this->expectExecuteWillReturn('help', $value);
        $this->expectPromiseResolveWith($value, $this->interactive->help());
    }

    public function testParse()
    {
        $value = 'parse output';

        $this->expectExecuteWillReturn('parse', $value);
        $this->expectPromiseResolveWith($value, $this->interactive->parse());
    }

    public function testPeek()
    {
        $value = 'peek output';

        $this->expectExecuteWillReturn('peek a key', $value);
        $this->expectPromiseResolveWith($value, $this->interactive->peek('a', 'key'));
    }

    public function testPoke()
    {
        $value = 'poke output';

        $this->expectExecuteWillReturn('poke a key value', $value);
        $this->expectPromiseResolveWith($value, $this->interactive->poke('a', 'key', 'value'));
    }

    public function testRebuild()
    {
        $value = 'rebuild output';

        $this->expectExecuteWillReturn('rebuild a', $value);
        $this->expectPromiseResolveWith($value, $this->interactive->rebuild('a'));
    }

    public function testReparse()
    {
        $value = 'reparse output';

        $this->expectExecuteWillReturn('reparse a', $value);
        $this->expectPromiseResolveWith($value, $this->interactive->reparse('a'));
    }

    public function testShell()
    {
        $value = 'shell output';

        $this->expectExecuteWillReturn('shell echo test', $value);
        $this->expectPromiseResolveWith($value, $this->interactive->shell('echo test'));
    }

    public function testEnd()
    {
        $this->shell->expects($this->once())->method('end');
        $this->interactive->end();
    }

    public function testClose()
    {
        $this->shell->expects($this->once())->method('close');
        $this->interactive->close();
    }

    private function expectExecuteWillReturn($command, $return)
    {
        $return = "\nBB>> " . $return . "\nBB>> ";

        $this->shell->expects($this->once())->method('execute')->with($this->equalTo($command))->will($this->returnValue($this->createPromiseResolved($return)));
    }

    private function createPromiseResolved($with)
    {
        $deferred = new Deferred();
        $deferred->resolve($with);

        return $deferred->promise();
    }
}
