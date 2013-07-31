<?php

namespace TrainingTracker;

class MentorFilterIterator extends \PSU_FilterIterator {
	public function accept() {
		$mentor = $this->current();

		return $mentor->authz['permission']['training_tracker_mentor'];
	}//end accept
}//end class

