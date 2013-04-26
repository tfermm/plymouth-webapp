<?php

namespace PSU\TellPSU;

class Questions extends Collection {
	static $_name = 'Questions';
	static $child = 'PSU\\TellPSU\\Question';
	static $table = 'tp_questions';
	static $join = NULL;

	protected function _get_order() {
		return 'date_created';
	}
}//end class
