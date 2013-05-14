<?php
class Regisrtry
{
    protected $_container = array();

    public function __construct($array = null)
    {
        if (!is_null($array)) {
            $this->_container = $array;
        }
    }

    public function check($offset)
    {
        return isset($this->_container[$offset]);
    }

    public function get($offset)
    {
        return $this->check($offset) ? $this->_container[$offset] : null;
    }

    public function set($offset, $value)
    {
        if (is_null($offset)) {
            $this->_container[] = $value;
        } else {
            $this->_container[$offset] = $value;
        }
    }

    public function destroy($offset)
    {
        unset($this->_container[$offset]);
    }
}
?>
