<?php

namespace JSFramework\Test\Unit;

require __DIR__ . '/../testAutoloader.php';
require_once __DIR__ . '/../../Source/Request.php';

/**
 * Test class for Request.
 */
class RequestTest extends TestCase
{

    /**
     * @var Request
     */
    protected $object;

    protected $defualtPost = array('not' => 'empty');
    protected $defualtGet = array('nor' => 'this');
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $_GET = $this->defualtGet;
        $_POST = $this->defualtPost;

        $this->object = new \JSFramework\Request();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers keijoCMS\Core\Request::__contstruct
     */
    public function test__construct()
    {
        $this->assertObjectHasAttribute('postParams', $this->object);
        $this->assertObjectHasAttribute('getParams', $this->object);
        $this->assertObjectHasAttribute('requestParams', $this->object);

        $this->assertEmpty($_POST, 'POST not cleared');
        $this->assertEmpty($_GET, 'GET not cleared');
    }

    /**
     * @covers keijoCMS\Core\Request::getPost
     */
    public function testGetPost()
    {
        //Post without index should return whole defaultPost
        $this->assertEquals($this->defualtPost, $this->object->getPost());
        //Post with index should return same index from defaultPost
        $this->assertEquals($this->defualtPost['not'], $this->object->getPost('not'));

        //Post with non-existing index should return NULL
        $this->assertEquals(null, $this->object->getPost('non existing'));
    }

    /**
     * @covers keijoCMS\Core\Request::getGet
     */
    public function testGetGet()
    {
        //Get without index should return whole defaultPost
        $this->assertEquals($this->defualtGet, $this->object->getGet());
        //Get with index should return same index from defaultPost
        $this->assertEquals($this->defualtGet['nor'], $this->object->getGet('nor'));

        //Get with non-existing index should return NULL
        $this->assertEquals(null, $this->object->getPost('failure'));
    }

    /*
     * @covers keijoCMS\Core\Request::getRequest
     */
    public function testGetRequest()
    {
        $joined = array_merge($this->defualtGet, $this->defualtPost);
        $this->assertEquals($joined, $this->object->getRequest());

        //Get with index should return same index from defaultPost / -Get
        $this->assertEquals($this->defualtGet['nor'], $this->object->getRequest('nor'));
        $this->assertEquals($this->defualtPost['not'], $this->object->getRequest('not'));

        //Get with non-existing index should return NULL
        $this->assertEquals(null, $this->object->getRequest('failure'));
    }

    public function testUnsetGet()
    {
        $this->object->unsetGet('nor');
        $this->assertNull($this->object->getGet('nor'));
    }

    public function testUnsetPost()
    {
        $this->object->unsetPost('not');
        $this->assertNull($this->object->getGet('not'));
    }

}
