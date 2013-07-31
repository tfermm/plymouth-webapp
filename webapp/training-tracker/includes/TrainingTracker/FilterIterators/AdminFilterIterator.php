<?php

namespace TrainingTracker;

class AdminFilterIterator extends \PSU_FilterIterator {
	public function accept() {
		$staff = $this->current();

		return $staff['authz']['permission']['training_tracker_admin'];
	}//end accept
}//end 


