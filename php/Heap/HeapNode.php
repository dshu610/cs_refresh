<?php
/**
 * Inerface used by the Heap class for Node comparisons
 * 
 * @author David Shu
 *
 */
Interface HeapNode {
	public function isGreaterAndEqual($n);
	public function isLessAndEqual($n);
}
?>