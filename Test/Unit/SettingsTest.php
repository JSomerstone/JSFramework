<?php

namespace JSFramework\Test\Unit;
class SettingsTest extends TestCase
{
    /**
     * @test
     * @expectedException \JSFramework\Exception\RootException
     */
    public function readIniFileFails_non_existing()
    {
        \JSFramework\Settings::readIniFile('/non/existing/ini');
    }

    /**
     * @test
     * @expectedException \JSFramework\Exception\RootException
     */
    public function readIniFileFails_invalid_content()
    {
        $testIni = dirname(__DIR__) . '/Data/invalid.ini';
        \JSFramework\Settings::readIniFile($testIni);
    }

    /**
     * @test
     */
    public function readIniFileSuccees()
    {
        $testIni = dirname(__DIR__) . '/Data/Dummy.ini';

        \JSFramework\Settings::readIniFile($testIni);
        $ini = \JSFramework\Settings::get('SITE');
        $this->assertType($ini, 'array');

        $setting = \JSFramework\Settings::get('SITE', 'PATH_PREFIX');
        $this->assertType($setting, 'string');
    }
}