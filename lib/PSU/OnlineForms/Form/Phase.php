<?php

namespace PSU\OnlineForms\Form;

class Phase extends ActiveRecord{
	static $table = 'form_progress';
	static $_name = 'Phase';

	/**
	 * prepares arguments for DML
	 */
	protected function _prep_args() {
		// this is the data prepared for binding.
		// these fields are ordered as they are in the table
		$args = array(
			'the_id' => $this->id,
			'form_id' => $this->form_id,
			'template_processor_id' => $this->template_processor_id,
			'decision_ind' => $this->decision_ind,
			'user' => $this->user,
			'comments' => $this->comments,
			'activity_date' => $this->activity_date,
		);

		return $args;
	}//end _prep_args
}//end class
