<?php


namespace MyCms;


class Role extends Entity
{
	private $RoleName;
	
	  public function __construct(int $id, String $RoleName)
    {
        parent::__construct($id);
		$this->RoleName = $RoleName;
    }
	public function getRoleName() : String{
		return $this->RoleName;
	}
	
}
	