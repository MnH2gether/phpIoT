<?php

/*
 * Copyright (c) 2017, Semyon Mamonov <semyon.mamonov@gmail.com>.
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 
 *  * Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 * 
 *  * Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in
 *    the documentation and/or other materials provided with the
 *    distribution.
 * 
 *  * Neither the name of Semyon Mamonov nor the names of his
 *    contributors may be used to endorse or promote products derived
 *    from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace IoT\Tools\Data;

/**
 * Generated: Dec 18, 2017 11:18:50 PM
 * 
 * Description of ArrayDataStorage
 *
 * @author Semyon Mamonov <semyon.mamonov@gmail.com>
 */
final class ArrayDataStorage implements IDataStorage {
    
    static protected $instance = null;   
    
    protected $arrayObjectData = null;

    protected function __construct() {
        $this->arrayObjectData = new \ArrayObject();
    }        

    protected function __clone() {
    }    
    
    /**
     * 
     * @return ArrayDataStorage
     */
    static public function instance(){
        if ( is_null(static::$instance) ) {
            static::$instance = new static();
        }
        return(static::$instance);
    }

    protected function getHashSeparator(){
        return(':');
    }
    
    /**
     * 
     * @param string|object $namespace
     * @return string
     */
    protected function getOwnerPart($namespace=''){
        $result = '';
        if( !is_null($namespace) && is_object($namespace) ){
            $result = spl_object_hash($namespace);
        } else {
            $namespace = strval($namespace);
            if ($namespace !== ''){
                $hashSep= $this->getHashSeparator();
                $lastIdx = strrpos($namespace, $hashSep);  
                if ($lastIdx !== false)  {
                    $result = substr($namespace, $lastIdx + strlen($hashSep));
                }
            }
        }

        return($result);
    }
    
    /**
     * 
     * @param string|object $namespace
     * @return string
     */
    protected function getNamespace($namespace){
        if( !is_null($namespace) && is_object($namespace) ){
            $result = $namespace::class.$this->getHashSeparator().$this->getOwnerPart($namespace);
        } else {
            $result= strval($namespace);
        }

        return($result);
    }
    
    /**
     * 
     * @param string|object $namespace
     * @return IOwnedData
     */
    public function getData($namespace = '') {
        $result = null;
        $strNS = $this->getNamespace($namespace);
        if( isset($this->arrayObjectData[$strNS]) ){
            $result= $this->arrayObjectData[$strNS];
        }
        return($result);
    }
    

    /**
     * 
     * @param string $name
     * @param string|object $namespace
     * @return mixed
     */
    public function getValue($name, $namespace = '') {
        $strNS = $this->getNamespace($namespace);
        $data = $this->getData($strNS);
        if ( $data !== null ) {
            $result = $data->getValue($name, $this->getOwnerPart($strNS));
        }
        return($result);
    }

    /**
     * 
     * 
     * @param string|object $namespace
     * @return ArrayDataStorage Itself
     */
    protected function setData($namespace = ''){
        $strNS = $this->getNamespace($namespace);
        $owner = $this->getOwnerPart($strNS);
        if ( isset($this->arrayObjectData[$strNS]) ) {
            trigger_error('Owned data with same\''.$strNS.'\' namespace identifier are exists. It will replaced by new.', E_USER_WARNING);
        }
        $this->arrayObjectData[$strNS] = new ArrayOwnedData($owner);
        return($this);
    }
    
    /**
     * 
     * @param type $name
     * @param type $value
     * @param type $namespace
     * @return type
     */
    public function setValue($name, $value, $namespace = '') {
        $strNS = $this->getNamespace($namespace);
        $data = $this->getData($strNS);
        if ( $data !== null ) {
            $data->setValue($name, $value, $this->getOwnerPart($strNS));
        } else {
            $this->setData($strNS);
            $this->setValue($name, $value, $namespace);
        }
        return($this);
    }

}
