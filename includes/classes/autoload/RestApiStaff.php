<?php

use
	OSC\Staff\Collection
		as StaffCol
	, OSC\Staff\Object
		as StaffObj
;

class RestApiStaff extends RestApi {

	public function get($params){
		$col = new StaffCol();
		// start limit page
		$col->sortByName('ASC');
		$col->filterByName($params['GET']['name']);
		$col->filterByType($params['GET']['type']);
		$col->filterById($params['GET']['id']);
		$showDataPerPage = 10;
		$start = $params['GET']['start'];
		$this->applyLimit($col,
			array(
				'limit' => array( $start, $showDataPerPage )
			)
		);
		return $this->getReturn($col, $params);
	}
	public function post($params){
		$obj = new StaffObj();
		$obj->setProperties($params['POST']);
		$obj->insert();
		return array(
			'data' => array(
				'id' => $obj->getId(),
				'success' => 'success'
			)
		);
	}

	public function put($params){
		$obj = new StaffObj();
		$this->setId($this->getId());
		$obj->setProperties($params['PUT']);
		$obj->update($this->getId());
		return array(
			'data' => array(
				'id' => $obj->getId(),
				'success' => 'success'
			)
		);
	}

	public function delete(){
		$obj = new StaffObj();
		$obj->delete($this->getId());
	}


}
