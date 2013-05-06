<?php

namespace PSU\OnlineForms;

class Form extends ActiveRecord{
	static $table = 'forms';
	static $_name = 'Forms';

	/**
	 * Get the fields and their associated values for this form.
	 */
	public function fields() {
		if( !$this->fields ) {
			$this->fields = new Form/Fields( $this->id );
		}//end if
		return $this->fields;
	}//end function

	/**
	 * Get the template for this form.
	 */
	public function template() {
		if( !$this->template ) {
			$this->template = new Template( $this->template_id );
		}//end if
		return $this->template;
	}//end function

	/**
	 * prepares arguments for DML
	 */
	protected function _prep_args() {
		// this is the data prepared for binding.
		// these fields are ordered as they are in the table
		$args = array(
			'the_id' => $this->id,
			'date_created' => $this->date_created,
			'completed' => $this->completed,
			'template_id' => $this->template_id,
		);

		return $args;
	}//end _prep_args
}//end class
