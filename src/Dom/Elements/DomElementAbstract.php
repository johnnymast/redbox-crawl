<?php
namespace Redbox\Crawl\Dom\Elements;

abstract class DomElementAbstract {
    /**
     * @var bool
     */
    protected $is_valid;
    /**
     * @var string
     */
    protected $error;

    /**
     * @return boolean
     */
    public function isIsValid()
    {
        return $this->is_valid;
    }

    /**
     * @param boolean $is_valid
     */
    public function setIsValid($is_valid)
    {
        $this->is_valid = $is_valid;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param string $error
     */
    public function setError($error)
    {
        $this->error = $error;
    }



    public abstract function getTag();
    public abstract function verifyImplementation();
}