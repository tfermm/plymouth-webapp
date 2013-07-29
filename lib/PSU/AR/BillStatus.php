<?php

/**
 * \PSU\AR\BillStatus.php
 *
 * Bill Status Object
 *
 */

namespace PSU\AR;


class BillStatus{
 
 	function __construct($pidm){
		$this->pidm = $pidm;
		$this->pidm = \PSUPerson::get("888888888")->pidm;	
		// \PSU::puke(\PSUPerson::get("888888888")->bill);
		$this->pidm = 258898;
		// populating data
 	
		$db = \PSU::db('test');
		// term
		$sql = "SELECT value FROM GXBPARM WHERE param=:param";
		$args = array('param'=>'ug_bill_default_term');
		$this->term_code = $db->GetOne($sql, $args);
		\PSU::dbug($this->term_code);
		$year = substr( $this->term_code, 0, -2 );
		$term = substr( $this->term_code, -2 );

		switch( $term ){
			case 10:
				$this->next_term = "Fall " . $year;
				break;
			case 30:
				$this->next_term = "Spring " . $year;
				break;
		}

		// bill available date
		$sql = "SELECT value FROM GXBPARM WHERE param=:avail";
		$args = array('avail'=>'ug_bill_avail_date');
		$this->bill_available_raw = strtotime($db->GetOne($sql, $args));
		$this->bill_available_formatted = date('F jS',$this->bill_available_raw);

		// bill due date 
		$sql = "SELECT value FROM GXBPARM WHERE param=:due";
		$args = array('due'=>'ug_bill_due_date');
		$this->bill_due_raw = strtotime($db->GetOne($sql, $args));
		$this->bill_due_formatted = date('F jS', $this->bill_due_raw);

		// now date
		$this->today = strtotime(date('Y-m-d'));

		// enrolment status
		$sql = "SELECT sfbetrm_ests_code
						FROM sfbetrm
						WHERE sfbetrm_pidm=:pidm
						AND sfbetrm_term_code=:term_code"; 

		$args = array('pidm'=>$this->pidm, 'term_code'=>$this->term_code);
		$this->enrolment_status = $db->GetOne($sql, $args);

		// notes current and balance overall

		$this->person = new \PSUPerson($this->pidm);
		\PSU::db('banner')->debug=true;
		$this->person->bill->set_term($this->term_code);
		\PSU::dbug($this->person->bill->balance);
		\PSU::db('banner')->debug=false;
		// \PSU::puke($this->person->bill);
		$data['notes_all'] = round($this->person->bill->notes['total'], 2);
		$data['balance_all'] = round($this->person->bill->balance['total'], 2);
		$this->notes_current = round($this->person->bill->notes['current_term'], 2);
		$this->overall_balance = round($data['balance_all'] + $data['notes_all'], 2);
		
		// total billing hours
		$sql = "SELECT f_calc_registration_hours(:pidm, :term, 'TOTAL', 'BILL') FROM dual";
		$args = array('pidm'=>$this->pidm, 'term'=>$this->term_code);
		$this->total_billing_hours = $db->GetOne($sql, $args);

		$output = $this;
		unset($output->person);
		\PSU::dbug($output);
		self::populate_status();
 	}
 	
 	public function populate_status(){
 		if ( ($status = $this->is_not_registered()) != NULL ){
   		return true;  	
 		}
 		else if ( ($status = $this->is_protected()) != NULL ){
   		return true;  	
 		}	
 		else if ( ($status = $this->is_warning()) != NULL ){
   		return true;  	
 		}
 		else{ 
 		 	$this->is_error();
   		return false;  	
		}
	}
 	
 	public function is_not_registered(){
 		if ($this->enrolment_status == "EL" && $this->total_billing_hours == 0){
			$this->status = array();
 			$this->status['type'] = "NOT REGISTERED";
			$this->status['message'] = "You are not registered for the $this->next_term term. Bills will be available online on $this->bill_available_formatted and are due $this->bill_due_formatted.";
 			$this->status['short_message'] = "Not registered for the term";
 			return true;
 		}
 		return NULL;
 	}
 	
 	public function is_protected(){
		if( $this->total_billing_hours > 0 && $this->overall_balance <= 0 && $this->notes_current <= 0 ){
			$this->status = array();
 			$this->status['type'] = "PROTECTED";
 			$this->status['message'] = "Your bill is paid and your course registration for $this->next_term is currently protected.";
 			$this->status['short_message'] = "Registered and paid for the term with no payment plan";
 		}
 		else if( $this->total_billing_hours > 0 && $this->overall_balance <= 0 && $this->notes_current > 0 ){
			$this->status = array();
 			$this->status['type'] = "PROTECTED";
 			$this->status['message'] = "Your course registration is currently protected.  To maintain your status please continue to make payments on schedule.";
 			$this->status['short_message'] = "Registered and paid for the term with payment plan";
 			return true;
 		}
 		return NULL;
 	}
 	
 	public function is_warning(){
 		if ( $this->total_billing_hours > 0 && $this->overall_balance > 0 && $this->today <= $this->bill_due_raw ){
			$this->status = array();
 			$this->status['type'] = "WARNING";
 			$this->status['message'] = "Your course registration is not protected.  Payment for the $this->next_term term is due $this->bill_due_formatted.  If your account is not cleared your courses may be dropped.";
 			$this->status['short_message'] = "Registered for the term, but remaining outstanding balance $1000 or greater prior to due date.";
 			return true;
 		}
 		else if(($this->total_billing_hours > 0) && ($this->overall_balance > 0) && ($this->today >= $this->bill_due_raw) && ($this->today <= ($this->bill_due_raw + 3888000))){
			$this->status = array();
 			$this->status['type'] = "WARNING";
 			$this->status['message'] = "Your course registration is not protected and your courses may be dropped for nonpayment. Payment is due immediately.";
 			$this->status['short_message'] = "Registered for the term, but remaining outstanding balance $1000 or greater after due date (0-45 days).";
 			return true;
 		}
 		else if( ($this->total_billing_hours > 0 && $this->overall_balance > 0 && ($today > ($this->bill_due_raw + 3888000))) || ($this->overall_balance > 0 && $this->overall_balance < 1000)){
			$this->status = array();
 			$this->status['type'] = "WARNING";
 			$this->status['message'] = "You have a balance on your account. Please clear your account immediately to avoid financial holds and late fees.";
 			$this->status['short_message'] = "Registered for the term, but remaining outstanding balance $1000 or greater after to due date (46+ days) or balance under $1000 any time.";
 			return true;
		}
 		else if ( $this->enrolment_status == "DG" && $this->total_billing_hours == 0 ){
			$this->status = array();
 			$this->status['type'] = "WARNING";
 			$this->status['message'] = "Your courses have been dropped for non-payment";
 			$this->status['short_message'] = "Dropped.";
 			return true;
 		}
 		return NULL;
 	}
 	
 	public function is_error(){
		$this->status = array();
		$this->status['type'] = "ERROR";
		$this->status['message'] = "Status unknown. Please check back later or contact Student Account Service.";
		$this->status['short_message'] = "Error";
		return true;
 	}
}	
