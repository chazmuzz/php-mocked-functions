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

	public function testArgumentsMatcher_WithEqualIntegerArgs()
	{
		// given
		$mock = MockFunction::stub('foo')->withArguments([1, 2])->andReturn(15);

		// when
		$result = $mock->argumentsMatch([1, 2]);

		// then
		$this->assertTrue($result, "The arguments matcher should work in the most basic form");
	}

	public function testArgumentsMatcher_WithEqualStringArgs()
	{
		// given
		$mock = MockFunction::stub('foo')->withArguments(["foo", "bar"])->andReturn(15);

		// when
		$result = $mock->argumentsMatch(["foo", "bar"]);

		// then
		$this->assertTrue($result, "The arguments matcher should work in the most basic form");
	}

	public function testArgumentsMatcher_WithIncorrectArgs()
	{
		// given
		$mock = MockFunction::stub('foo')->withArguments([1, 2])->andReturn(15);

		// when
		$result = $mock->argumentsMatch([3, 4]);

		// then
		$this->assertFalse($result, "The arguments matcher should return false for arguments that do not match");
	}

	public function testArgumentsMatcher_WithDifferentNumberOfArgs()
	{
		// given
		$mock = MockFunction::stub('foo')->withArguments([1, 2])->andReturn(15);

		// when
		$result = $mock->argumentsMatch([1, 2, 3, 4]);

		// then
		$this->assertFalse($result, "The arguments matcher should return false for arguments that do not match");
	}


	public function testArgumentsMatcher_WithArrayAsArg()
	{
		// given
		$mock = MockFunction::stub('foo')->withArguments([[1, 2]])->andReturn(15);

		// when
		$result = $mock->argumentsMatch([[1, 2]]);

		// then
		$this->assertTrue($result, "The arguments matcher should return true for arguments that match");
	}

	public function testArgumentsMatcher_WithNestedArraysAsArg()
	{
		// given
		$mock = MockFunction::stub('foo')->withArguments([[1, 2, [3, 4]]])->andReturn(15);

		// when
		$result = $mock->argumentsMatch([[1, 2, [3, 4]]]);

		// then
		$this->assertTrue($result, "The arguments matcher should return true for arguments that match");
	}

	public function testArgumentsMatcher_WithNonMatchingNestedArraysAsArg()
	{
		// given
		$mock = MockFunction::stub('foo')->withArguments([[1, 2, [3, 4]]])->andReturn(15);

		// when
		$result = $mock->argumentsMatch([[1, 2, [4, 3]]]);

		// then
		$this->assertFalse($result, "The arguments matcher should return true for arguments that match");
	}

}