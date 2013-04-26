<?php

namespace PSU\TellPSU\Question;

class Answers extends \PSU\TellPSU\Collection {
	static $_name = 'Answers';
	static $child = 'PSU\\TellPSU\\Question\\Answer';
	static $parent_key = 'question_id';
	static $table = 'tp_answers';
	static $join = '';

	public function responses() {
		return new Responses( $this->question_id ); 
	}//end function

	protected function _get_order() {
		return 'date_created';
	}
}//end class
