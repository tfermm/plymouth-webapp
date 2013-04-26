<?php

namespace PSU;

class TellPSU {
	public $data = array();

	/**
	 *
	 */
	public function active_questions() {
		$this->data['active_questions'] = $this->questions()->get_by_active( 1 );
		return $this->data['active_questions'];
	}//end function

	/**
	 *
	 */
	public function __construct( $wp_id ) {
		$this->user = \PSUPerson::get( $wp_id );
	}//end function

	/**
	 *
	 */
	public function &__get( $key ) {
		if( isset( $this->data[ $key ] ) ) {
			return $this->data[ $key ];
		}//end if

		if( method_exists( $this, $key ) ) {
			return $this->$key();
		}//end if

		return NULL;
	}//end function

	/**
	 *
	 */
	public function questions(){
		$this->data['questions'] = new TellPSU\Questions();
		return $this->data['questions'];
	}//end function

	/**
	 *
	 */
	public function respond( $question_id, $answer_id ) {

		$response = new TellPSU\Question\Response();
		$response->wp_id = $this->user->wp_id;
		$response->question_id = $question_id;
		$response->answer_id = $answer_id;
		return( $response->save() );

	}//end function

	/**
	 *
	 */
	public function responded( $question_id ) {
		$question = TellPSU\Question::get( $question_id );
		return $question->user_response( $this->user->wp_id ) ?: FALSE;
	}//end if

	/**
	 *
	 */
	public function user_questions( $user ) {
		if( is_object( $user ) ) {
			$user = $user->wp_id;
		}//end if

		return $this->questions()->get_by_targeting( $user );
	}//end if

}//end class
