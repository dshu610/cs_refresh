<?php
include_once "HeapNode.php";

/**
 * Just an example class that Implements that HeapNode interface
 * In this class we are only comparing single value numbers in our
 * implementation of the required methods. Only the methods required
 * by the interface are implemented for comparisons.
 * 
 * @author David Shu
 *
 */
class NObj implements HeapNode {
	protected $value;

	public function __construct($v) {
		$this->value = $v;
	}

	public function getValue() {
		return $this->value;
	}

	public function isGreaterAndEqual($n) {
		if ($this->value >= $n->getValue()) {
			return true;
		}
		return false;
	}
	public function isLessAndEqual($n) {
		if ($this->value <= $n->getValue()) {
			return true;
		}
		return false;
	}

}
?>