<?php

namespace TrainingTracker;

class MeritFilterIterator extends \PSU_FilterIterator {
	public function accept() {
		$staff = $this->current();

		return $staff['authz']['permission']['training_tracker_mentee'] || $staff['authz']['permission']['training_tracker_mentor'];
	}//end accept

}//end 


