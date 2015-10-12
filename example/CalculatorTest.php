// <?php

// require_once __DIR__ . '/../vendor/autoload.php';

// class CalculatorTest extends PHPUnit_Framework_TestCase {

// 	public function tearDown()
// 	{
// 		MockFunction::resetAll();
// 	}

// 	public function testCalculateSum()
// 	{
// 		// given
// 		$addMockFn = MockFunction::stub('Calculator\add')->andReturn(15);

// 		// when
// 		$result = Calculator\safe_sum(5, 10);

// 		// then
// 		$this->assertEquals(15, $result);
// 	}

// 	public function testCalculateSum_UsesTheAddFunction()
// 	{
// 		// given
// 		$addMockFn = MockFunction::stub('Calculator\add');

// 		// when
// 		Calculator\safe_sum(5, 10);

// 		// then
// 		$this->assertEquals(1, $addMockFn->callCount, "Add function should be called once");
// 	}

// 	public function testCalculateSumAgain()
// 	{
// 		// given
// 		$addMockFn = MockFunction::stub('Calculator\add')->andReturn(35);

// 		// when
// 		$result = Calculator\safe_sum(25, 10);

// 		// then
// 		$this->assertEquals(35, $result);
// 	}

// 	public function testCalculateSum_PassingNumericStringWorks()
// 	{
// 		// given
// 		$addMockFn = MockFunction::stub('Calculator\add')->andReturn(35);

// 		// when
// 		$result = Calculator\safe_sum("25", 10);

// 		// then
// 		$this->assertEquals(35, $result);
// 	}

// 	public function testCalculateSum_PassingNonNumericStringThrowsException()
// 	{
// 		// given
// 		$addMockFn = MockFunction::stub('Calculator\add')->andReturn(35);

// 		// then
//         $this->setExpectedException(InvalidArgumentException::class);

// 		// when
// 		Calculator\safe_sum("twenty-five", 10);
// 	}

// }
