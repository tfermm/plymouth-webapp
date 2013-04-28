<?php

namespace PSU\TellPSU\Question;

class Target extends \PSU\TellPSU\ActiveRecord{
	static $table = 'tp_targets';
	static $_name = 'Target';

	/**
	 * population
	 *
	 * create a PSU Population object based on the class
	 *
	 * @return object An instance of a PSU Population object
	 */
	public function population() {
		$query = '\PSU_Population_Query_' . $this->class;
		$this->query = new $query();
		$this->userfactory =  new \PSU_Population_UserFactory_Simple();
		$this->population = new \PSU_Population( $this->query, $this->userfactory );
		$this->population->query( unserialize( $this->args ) );
		return $this->population;
	}//end function

	/**
	 * prepares arguments for DML
	 */
	protected function _prep_args() {
		// this is the data prepared for binding.
		// these fields are ordered as they are in the table
		$args = array(
			'the_id' => $this->id,
			'name' => $this->name,
			'class' => $this->class,
			'args' => $this->args,
		);

		return $args;
	}//end _prep_args
}//end class
