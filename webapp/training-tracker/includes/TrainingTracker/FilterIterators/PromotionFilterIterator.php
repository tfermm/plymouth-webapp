<?php

namespace TrainingTracker;

class PromotionFilterIterator extends \PSU_FilterIterator {
	public function accept() {
		$staff = $this->current();

		return $staff['authz']['role']['training_tracker'];
	}//end accept

}//end 

