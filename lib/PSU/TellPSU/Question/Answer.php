<?php

namespace PSU\TellPSU\Question;

class Answer extends \PSU\TellPSU\ActiveRecord{
	static $table = 'tp_answers';
	static $_name = 'Answer';

	public function percent_response() {
		if( $this->_get_related( __FUNCTION__, '\\PSU\\TellPSU\\Question\\Responses', $this->question_id )->count() <= 0 ) {
			return 0;
		}//end if

		return $this->responses()->count()/$this->_get_related( __FUNCTION__, '\\PSU\\TellPSU\\Question\\Responses', $this->question_id )->count()*100;
	}//end function

	public function responses() {
		return $this->_get_related( __FUNCTION__, '\\PSU\\TellPSU\\Question\\Responses', $this->question_id )->get_by_answer( $this->id );
	}//end function

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
