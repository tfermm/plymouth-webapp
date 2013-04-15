<?php

namespace PSU\OnlineForms;

class Template extends ActiveRecord{
	static $table = 'templates';
	static $_name = 'Template';

	/**
	 * Return the stages for this template
	 */
	public function stages() {
		if( !$this->stages ) {
			$this->stages = new Template/Stages( $this->id );
		}//end if

		return $this->stages;
	}//end function

	/**
	 * prepares arguments for DML
	 */
	protected function _prep_args() {
		// this is the data prepared for binding.
		// these fields are ordered as they are in the table
		$args = array(
			'the_id' => $this->id,
			'code' => $this->code,
			'name' => $this->name,
			'description' => $this->description,
			'allow_override' => $this->allow_override,
		);

		return $args;
	}//end _prep_args
}//end class
