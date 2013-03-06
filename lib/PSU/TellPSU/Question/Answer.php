<?php

namespace PSU\TellPSU\Question;

class Answer extends \PSU\TellPSU\ActiveRecord{
	static $table = 'tp_answers';
	static $_name = 'Answer';

	/**
	 * prepares arguments for DML
	 */
	protected function _prep_args() {
		// this is the data prepared for binding.
		// these fields are ordered as they are in the table
		$args = array(
			'the_id' => $this->id,
			'question_id' => $this->question_id,
			'text' => $this->text,
			'date_created' => $this->date_created,
			'activity_date' => $this->activity_date,
		);

		return $args;
	}//end _prep_args
}//end class
