<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Handler\ErrorListening as ErrorListening;

require_once __DIR__ . "/../../phpunit.php";







class ErrorListeningTest extends TestCase
{





    function configureErrorListening(
        $env = "test",
        $debugMode = false,
        $method = "get",
        $pathToErrorView = ""
    ) {
        global $dirResources;

        ErrorListening::setContext(
            $dirResources . "/apps",
            $env,
            $debugMode,
            "http",
            $method,
            $pathToErrorView
        );
    }





    public function test_getsetclear_context()
    {
        $val = [
            "rootPath"          => "\\",
            "environmentType"   => "UTEST",
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
            "rootPath"          => "",
            "environmentType"   => "",
            "isDebugMode"       => false,
            "protocol"          => "",
            "method"            => "",
            "pathToErrorView"   => ""
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
        $this->assertSame("", ErrorListening::getContext()["pathToErrorView"]);

        $val = "pathToFile.phtml";
        ErrorListening::setPathToErrorView($val);
        $this->assertSame($val, ErrorListening::getContext()["pathToErrorView"]);
    }



    public function test_method_onexception()
    {
        global $dirResources;
        $this->configureErrorListening();

        $tgtPathToExpected  = to_system_path($dirResources . "/errorlistening/onexception.php");
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = include($tgtPathToExpected);
        }


        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);

            if ($expected === null) {
                file_put_contents($tgtPathToExpected, "<?php return " . var_export($r, true) . ";");
                $expected = $r;
            }

            $this->assertSame($expected["rootPath"], $r["rootPath"]);
            $this->assertSame($expected["environmentType"], $r["environmentType"]);
            $this->assertSame($expected["isDebugMode"], $r["isDebugMode"]);
            $this->assertSame($expected["http"], $r["http"]);
        }
        $this->assertTrue($fail, "Test must fail");
    }



    public function test_method_onerror()
    {
        global $dirResources;
        $this->configureErrorListening();

        $tgtPathToExpected  = to_system_path($dirResources . "/errorlistening/onerror.php");
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = include($tgtPathToExpected);
        }


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

            if ($expected === null) {
                file_put_contents($tgtPathToExpected, "<?php return " . var_export($r, true) . ";");
                $expected = $r;
            }

            $this->assertSame($expected["rootPath"], $r["rootPath"]);
            $this->assertSame($expected["environmentType"], $r["environmentType"]);
            $this->assertSame($expected["isDebugMode"], $r["isDebugMode"]);
            $this->assertSame($expected["http"], $r["http"]);
        }
        $this->assertTrue($fail, "Test must fail");
    }



    public function test_method_throwhttperror()
    {
        global $dirResources;
        $this->configureErrorListening();

        $tgtPathToExpected  = $dirResources . "/errorlistening/throwhttperror-custom.php";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = include($tgtPathToExpected);
        }


        $r = ErrorListening::throwHTTPError(501, "custom reason phrase");
        if ($expected === null) {
            file_put_contents($tgtPathToExpected, "<?php return " . var_export($r, true) . ";");
            $expected = $r;
        }
        $rStr           = var_export($r, true);
        $expectedStr    = var_export($expected, true);
        $this->assertSame($expectedStr, $rStr);



        $tgtPathToExpected  = $dirResources . "/errorlistening/throwhttperror.php";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = include($tgtPathToExpected);
        }

        $r = ErrorListening::throwHTTPError(501);
        if ($expected === null) {
            file_put_contents($tgtPathToExpected, "<?php return " . var_export($r, true) . ";");
            $expected = $r;
        }
        $rStr           = var_export($r, true);
        $expectedStr    = var_export($expected, true);
        $this->assertSame($expectedStr, $rStr);
    }



    public function test_method_testview_json_fail()
    {
        global $dirResources;
        $this->configureErrorListening("testview", false, "POST");

        $tgtPathToExpected  = $dirResources . "/errorlistening/testview.json";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
        }


        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);

            if ($expected === null) {
                file_put_contents($tgtPathToExpected, $r);
                $expected = $r;
            }
            $this->assertSame($expected, $r);
        }
        $this->assertTrue($fail, "Test must fail");
        $this->assertTrue(true);
    }




    public function test_method_testview_json_debug()
    {
        global $dirResources;
        $this->configureErrorListening("testview", true, "POST");

        $tgtPathToExpected  = $dirResources . "/errorlistening/testview-debug.json";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
        }


        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);

            if ($expected === null) {
                file_put_contents($tgtPathToExpected, $r);
                $expected = $r;
            }
            $rJSON          = json_decode($r);
            $expectedJSON   = json_decode($expected);

            $this->assertSame($expectedJSON->code,      $rJSON->code);
            $this->assertSame($expectedJSON->message,   $rJSON->message);
            $this->assertSame($expectedJSON->file,      $rJSON->file);

            $this->assertSame($expected, $r);
        }
        $this->assertTrue($fail, "Test must fail");
    }



    public function test_method_return_testview_nonstyled()
    {
        global $dirResources;
        $this->configureErrorListening("testview", false, "GET");

        $tgtPathToExpected  = $dirResources . "/errorlistening/nonstyled.html";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
        }


        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);

            if ($expected === null) {
                file_put_contents($tgtPathToExpected, $r);
                $expected = $r;
            }
            $this->assertSame($expected, $r);
        }
        $this->assertTrue($fail, "Test must fail");
    }



    public function test_method_return_testview_custom()
    {
        global $dirResources;
        $tgtCustomTemplate = $dirResources . "/errorlistening/customErrorView.phtml";
        $this->configureErrorListening("testview", false, "GET", $tgtCustomTemplate);

        $tgtPathToExpected  = $dirResources . "/errorlistening/custom.html";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
        }


        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);

            if ($expected === null) {
                file_put_contents($tgtPathToExpected, $r);
                $expected = $r;
            }
            $this->assertSame($expected, $r);
        }
        $this->assertTrue($fail, "Test must fail");
    }
}
