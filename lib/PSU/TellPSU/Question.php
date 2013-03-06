<?php

namespace PSU\TellPSU;

class Question extends ActiveRecord{
	static $table = 'tp_questions';
	static $_name = 'Question';

	public function answers() {
		return new Question\Answers( $this->id );
	}//end function

	public function radio_answers() {
		$answers = new Question\Answers( $this->id );
		foreach( $answers as $answer ) {
			$result[ $answer->id ] = $answer->text;
		}//end foreach

		return $result ?: NULL;
	}//end fucntion

	public function responses() {
		return $this->_get_related( __FUNCTION__, '\\PSU\\TellPSU\\Question\\Responses', $this->id );
		return new Question\Responses( $this->id );
	}//end function

	public function user_response( $wp_id ) {
		foreach( $this->responses()->get_by_user( $wp_id ) as $response ) {
			return $response;
		}//end foreach
	}//end function

	/**
	 * prepares arguments for DML
	 */
	protected function _prep_args() {
		// this is the data prepared for binding.
		// these fields are ordered as they are in the table
		$args = array(
			'the_id' => $this->id,
			'text' => $this->text,
			'target_role_id' => $this->target_role_id,
			'date_created' => $this->date_created,
			'active' => $this->active,
		);

		return $args;
	}//end _prep_args
}//end class
