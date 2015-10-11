<?php

class MockFunctionContainer {

	private static $instances = array();

	public static function register($mockFunctionId, $mockFunction)
	{
		self::$instances[$mockFunctionId] = $mockFunction;
	}

	public static function unregister($mockFunctionId)
	{
		unset(self::$instances[$mockFunctionId]);
	}

	public static function call($mockFunctionId, $arguments = [])
	{
		if (!array_key_exists($mockFunctionId, self::$instances)) {
			throw new Exception("Function with id $mockFunctionId not registered");
		}

		$mock = self::$instances[$mockFunctionId];

		if ($mock->argumentsMatch($arguments)) {
			return $mock->call($arguments);
		} else {
			return $mock->callOriginalFunction($arguments);
		}
	}

	public static function resetAll()
	{
		foreach (self::$instances as $instance) {
			$instance->reset();
		}
	}
}


class MockFunction {

	protected $funcName;

	protected $tmpFuncName;

	protected $parameters;

	protected $arguments;

	public $returnValue;

	public $callCount;

	public function __construct($funcName)
	{
		$this->funcName = $funcName;
		$this->tmpFuncName = $funcName . '_original_function';
		$this->callCount = 0;
	}

	/**
	 * @return self for fluent construction of function mock
	 */
	public static function stub($funcName)
	{
		$mock = new self($funcName);

		$mock->replaceFunction();

		return $mock;
	}

	/**
	 * @return self for fluent construction of function mock
	 */
	public function andReturn($returnValue)
	{
		$this->returnValue = $returnValue;

		return $this;
	}

	/**
	 * @return self for fluent construction of function mock
	 */
	public function withArguments($arguments)
	{
		$this->arguments = $arguments;

		return $this;
	}

	private function getParameters($funcName)
	{
		$function = new ReflectionFunction($funcName);

		$parameters = array();
		
		foreach ($function->getParameters() as $parameter) {
			$parameters[] = '$' . $parameter->name;
		}

		$parameters = join(',', $parameters);

		return $parameters;
	}

	private function replaceFunction()
	{
		$funcName = $this->funcName;

		$this->parameters = $this->getParameters($funcName);

		runkit_function_copy($funcName, $this->tmpFuncName);

		$result = runkit_function_redefine($this->funcName, $this->parameters, 
			"return MockFunctionContainer::call('$funcName', func_get_args());");

		if (!$result) {
			throw new Exception("Error trying to replace function");
		}

		MockFunctionContainer::register($funcName, $this);
	}

	public static function resetAll()
	{
		MockFunctionContainer::resetAll();
	}

	/**
	 * Restore the original function
	 */
	public function reset()
	{
		runkit_function_remove($this->funcName);
		runkit_function_rename($this->tmpFuncName, $this->funcName);

		MockFunctionContainer::unregister($this->funcName);
	}

	/**
	 * @param $arguments array - the list of arguments to test against
	 * @return boolean - true if the arguments match the expected arguments
	 */
	public function argumentsMatch(array $arguments)
	{
		return true;
		return $this->arguments === $arguments;
	}

	/**
	 * Runs the stub. Returns the predefined return value instead of the 
	 * using the original function
	 */
	public function call()
	{
		$this->callCount++;

		return $this->returnValue;
	}

	/**
	 * @param $arguments array
	 * @return the result of the original function
	 */
	public function callOriginalFunction(array $arguments)
	{
		return call_user_func($this->tmpFuncName, $arguments);
	}
}
