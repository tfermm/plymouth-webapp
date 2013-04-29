<?php

namespace PSU\TellPSU\Question;

class Answers extends \PSU\TellPSU\Collection {
	static $_name = 'Answers';
	static $child = 'PSU\\TellPSU\\Question\\Answer';
	static $parent_key = 'question_id';
	static $table = 'tp_answers';
	static $join = '';

	protected function _get_order() {
		return 'date_created';
	}
}//end class
