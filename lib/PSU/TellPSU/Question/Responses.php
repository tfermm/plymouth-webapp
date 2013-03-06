<?php

namespace PSU\TellPSU\Question;

class Responses extends \PSU\TellPSU\Collection {
	static $_name = 'Responses';
	static $child = 'PSU\\TellPSU\\Question\\Response';
	static $parent_key = 'question_id';
	static $table = 'tp_responses';
	static $join = '';

	protected function _get_order() {
		return 'activity_date';
	}
}//end class
