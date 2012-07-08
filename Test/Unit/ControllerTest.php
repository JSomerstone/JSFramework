<?php

namespace JSFramework\Test\Unit;

/**
 * Test class for Request.
 */
class ControllerTest extends TestCase
{
    protected $requestMock;
    protected $controllerStub;


    public function setUp()
    {
        $this->fakeRequest('Fuu', 'Bar');

        $this->requestMock = $this->getMock('\JSFramework\Request');
        $this->requestMock
                ->expects($this->any())
                ->method('getAction')
                ->will($this->returnValue('setup'));

        $this->controllerStub = $this->getMockForAbstractClass(
            '\JSFramework\Controller',
            array($this->requestMock)
        );
    }

    /**
     * @covers JSFramework\Controller::__construct
     */
    public function test__construct()
    {
        $this->controllerStub = $this->getMockForAbstractClass(
            '\JSFramework\Controller',
            array($this->requestMock)
        );
    }

    /**
     * @covers JSFramework\Controller::run
     */
    public function testRun()
    {
        $this->requestMock
                ->expects($this->any())
                ->method('getAction')
                ->will($this->returnValue(''));

        $this->controllerStub = $this->getMockForAbstractClass(
            '\JSFramework\Controller',
            array($this->requestMock)
        );

        $this->assertEmpty($this->controllerStub->run());
    }

}