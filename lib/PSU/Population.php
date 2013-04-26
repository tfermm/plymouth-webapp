<?php

/**
 *
 */
class PSU_Population implements IteratorAggregate, Countable {
	public $matches = null;

	public $query;
	public $userfactory;

	public function __construct( $query, $userfactory ) {
		$this->query = $query;
		$this->userfactory = $userfactory;
	}

	/**
	 * contains
	 *
	 * Used to determine if the passed identifier or object is a member of 
	 * the population.
	 *
	 * @param mixed $identifier A unique identifier for a population match
	 * @return boolean Returns if the identifier is present.
	 */
	public function contains( $identifier ) {
		return in_array( $identifier, $this->matches );
	}//end function

	public function count() {
		return count( $this->matches );
	}

	public function query( $args = '' ) {
		$this->matches = $this->query->query( $args );
	}

	public function getIterator() {
		$iterator = new PSU_Population_Iterator( $this->matches );
		$iterator->userfactory = $this->userfactory;
		return $iterator;
	}
}//end PSU_Population
