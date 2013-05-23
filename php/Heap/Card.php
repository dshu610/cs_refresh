<?php
include_once "HeapNode.php";

/**
 * empty exception class to represent the exceptions
 * that are thrown from the Card class below
 * 
 * @author David Shu
 *
 */
class CardException extends Exception {
}

/**
 * An example implementation of the HeapNode interface.
 * This class implements a basic Card class where comparisons
 * are based on a combination of face value and suit. We implemented
 * more than just the required 2 methods, isGreatAndEqual and 
 * isLessAndEqual, to show what a possible full class would look like.
 * 
 * @author dshu
 *
 */
class Card implements HeapNode {
	protected $face;
	protected $suit;
	const JACK = 10;
	const QUEEN = 10;
	const KING = 10;
	const ACE = 1;
	const SPADE = 4;
	const HEART = 3;
	const CLUB = 2;
	const DIAMOND = 1;

	/**
	 * @param integer $face		integers or class constants such as Card::JACK
	 * @param unknown $suit  	class constant representing the suit
	 * @throws CardException If face is not in the range 1-10 or suit is not in 
	 * the range 1-4
	 */
	public function __construct($face, $suit) {
		if ($face < 1 || $face > 10) {
			throw new CardException("invalid value for parameter face");
		}

		if ($suit < 1 || $suit > 4) {
			throw new CardException("invalid value for parameter suit");
		}

		$this->face = $face;
		$this->suit = $suit;
	}

	/**
	 * 
	 * @return integer		face value of card 1-10
	 */
	public function getFace() {
		return $this->face;
	}

	/**
	 * 
	 * @return integer		suit value of card 1-4
	 */
	public function getSuit() {
		return $this->suit;
	}

	/**
	 * 
	 * @param Card $card		another Card Object
	 * @return boolean
	 * @throws CardException If parameter is not of the type Card		
	 */
	public function isEqual($card) {
		if (!is_a($card, "Card")) {
			throw new CardException("parameter is not of type Card");
		}

		if ($card->getFace() === $this->face && $this->suit === $card->getSuit) {
			return true;
		}
		return false;
	}

	/**
	 * 
	 * @param Card $card		
	 * @return boolean
	 * @throws CardException If parameter is not of the type Card
	 */
	public function isGreater($card) {
		if (!is_a($card, "Card")) {
			throw new CardException("parameter is not of type Card");
		}

		if ($this->face === $card->getFace()) {
			return (($this->suit > $card->getSuit()) ? true : false);
		} elseif ($this->face > $card->getFace()) {
			return true;
		}
		return false;
	}

	/**
	 * 
	 * @param Card $card
	 * @return boolean
	 * @throws CardException If parameter is not of the type Card
	 */
	public function isLess($card) {
		if (!is_a($card, "Card")) {
			throw new CardException("parameter is not of type Card");
		}

		if ($this->face === $card->getFace()) {
			return (($this->suit < $card->getSuit()) ? true : false);
		} elseif ($this->face < $card->getFace()) {
			return true;
		}
		return false;
	}

	/**
	 * 
	 * @param Card $card
	 * @return boolean
	 * @throws CardException If parameter is not of the type Card
	 */
	public function isGreaterAndEqual($card) {
		if (!is_a($card, "Card")) {
			throw new CardException("parameter is not of type Card");
		}

		if ($this->face == $card->getFace()) {
			return (($this->suit > $card->getSuit()
					|| $this->suit === $card->getSuit()) ? true : false);
		} elseif ($this->face > $card->getFace()) {
			return true;
		}
		return false;
	}

	/**
	 * 
	 * @param Card $card
	 * @return boolean
	 * @throws CardException If parameter is not of the type Card
	 */
	public function isLessAndEqual($card) {
		if (!is_a($card, "Card")) {
			throw new CardException("parameter is not of type Card");
		}

		if ($this->face === $card->getFace()) {
			return (($this->suit < $card->getSuit()
					|| $this->suit === $card->getSuit()) ? true : false);
		} elseif ($this->face < $card->getFace()) {
			return true;
		}
		return false;
	}

}

?>