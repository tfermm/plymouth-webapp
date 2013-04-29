<?php

namespace PSU\TellPSU\FilterIterator;

use \PSU\TellPSU\FilterIterator;

class Active extends FilterIterator {
	public function __construct( $item, $it, $inverse = false ) {
		parent::__construct( '\PSU\TellPSU\Question', 'active', $item, $it, $inverse );
	}//end constructor
}//end PSU\TellPSU\Question\FilterIterator\Role
