<?php
namespace MyCms;

interface IData {
    public function getId() : int;
}

class Entity implements IData
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId() : int {
        return $this->id;
    }

}