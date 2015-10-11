<?php

require_once __DIR__ . '/../vendor/autoload.php';

function foo($a, $b) {
	return 'original foo';
}

class MockFunctionTest extends PHPUnit_Framework_TestCase {

	public function tearDown()
	{
		MockFunction::resetAll();
	}

	public function testArgumentsMatcher_WithBasicArgs()
	{
		// given
		$mock = MockFunction::stub('foo')->withArguments([1, 2])->andReturn(15);

		// when
		$result = $mock->argumentsMatch([1, 2]);

		// then
		$this->assertTrue($result, "The arguments matcher should work in the most basic form");
	}

	public function testArgumentsMatcher_WithMixedUpArgs()
	{
		// given
		$mock = MockFunction::stub('foo')->withArguments([1, 2])->andReturn(15);

		// when
		$result = $mock->argumentsMatch([2, 3]);

		// then
		$this->assertFalse($result, "The arguments matcher should return false for arguments that do not match");
	}

}