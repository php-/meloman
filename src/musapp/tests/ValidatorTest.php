<?php

namespace Musapp\Tests;

use Mockery as m;
use Musapp\Validator;

/**
 * Description of ValidatorTest
 *
 * @author User
 */
class ValidatorTest extends \PHPUnit\Framework\TestCase {
    
    protected function tearDown() {
        m::close();
    }

    function testCheckDateFormat() {
        $format = 'Y-d-m';
            
        $validatorMock = m::mock(new Validator);
        
        $this->assertEquals(false, $validatorMock->checkDateFormat('2017-12-21', $format));
        $this->assertEquals(true, $validatorMock->checkDateFormat('2017-09-03', $format));
        $this->assertEquals(true, $validatorMock->checkDateFormat('20-22-12', $format));
    } 
    
    function testCheckEmail() {
        $validatorMock = m::mock(new Validator);
        
        $this->assertEquals(true, $validatorMock->checkEmail('hi@example.com'));
        $this->assertEquals(false, $validatorMock->checkEmail('hii@example.'));
    }
    
    function testLength() {
        $validatorMock = m::mock(new Validator);
        
        $this->assertEquals(false, $validatorMock->checkLength('hi@example.com',40));
        $this->assertEquals(true, $validatorMock->checkLength('four', 4));
    }
    
    
    
}
