<?php

namespace PSU\TellPSU\FilterIterator;

use \PSU\TellPSU\FilterIterator;

class Role extends FilterIterator {
	public function __construct( $item, $it, $inverse = false ) {
		parent::__construct( '\PSU\TellPSU\Question', 'target_role_id', $item, $it, $inverse );
	}//end constructor
}//end PSU\TellPSU\Question\FilterIterator\Role
