<?php

namespace PSU\OnlineForms\Template;

class Stage extends ActiveRecord{
	static $table = 'template_processor';
	static $_name = 'Stage';

	/**
	 * prepares arguments for DML
	 */
	protected function _prep_args() {
		// this is the data prepared for binding.
		// these fields are ordered as they are in the table
		$args = array(
			'the_id' => $this->id,
			'template_id' => $this->template_id,
			'processor_type_id' => $this->processor_type_id,
			'entitity_id' => $this->entitity_id,
			'notify_submitter' => $this->notify_submitter,
			'action_required' => $this->action_required,
		);

		return $args;
	}//end _prep_args
}//end class
