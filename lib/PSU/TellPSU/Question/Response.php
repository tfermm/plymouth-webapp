<?php

namespace PSU\TellPSU\Question;

class Response extends \PSU\TellPSU\ActiveRecord {
	static $table = 'tp_responses';
	static $_name = 'Response';

	/**
	 * prepares arguments for DML
	 */
	protected function _prep_args() {
		// this is the data prepared for binding.
		// these fields are ordered as they are in the table
		$args = array(
			'the_id' => $this->id,
			'wp_id' => $this->wp_id,
			'question_id' => $this->question_id,
			'answer_id' => $this->answer_id,
			'activity_date' => $this->activity_date,
		);

		return $args;
	}//end _prep_args
}//end class
