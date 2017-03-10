<?php


namespace Musapp\Tests;

use Mockery as m;
use Musapp\Authenticator;

/**
 * Description of AuthenticatorTest
 *
 * @author User
 */
class AuthenticatorTest extends \PHPUnit\Framework\TestCase {
    function tearDown() {
        m::close();
    }
    
    function testValidate() {
        $modelMock = m::mock("Model")
                ->shouldReceive("getAllEntries")
                ->once()
                ->andReturn(['username'=>'george@garcha.com','password'=>'22314']);
        //...
        
    }
}
