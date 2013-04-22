<?php
class Heap{
	const Max = 1;
	const Min = 0;
	private $heapArray = array();
	private $maxmin;
	private $heap_size = 0;
	
	public function Heap($a, $maxmin = 1){
		$this->heapArray = $a;
		$this->maxmin = $maxmin;
		$this->heap_size = count($a);
		$this->build($this->heapArray);
	}
	
	public function getSize(){
		return $this->heap_size;
	}
	
	private function build(&$a){
		
		$len = floor(count($a)/2);
		for($i=$len;$i>-1;$i--){
			$this->heapify($a,$i);
		}
	}
	
	private function heapify(&$a,$root){
		$heap_size = count($a);
		$left = $root * 2 + 1;
		$right = $root * 2 + 2;
		
		if($heap_size > 0){
			$rootVal = (is_array($a[$root])?$a[$root][0]:$a[$root]);
		
			if($left < $heap_size){
				$lVal = (is_array($a[$left])?$a[$left][0]:$a[$left]);
			}
			if($right < $heap_size){
				$rVal = (is_array($a[$right])?$a[$right][0]:$a[$right]);
			}
				
			if($this->maxmin == $this::Min){
				if(($left < $heap_size && $rootVal >= $lVal)){
					$largest = $left;
				}else{
					$largest = $root;
				}
				$largestVal = (is_array($a[$largest])?$a[$largest][0]:$a[$largest]);	
				if($right < $heap_size && $largestVal >= $rVal){
					$largest = $right;
				}
			}else{
				if(($left < $heap_size && $rootVal <= $lVal)){
					$largest = $left;
				}else{
					$largest = $root;
				}
				$largestVal = (is_array($a[$largest])?$a[$largest][0]:$a[$largest]);
				if($right < $heap_size && $largestVal <= $rVal){
					$largest = $right;
				}
			}
			if($largest != $root){
				$this->swap($a,$root, $largest);
				$this->heapify($a,$largest);
			}
	
		}
	}
	
	private function swap(&$a,$root,$largest){
		$tmp = $a[$root];
		$a[$root] = $a[$largest];
		$a[$largest] = $tmp;
	}
	
	public function sort(){
		$tmp = $this->heapArray;
		$len = count($tmp);
		$out = array();
		for($i=0;$i<$len;$i++){
			array_push($out,array_shift($tmp));
			$this->build($tmp);
		}
		return $out;
	}
	
	public function pop(){
		$t = array_shift($this->heapArray);
		$this->heap_size--;
		$this->build($this->heapArray);
		return $t;
		
	}
	
	public function push($v){
		array_push($this->heapArray,$v);
		$this->heap_size++;
		$this->build($this->heapArray);
	}
		
}
// sorting an array of integers
$a2 = array(5,90,2,34,6,8,234,8,4545,8,455,64,9000);
$h = new Heap($a2,Heap::Min);
print "****** OUTPUT OF SORTING A SINGLE ARRAY *******\n";
print_r($h->sort());
print "****** SINGLE ARRAY OUTPUT END **********\n\n";

$a[0] = array(1,5,23,56,66,79,80,88,100,200,3000,5000,6000,70000);
$a[1] = array(1,7,23,56,88,150,312);
$a[2] = array(1,2,2,42,88);
$a[3] = array(1,6,23,56,88);
$a[4] = array(4,5,23,56,88);
$a[5] = array(3,5,23,56,88);
$a[6] = array(1,7,23,56,88);
$a[7] = array(1,9,23,67,88);
$a[8] = array(1,5,23,77,88);
$a[9] = array(2,8,23,56,88);
$a[10] = array(1,14,23,56,88);

$idx = array();
$tmp = array();

/*setup the array for building the initial heap
we can push the individual values directly into a heap object but every 
push would require a rebuilding of the heap, passing in an array would 
only build the heap once*/
for($i=0;$i<count($a);$i++){
	array_push($tmp,array($a[$i][0],$i));
	array_push($idx,1);
}

$keepgoing = true;
$h = new Heap($tmp,"min");

print "********* OUTPUT FROM SORTING MULTIPLE ARRAYS *********\n";
while($keepgoing){
	if($h->getSize()==0){
		$keepgoing = false;
		break;
	}
	$t = $h->pop();
	$idx[$t[1]]++;
	print $t[0] . " ";
	
	if($idx[$t[1]] >= count($a[$t[1]])){
		continue;
	}else{
		$h->push(array($a[$t[1]][$idx[$t[1]]],$t[1]));
	}
}
print "\n********* MULTIPLE ARRAY OUTPUT END **************\n";
?>