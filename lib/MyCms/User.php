<?php
namespace MyCms;


class User extends Entity
{
    private $userName;
    private $passwordHash;
	private $roleId;
	private $RoleName;
	
    public function __construct(int $id, string $userName, string $passwordHash, int $roleId, String $RoleName)
    {
        parent::__construct($id);
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
		$this->roleId= $roleId;
		$this->RoleName =$RoleName;
    }
    public function getUserName(): string
    {
        return $this->userName;
    }
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
	  public function getRoleName(): string
    {
        return $this->RoleName;
    }
	public function getRoleId(): int{
		return $this->roleId;
	}
}
