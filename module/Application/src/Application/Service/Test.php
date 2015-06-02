<?php
namespace Application\Service;

class Test
{
    protected $test = array();
    public function getTest()
    {
        return $this->test;
    }
     public function setTest($test)
    {
        $this->test = $test;
    }

}