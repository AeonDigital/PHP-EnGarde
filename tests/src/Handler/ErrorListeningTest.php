<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Handler\ErrorListening as ErrorListening;

require_once __DIR__ . "/../../phpunit.php";







class ErrorListeningTest extends TestCase
{





    function configureErrorListening(
        $env = "UTEST",
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
        // GET | DebugMode-OFF
        $this->configureErrorListening();

        $tgtPathToExpected  = to_system_path($dirResources . "/errorlistening/onexception-get-debugmodeoff.php");
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
            $expected = str_replace(["\r", "\n"], "", $expected);
        }


        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);

            if ($expected === null) {
                $expected = str_replace(["\r", "\n"], "", $r);
                file_put_contents($tgtPathToExpected, $expected);
            }

            $this->assertSame(
                $expected,
                str_replace(["\r", "\n"], "", $r),
            );
        }
        $this->assertTrue($fail, "Test must fail");



        // GET | DebugMode-ON
        $this->configureErrorListening("UTEST", true);


        $tgtPathToExpected  = to_system_path($dirResources . "/errorlistening/onexception-get-debugmodeon.php");
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
            $expected = str_replace(["\r", "\n"], "", $expected);
        }


        $fail = false;
        try {
            $val = 1 / 0;
        } catch (\Exception $ex) {
            $fail = true;
            $r = ErrorListening::onException($ex);

            if ($expected === null) {
                $expected = str_replace(["\r", "\n"], "", $r);
                file_put_contents($tgtPathToExpected, $expected);
            }

            $this->assertSame(
                $expected,
                str_replace(["\r", "\n"], "", $r),
            );
        }
        $this->assertTrue($fail, "Test must fail");
    }



    public function test_method_onerror()
    {
        global $dirResources;
        // POST | DebugMode-OFF
        $this->configureErrorListening("UTEST", false, "POST");

        $tgtPathToExpected  = to_system_path($dirResources . "/errorlistening/onerror-get-debugmodeoff.php");
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
            $expected = str_replace(["\r", "\n"], "", $expected);
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
                $expected = str_replace(["\r", "\n"], "", $r);
                file_put_contents($tgtPathToExpected, $expected);
            }

            $this->assertSame(
                $expected,
                str_replace(["\r", "\n"], "", $r),
            );
        }
        $this->assertTrue($fail, "Test must fail");



        // POST | DebugMode-ON
        $this->configureErrorListening("UTEST", true, "POST");

        $tgtPathToExpected  = to_system_path($dirResources . "/errorlistening/onerror-get-debugmodeon.php");
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
            $expected = str_replace(["\r", "\n"], "", $expected);
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
                $expected = str_replace(["\r", "\n"], "", $r);
                file_put_contents($tgtPathToExpected, $expected);
            }

            $this->assertSame(
                $expected,
                str_replace(["\r", "\n"], "", $r),
            );
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
            $expected = file_get_contents($tgtPathToExpected);
            $expected = str_replace(["\r", "\n"], "", $expected);
        }


        $r = ErrorListening::throwHTTPError(501, "custom reason phrase");
        if ($expected === null) {
            $expected = str_replace(["\r", "\n"], "", $r);
            file_put_contents($tgtPathToExpected, $expected);
        }
        $this->assertSame($expected, str_replace(["\r", "\n"], "", $r));



        $tgtPathToExpected  = $dirResources . "/errorlistening/throwhttperror.php";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
            $expected = str_replace(["\r", "\n"], "", $expected);
        }


        $r = ErrorListening::throwHTTPError(501);
        if ($expected === null) {
            $expected = str_replace(["\r", "\n"], "", $r);
            file_put_contents($tgtPathToExpected, $expected);
        }
        $this->assertSame($expected, str_replace(["\r", "\n"], "", $r));
    }
}
