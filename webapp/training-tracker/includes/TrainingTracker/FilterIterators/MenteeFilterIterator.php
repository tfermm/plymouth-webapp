<?php

namespace TrainingTracker;

class MenteeFilterIterator extends \PSU_FilterIterator {
	public function accept() {
		$mentee = $this->current();

		return $mentee->authz['permission']['training_tracker_mentee'];
	}//end accept
}//end 


