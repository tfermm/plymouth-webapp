<?php

namespace PSU\OnlineForms\Form;

class Field extends ActiveRecord{
	static $table = 'forms_meta';
	static $_name = 'Fields';

	/**
	 * prepares arguments for DML
	 */
	protected function _prep_args() {
		// this is the data prepared for binding.
		// these fields are ordered as they are in the table
		$args = array(
			'the_id' => $this->id,
			'form_id' => $this->form_id,
			'label' => $this->label,
			'value' => $this->value,
			'activity_date' => $this->activity_date,
		);

		return $args;
	}//end _prep_args
}//end class
