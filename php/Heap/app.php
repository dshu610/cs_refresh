<?php
include_once 'Heap.php';
include_once 'Card.php';
include_once 'NObj.php';

/**
 * sample code to show usage of the Heap
 * with the simple NObj class
 */
$n1 = new NObj(5);
$n2 = new NObj(7);
$n3 = new NObj(2);
$a = array($n1, $n2, $n3);
$h = new Heap($a, Heap::MIN);
$out2 = $h->sort();

print "\n";
foreach ($out2 as $n) {
	print $n->getValue() . " ";
}
print "\n\n";

/**
 * sample code to show usage of the Heap 
 * with the Card class
 */
try {
	$c1 = new Card(Card::JACK, Card::SPADE);
	$c2 = new Card(Card::JACK, Card::DIAMOND);
	$c3 = new Card(8, Card::HEART);
	$c4 = new Card(2, Card::CLUB);
	$deck = array($c1, $c4, $c3, $c2);

	$h2 = new Heap($deck, Heap::MIN);
	$out = $h2->sort();

	print "\n";
	foreach ($out as $n) {
		print $n->getFace() . " of " . $n->getSuit() . "\n";
	}
	print "\n\n";

} catch (Exception $e) {
	print $e->getMessage();
}

?>