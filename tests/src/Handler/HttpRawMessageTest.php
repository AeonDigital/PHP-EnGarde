<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Handler\HttpRawMessage as HttpRawMessage;

require_once __DIR__ . "/../../phpunit.php";







class HttpRawMessageTest extends TestCase
{





    function configureHttpRawMessage(
        $env = "UTEST",
        $debugMode = false,
        $method = "get",
        $pathToErrorView = "",
        $pathToHttpMessageView = ""
    ) {
        global $dirResources;

        HttpRawMessage::setContext(
            $dirResources . "/apps",
            $env,
            $debugMode,
            "http",
            $method,
            $pathToErrorView,
            $pathToHttpMessageView
        );
    }





    public function test_getsetclear_context()
    {
        $val = [
            "rootPath"              => DS,
            "environmentType"       => "UTEST",
            "isDebugMode"           => true,
            "protocol"              => "http",
            "method"                => "GET",
            "pathToErrorView"       => "",
            "pathToHttpMessageView" => ""
        ];

        HttpRawMessage::setContext(
            $val["rootPath"],
            $val["environmentType"],
            $val["isDebugMode"],
            $val["protocol"],
            $val["method"],
            $val["pathToErrorView"],
            $val["pathToHttpMessageView"]
        );
        $this->assertSame($val, HttpRawMessage::getContext());


        HttpRawMessage::clearContext();
        $val = [
            "rootPath"              => "",
            "environmentType"       => "",
            "isDebugMode"           => false,
            "protocol"              => "",
            "method"                => "",
            "pathToErrorView"       => "",
            "pathToHttpMessageView" => ""
        ];
        $this->assertSame($val, HttpRawMessage::getContext());


        $val = [
            "rootPath"              => DS,
            "environmentType"       => "UTEST",
            "isDebugMode"           => true,
            "protocol"              => "http",
            "method"                => "GET",
            "pathToErrorView"       => "",
            "pathToHttpMessageView" => ""
        ];

        HttpRawMessage::setContext(
            $val["rootPath"],
            $val["environmentType"],
            $val["isDebugMode"],
            $val["protocol"],
            $val["method"],
            $val["pathToErrorView"],
            $val["pathToHttpMessageView"]
        );
        $this->assertSame($val, HttpRawMessage::getContext());
    }



    public function test_method_setpathtoerrorview()
    {
        HttpRawMessage::clearContext();
        $this->assertSame("", HttpRawMessage::getContext()["pathToErrorView"]);

        $val = "pathToFile.phtml";
        HttpRawMessage::setPathToErrorView($val);
        $this->assertSame($val, HttpRawMessage::getContext()["pathToErrorView"]);
    }



    public function test_method_setpathtohttpmessageview()
    {
        HttpRawMessage::clearContext();
        $this->assertSame("", HttpRawMessage::getContext()["pathToHttpMessageView"]);

        $val = "pathToFile.phtml";
        HttpRawMessage::setPathToHttpMessageView($val);
        $this->assertSame($val, HttpRawMessage::getContext()["pathToHttpMessageView"]);
    }



    public function test_method_onexception()
    {
        global $dirResources;
        // GET | DebugMode-OFF
        $this->configureHttpRawMessage();

        $tgtPathToExpected  = to_system_path($dirResources . "/httprawmessage/onexception-get-debugmodeoff.php");
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
            $r = HttpRawMessage::onException($ex);

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
        $this->configureHttpRawMessage("UTEST", true);


        $tgtPathToExpected  = to_system_path($dirResources . "/httprawmessage/onexception-get-debugmodeon.php");
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
            $r = HttpRawMessage::onException($ex);

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
        $this->configureHttpRawMessage("UTEST", false, "POST");

        $tgtPathToExpected  = to_system_path($dirResources . "/httprawmessage/onerror-get-debugmodeoff.php");
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
            $r = HttpRawMessage::onError(
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
        $this->configureHttpRawMessage("UTEST", true, "POST");

        $tgtPathToExpected  = to_system_path($dirResources . "/httprawmessage/onerror-get-debugmodeon.php");
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
            $r = HttpRawMessage::onError(
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
        $this->configureHttpRawMessage();

        $tgtPathToExpected  = $dirResources . "/httprawmessage/throwhttperror-custom.php";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
            $expected = str_replace(["\r", "\n"], "", $expected);
        }


        $r = HttpRawMessage::throwHttpError(501, "custom reason phrase");
        if ($expected === null) {
            $expected = str_replace(["\r", "\n"], "", $r);
            file_put_contents($tgtPathToExpected, $expected);
        }
        $this->assertSame($expected, str_replace(["\r", "\n"], "", $r));



        $tgtPathToExpected  = $dirResources . "/httprawmessage/throwhttperror.php";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
            $expected = str_replace(["\r", "\n"], "", $expected);
        }


        $r = HttpRawMessage::throwHttpError(501);
        if ($expected === null) {
            $expected = str_replace(["\r", "\n"], "", $r);
            file_put_contents($tgtPathToExpected, $expected);
        }
        $this->assertSame($expected, str_replace(["\r", "\n"], "", $r));
    }



    public function test_method_throwhttpmessage()
    {
        global $dirResources;
        $this->configureHttpRawMessage();

        $tgtPathToExpected  = $dirResources . "/httprawmessage/throwhttpmessage-custom.php";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
            $expected = str_replace(["\r", "\n"], "", $expected);
        }


        $r = HttpRawMessage::throwHttpMessage(501, "custom reason phrase");
        if ($expected === null) {
            $expected = str_replace(["\r", "\n"], "", $r);
            file_put_contents($tgtPathToExpected, $expected);
        }
        $this->assertSame($expected, str_replace(["\r", "\n"], "", $r));



        $tgtPathToExpected  = $dirResources . "/httprawmessage/throwhttpmessage.php";
        $expected = null;
        if (file_exists($tgtPathToExpected) === true) {
            $expected = file_get_contents($tgtPathToExpected);
            $expected = str_replace(["\r", "\n"], "", $expected);
        }


        $r = HttpRawMessage::throwHttpMessage(501);
        if ($expected === null) {
            $expected = str_replace(["\r", "\n"], "", $r);
            file_put_contents($tgtPathToExpected, $expected);
        }
        $this->assertSame($expected, str_replace(["\r", "\n"], "", $r));
    }

}
