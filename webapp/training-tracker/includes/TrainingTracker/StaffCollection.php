<?php

namespace TrainingTracker;

include 'FilterIterators/AdminFilterIterator.php';
include 'FilterIterators/MeritFilterIterator.php';
include 'FilterIterators/PromotionFilterIterator.php';
include 'FilterIterators/StaffFilterIterator.php';
include 'FilterIterators/ValidUserFilterIterator.php';
include 'FilterIterators/MenteeFilterIterator.php';
include 'FilterIterators/MentorFilterIterator.php';


class StaffCollection extends \PSU\Collection {

	public static $child = '\TrainingTracker\Staff';

	public function __construct(){
	}

	public function get($wpid = null){

		$query = new \PSU\Population\Query\IDMAttribute('training_tracker', 'role', 'psc1');
		$factory = new \PSU_Population_UserFactory_PSUPerson;
		$population= new \PSU_Population( $query, $factory );
		$population->query();
		
		if (!$wpid){
			$users = array();

			foreach ($population->matches as $match){

				$temp['wpid'] = $match;
				$person = \PSUPerson::get($temp['wpid']);
				$temp['pidm'] = $person->pidm;
				$temp['authz'] = \PSU::get('idmobject')->loadAuthZ($temp['pidm']);
				$trainee = "calllog_trainee";
				$supervisor = "calllog_supervisor";
				$shift_leader = "calllog_shift_leader";

				if ($temp['authz']['permission'][$trainee]){
					$temp['privileges'] = 'trainee';
				}
				else if ($temp['authz']['permission'][$shift_leader]){
					$temp['privileges'] = 'sta';
				}
				else if ($temp['authz']['permission'][$supervisor]){
					$temp['privileges'] = 'shift_leader';
				}

				$temp['username'] = $person->username;
				$temp['name'] = $person->formatName("F L");

				array_push($users, $temp);
			}

			return $users;	
		}
		else{
			foreach ($population->matches as $match){
				if ($wpid == $match){

					$temp['wpid'] = $match;
					$person = \PSUPerson::get($temp['wpid']);
					$temp['pidm'] = $person->pidm;
					$temp['authz'] = \PSU::get('idmobject')->loadAuthZ($temp['pidm']);
					$trainee = "calllog_trainee";
					$supervisor = "calllog_supervisor";
					$shift_leader = "calllog_shift_leader";

					if ($temp['authz']['permission'][$trainee]){
						$temp['privileges'] = 'trainee';
					}
					else if ($temp['authz']['permission'][$shift_leader]){
						$temp['privileges'] = 'sta';
					}
					else if ($temp['authz']['permission'][$supervisor]){
						$temp['privileges'] = 'shift_leader';
					}

					$temp['username'] = $person->username;
					$temp['name'] = $person->formatName("F L");

					return new Staff($temp);

				}
			}

			return null;

		}
	}//end get

	// mentees. selects the trainee and sta permission from callog
	public function mentees($person = null){

		if ( ! $person ){
			$person = $this->getIterator();
		}//end if

		return new MenteeFilterIterator( $person );
	}//end mentees

	// filter for trainee, sta and shift_leader callog permissions
	public function staff($person = null){
		if ( ! $person ){
			$person = $this->getIterator();
		}//end if
		return new StaffFilterIterator( $person );
	}//end staff
	
	public function mentors($person = null){
			if ( ! $person ){
				$person = $this->getIterator();
			}//end if
			return new MentorFilterIterator( $person );
	}//end mentors

	// Mentees and Mentors
	public function merit_users($person = null){
			if ( ! $person ){
				$person = $this->getIterator();
			}//end if
			return new MeritFilterIterator( $person );
	}//end mentors

	// People that are below the supervisor level
	public function promotion_users($person = null){
			if ( ! $person ){
				$person = $this->getIterator();
			}//end if
			return new PromotionFilterIterator( $person );
	}//end mentors

}// end StaffCollection 

