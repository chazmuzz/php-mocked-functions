<?php 

namespace Calculator;

use InvalidArgumentException;

require_once __DIR__ . '/../vendor/autoload.php';

function safe_sum($a, $b)
{
	if (!is_numeric($a)) {
		throw new InvalidArgumentException("First parameter is not a number");
	}

	if (!is_numeric($b)) {
		throw new InvalidArgumentException("Second parameter is not a number");
	}

	return add($a, $b);
}

function add($a, $b)
{
	return $a + $b;
}

function subtract($a, $b)
{
	return $a - $b;
}