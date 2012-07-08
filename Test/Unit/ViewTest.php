<?php

namespace JSFramework\Test\Unit;

class ViewTest extends TestCase
{
    /**
     *
     * @var ViewMock
     */
    public $subject;

    public function setUp()
    {
        $this->subject = new ViewMock();
        \JSFramework\NativeFunctions::resetHeaders();
    }

    public function setterValueProvider()
    {
        return array(
            'String' => array('String can be stored'),
            'Integer' => array(37),
            'Array' => array( array('Foo' => 'Bar') ),
            'Object' => array ( new \DateTime() ),
            'Null' => array( null ),
        );
    }

    /**
     * @test
     * @covers  \JSFramework\View::set
     * @dataProvider setterValueProvider
     * @param misc $value
     */
    public function settingPropertySuccees($value)
    {
        $this->subject->set('existingProperty', $value);
        $this->assertEquals($value, $this->subject->existingProperty);
    }

    /**
     * @test
     * @covers  \JSFramework\View::set
     * @expectedException \JSFramework\Exception\RootException
     */
    public function settingNonExistingPropretyFails()
    {
        $this->subject->set('nonExistingProperty' , 'anything');
    }

    /**
     * @test
     * @covers  \JSFramework\View::bind
     */
    public function bindingVarialbeToViewSuccees()
    {
        $bindedVariable = 'One';
        $this->subject->bind('number', $bindedVariable);

        $this->assertEquals($bindedVariable, $this->subject->number);

        $bindedVariable = 'Two';

        $this->assertEquals($bindedVariable, $this->subject->number);
    }

    /**
     * @test
     * @covers  \JSFramework\View::bind
     * @expectedException \JSFramework\Exception\RootException
     */
    public function bindingNonExistingPropretyFails()
    {
        $variable = 'Fuu';
        $this->subject->bind('nonExistingProperty' , $variable);
    }

    /**
     * @test
     * @covers \JSFramework\View::setErrorCode
     */
    public function settingErrorCode()
    {
        $this->subject->setErrorCode(404);
        $this->assertEquals(404, $this->subject->getErrorCode());
    }

    /**
     * @test
     * @covers \JSFramework\View::addErrorMessage
     */
    public function addingErrorMessage()
    {
        $errorMsg = 'Requested failure not found';
        $this->subject->addErrorMessage($errorMsg);
        $this->assertEquals(array($errorMsg), $this->subject->getErrorMessages());
    }

    /**
     * @test
     * @covers \JSFramework\View::output
     */
    public function testOutput()
    {
        ob_start();
        $this->subject->output();
        $output = ob_get_clean();

        $this->assertEquals('Mocked View', $output);
        $this->assertEquals(
            array('HTTP/1.1 200 Ok'),
            \JSFramework\NativeFunctions::getHeaders()
        );
    }

    /**
     * @test
     * @covers \JSFramework\View::_setHeaderAccordingToErrorCode
     */
    public function testOutputtingOfErrorCode()
    {
        ob_start();
        $this->subject->setErrorCode(\JSFramework\View::ERROR_CODE_INTERNAL_ERROR);
        $this->subject->output();
        $output = ob_get_clean();

        $this->assertEquals('Mocked View', $output);
        $this->assertEquals(
            array('HTTP/1.1 500 Internal Server Error'),
            \JSFramework\NativeFunctions::getHeaders()
        );
    }
}

class ViewMock extends \JSFramework\View
{
    public $number;
    public $existingProperty;

    public function __toString()
    {
        return 'Mocked View';
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getErrorMessages()
    {
        return $this->errorMessages;
    }
}