<?php

namespace TrainingTracker;
// TODO: remove this file
class StaffFilterIterator extends \PSU_FilterIterator {
	public function accept() {
		$staff = $this->current();

		return 'trainee' == $staff->privileges || 'sta' == $staff->privileges || 'shift_leader' == $staff->privileges;
	}//end accept
}//end 


