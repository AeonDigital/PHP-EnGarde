<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\ErrorListening as ErrorListening;

require_once __DIR__ . "/../phpunit.php";







class ErrorListeningTest extends TestCase
{





    public function test_getsetclear_context()
    {
        $val = [
            "rootPath"          => "\\",
            "environmentType"   => "test",
            "isDebugMode"       => true,
            "protocol"          => "http",
            "method"            => "GET",
            "pathToErrorView"   => ""
        ];

        ErrorListening::setContext(
            $val["rootPath"],
            $val["environmentType"],
            $val["isDebugMode"],
            $val["protocol"],
            $val["method"],
            $val["pathToErrorView"]
        );
        $this->assertSame($val, ErrorListening::getContext());


        ErrorListening::clearContext();
        $val = [
            "rootPath"          => null,
            "environmentType"   => null,
            "isDebugMode"       => null,
            "protocol"          => null,
            "method"            => null,
            "pathToErrorView"   => null
        ];
        $this->assertSame($val, ErrorListening::getContext());


        $val = [
            "rootPath"          => "\\",
            "environmentType"   => "testview",
            "isDebugMode"       => true,
            "protocol"          => "http",
            "method"            => "GET",
            "pathToErrorView"   => ""
        ];

        ErrorListening::setContext(
            $val["rootPath"],
            $val["environmentType"],
            $val["isDebugMode"],
            $val["protocol"],
            $val["method"],
            $val["pathToErrorView"]
        );
        $this->assertSame($val, ErrorListening::getContext());

    }


    public function test_method_setpathtoerrorview()
    {
        ErrorListening::clearContext();
        $this->assertSame(null, ErrorListening::getContext()["pathToErrorView"]);

        $val = "pathToFile.phtml";
        ErrorListening::setPathToErrorView($val);
        $this->assertSame($val, ErrorListening::getContext()["pathToErrorView"]);
    }


    public function test_method_onexception()
    {
        provider_PHPEnGardeConfig_Configure_ErrorListening();
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "errorlistening/onexception.php";
        $expected           = include($tgtPathToExpected);

        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);
            //file_put_contents($tgtPathToExpected, "<?php return " . var_export($r, true) . ";");

            $this->assertSame($expected["rootPath"], $r["rootPath"]);
            $this->assertSame($expected["environmentType"], $r["environmentType"]);
            $this->assertSame($expected["isDebugMode"], $r["isDebugMode"]);
            $this->assertSame($expected["http"], $r["http"]);
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_onerror()
    {
        provider_PHPEnGardeConfig_Configure_ErrorListening();
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "errorlistening/onerror.php";
        $expected           = include($tgtPathToExpected);

        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onError(
                $ex->getCode(),
                $ex->getMessage(),
                $ex->getFile(),
                (int)$ex->getLine()
            );
            //file_put_contents($tgtPathToExpected, "<?php return " . var_export($r, true) . ";");

            $this->assertSame($expected["rootPath"], $r["rootPath"]);
            $this->assertSame($expected["environmentType"], $r["environmentType"]);
            $this->assertSame($expected["isDebugMode"], $r["isDebugMode"]);
            $this->assertSame($expected["http"], $r["http"]);
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_throwhttperror()
    {
        provider_PHPEnGardeConfig_Configure_ErrorListening();
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "errorlistening/throwhttperror-custom.php";
        $expected           = include($tgtPathToExpected);

        $r = ErrorListening::throwHTTPError(501, "custom reason phrase");
        //file_put_contents($tgtPathToExpected, "<?php return " . var_export($r, true) . ";");
        $rStr           = var_export($r, true);
        $expectedStr    = var_export($expected, true);
        $this->assertSame($expectedStr, $rStr);



        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "errorlistening/throwhttperror.php";
        $expected           = include($tgtPathToExpected);

        $r = ErrorListening::throwHTTPError(501);
        //file_put_contents($tgtPathToExpected, "<?php return " . var_export($r, true) . ";");
        $rStr           = var_export($r, true);
        $expectedStr    = var_export($expected, true);
        $this->assertSame($expectedStr, $rStr);
    }


    public function test_method_testview_json_fail()
    {
        provider_PHPEnGardeConfig_Configure_ErrorListening(false, "testview", "POST");
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "errorlistening/testview.json";
        $expected           = file_get_contents($tgtPathToExpected);


        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);

            $rStr = json_encode($r);
            //file_put_contents($tgtPathToExpected, json_encode($r));
            $this->assertSame($expected, $rStr);
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_testview_json_debug()
    {
        provider_PHPEnGardeConfig_Configure_ErrorListening(true, "testview", "POST");
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "errorlistening/testview-debug.json";
        $expected           = file_get_contents($tgtPathToExpected);


        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);

            $rJSON          = json_decode($r);
            $expectedJSON   = json_decode($expected);

            //file_put_contents($tgtPathToExpected, $r);
            $this->assertSame($expectedJSON->code,      $rJSON->code);
            $this->assertSame($expectedJSON->message,   $rJSON->message);
            $this->assertSame($expectedJSON->file,      $rJSON->file);
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_return_testview_nonstyled()
    {
        provider_PHPEnGardeConfig_Configure_ErrorListening(false, "testview", "GET");
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "errorlistening/nonstyled.html";
        $expected           = file_get_contents($tgtPathToExpected);


        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);

            //file_put_contents($tgtPathToExpected, $r);
            $this->assertSame($expected, $r);
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_return_testview_custom()
    {
        $tgtCustomTemplate = __DIR__ . DIRECTORY_SEPARATOR . "errorlistening/customErrorView.phtml";
        provider_PHPEnGardeConfig_Configure_ErrorListening(false, "testview", "GET", $tgtCustomTemplate);
        $tgtPathToExpected  = __DIR__ . DIRECTORY_SEPARATOR . "errorlistening/custom.html";
        $expected           = file_get_contents($tgtPathToExpected);


        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);

            //file_put_contents($tgtPathToExpected, $r);
            $this->assertSame($expected, $r);
        }
        $this->assertTrue($fail, "Test must fail");
    }
}
