<?php

namespace PSU\TellPSU\FilterIterator;

use \PSU\TellPSU\FilterIterator;

class Targeting extends FilterIterator {
	public function __construct( $item, $it, $inverse = false ) {
		$this->item = $item;
		parent::__construct( '\PSU\TellPSU\Question', 'wp_id', $item, $it, $inverse );
	}//end constructor

	public function accept() {
		$item = $this->current();
		if( $inverse ) {
			return !$item->target()->population()->contains( $this->item );
		}//end if

		return $item->target()->population()->contains( $this->item );
	}//end function
}//end PSU\TellPSU\Question\FilterIterator\Role
