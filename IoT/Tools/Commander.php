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

namespace IoT\Tools;

use IoT\Entity\IRunnable;

/**
 * Generated: Dec 10, 2017 6:40:51 AM
 * 
 * Description of Commander
 *
 * @author Semyon Mamonov <semyon.mamonov@gmail.com>
 */
class Commander implements IRunnable {
    //put your code here
    
    /**
     *
     * @var TreeNodeEx 
     */
    protected $mainNode = null;
    
    
    public function __construct() {
        
    }
    
    public function add(Command $command, $name){
        $node = new TreeNodeEx($name,$command);
        if ( is_null($this->mainNode) $this->mainNode= $node;
         else 
        
        
        $fullName = $this->getNestedName($name);
        
        
        
        
        
        if () 
        
    }
    
    
    public function run() {
        $sharedData = '';
        $this->mainNode->bubbleWalk(function(TreeNodeEx $node) use (&$sharedData){
            $command = $node->getData();
            if( !is_null($command) && is_a($command, Command::class)  ){
                $command->run();
            }
        });
    }

}
