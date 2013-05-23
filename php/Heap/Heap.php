<?php
include_once "HeapNode.php";

/**
 * empty exception class to represent exceptions thrown from the
 * Heap class below
 * 
 * @author David Shu
 *
 */
class HeapException extends Exception {
}

/**
 * This is an implementation of the Heap Object, it supports both Max and
 * Min Heaps. It expects that every item that is to be compared implements
 * the HeapNode Interface.
 * 
 * @author David Shu
 *
 */
class Heap {
	const MAX = 1;
	const MIN = 0;
	private $heap_array = array();
	private $maxmin;
	private $heap_size = 0;

	/**
	 * Constructor takes an array of HeapNodes and builds the Heap
	 * 
	 * @param array $nodes			array of HeapNodes
	 * @throws HeapException if $nodes is not an array
	 */
	public function __construct($nodes) {
		if (!is_array($nodes)) {
			throw new HeapException(
					"Heap constuctor requires an array as a parameter");
		}

		$this->heap_array = $nodes;
		$this->maxmin = $this::MAX;
		$this->heap_size = count($nodes);
		$this->build($this->heap_array);
	}

	/**
	 * Set value to determine max or min heap
	 * 
	 * @param integer $maxmin
	 * @throws HeapException if $maxmin is not 0 or 1
	 */
	public function setMaxMin($maxmin) {
		if ($maxmin != 0 || $maxmin != 1) {
			throw new HeapException(
					"parameter must be either Card::MAX or Card::MIN");
		}
		$this->maxmin = $maxmin;
	}

	/**
	 * get value of MaxMin
	 * 
	 * @return integer	value will be either 1 or 0
	 */
	public function getMaxMin() {
		return $this->maxmin;
	}

	/**
	 * get the current size of the heap
	 * 
	 * @return integer			Size of heap  
	 */
	public function getSize() {
		return $this->heap_size;
	}

	/**
	 * build the heap based on the maxmin value
	 * 
	 * @param array $nodes		array of HeapNodes passed by reference
	 * @throws HeapException if $nodes is not an array
	 */
	private function build(&$nodes) {
		if (!is_array($nodes)) {
			throw new HeapException("parameter must be an array");
		}

		$len = floor(count($nodes) / 2);
		for ($i = $len; $i > -1; $i--) {
			$this->heapify($nodes, $i);
		}
	}

	/**
	 * this is the main method used by the build method to determine if
	 * nodes should be swapped or not
	 * 
	 * @param array $nodes	array of HeapNodes passed by reference
	 * @param integer $root		index of root node
	 * @throws HeapException if $nodes is not an array
	 */
	private function heapify(&$nodes, $root) {
		if (!is_array($nodes)) {
			throw new HeapException("expecting array parameter");
		}

		$heap_size = count($nodes);
		$left = $root * 2 + 1;
		$right = $root * 2 + 2;

		if ($heap_size > 0) {
			$rootNode = (is_array($nodes[$root]) ? $nodes[$root][0]
					: $nodes[$root]);

			if ($left < $heap_size) {
				$lNode = (is_array($nodes[$left]) ? $nodes[$left][0]
						: $nodes[$left]);
			}
			if ($right < $heap_size) {
				$rNode = (is_array($nodes[$right]) ? $nodes[$right][0]
						: $nodes[$right]);
			}

			if ($this->maxmin == $this::MIN) {
				if (($left < $heap_size && $rootNode->isGreaterAndEqual($lNode))) {
					$largest = $left;
				} else {
					$largest = $root;
				}
				$largestNode = (is_array($nodes[$largest]) ? $nodes[$largest][0]
						: $nodes[$largest]);
				if ($right < $heap_size
						&& $largestNode->isGreaterAndEqual($rNode)) {
					$largest = $right;
				}
			} else {
				if (($left < $heap_size && $rootNode->isLessAndEqual($lNode))) {
					$largest = $left;
				} else {
					$largest = $root;
				}
				$largestNode = (is_array($nodes[$largest]) ? $nodes[$largest][0]
						: $nodes[$largest]);
				if ($right < $heap_size && $largestNode->isLessAndEqual($rNode)) {
					$largest = $right;
				}
			}
			if ($largest != $root) {
				$this->swap($nodes, $root, $largest);
				$this->heapify($nodes, $largest);
			}

		}
	}

	/**
	 * swap the values of 2 locations in the nodes array passed in
	 * 
	 * @param array $nodes	array of HeapNodes passed by reference
	 * @param integer $from	index of first value
	 * @param integer $to	index of second value
	 * @throw HeapException if $nodes is not an array
	 */
	private function swap(&$nodes, $from, $to) {
		if (!is_array($nodes)) {
			throw new HeapException("expecting array parameter");
		}
		$tmp = $nodes[$from];
		$nodes[$from] = $nodes[$to];
		$nodes[$to] = $tmp;
	}

	/**
	 * sort the heap_array
	 * 
	 * @return array 	sorted array
	 */
	public function sort() {
		$tmp = $this->heap_array;
		$len = count($tmp);
		$out = array();
		for ($i = 0; $i < $len; $i++) {
			array_push($out, array_shift($tmp));
			$this->build($tmp);
		}
		return $out;
	}

	/**
	 * pop the node at index 0 of the heap_array and return it 
	 * 
	 * @return Node		node at the top of the heap
	 */
	public function pop() {
		$t = array_shift($this->heap_array);
		$this->heap_size--;
		$this->build($this->heap_array);
		return $t;

	}

	/**
	 * push a new node into the heap_array and rebuild the heap
	 * 
	 * @param Node $node
	 * @throws HeapExcpetion if the parameter object doesn't implement the 
	 * HeapNode interface
	 */
	public function push($node) {
		if (!$node instanceof HeapNode) {
			throw new HeapException(
					"invalid object type, expecting an instance of HeapNode");
		}

		array_push($this->heap_array, $node);
		$this->heap_size++;
		$this->build($this->heap_array);
	}

}

?>