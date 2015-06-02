<?php
namespace Application\Service;

class TestService implements TestServiceInterface
{
    protected $test = array();
    protected $somethingElse;
    
    public function getTest()
    {
        return $this->test;
    }
     public function setTest($test)
    {
        $this->test = $test;
    }
    public function getSomethingElse()
    {
        return $this->somethingElse;
    }

    public function setSomethingElse($somethingElse)
    {
        $this->somethingElse = $somethingElse;
    }


}