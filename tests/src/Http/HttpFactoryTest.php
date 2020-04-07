<?php
declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use AeonDigital\EnGarde\Config\Factory as Factory;

require_once __DIR__ . "/../../phpunit.php";







class HttpFactoryTest extends TestCase
{





    public function test_method_create_header_collection()
    {
        $expected = [
            "h1" => "v1",
            "h2" => "v2",
            "h3" => "v3"
        ];

        $nMock = prov_instanceOf_EnGarde_HttpFactory();
        $newObj = $nMock->createHeaderCollection($expected);

        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Data\\iHeaderCollection", class_implements($newObj)));

        $result = $newObj->toArray(true);
        $this->assertSame(count($expected), count($result));
        foreach ($expected as $key => $value) {
            $this->assertTrue($newObj->has($key));
            $this->assertSame((string)$value, $newObj->getHeaderLine($key));
        }
    }


    public function test_method_create_cookie_collection()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();
        $headers = [
            "COOKIE" => "first=primeiro valor: rianna@gmail.com;second=segundo valor: http://aeondigital.com.br"
        ];


        $newObj = $nMock->createCookieCollection($headers["COOKIE"]);
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Data\\iCookieCollection", class_implements($newObj)));
        $this->assertTrue($newObj->has("first"));
        $this->assertSame("primeiro%20valor%3A%20rianna%40gmail.com", $newObj->get("first")->getValue(false));
        $this->assertSame("primeiro valor: rianna@gmail.com", $newObj->get("first")->getValue());
        $this->assertTrue($newObj->has("second"));
        $this->assertSame("segundo%20valor%3A%20http%3A%2F%2Faeondigital.com.br", $newObj->get("second")->getValue(false));
        $this->assertSame("segundo valor: http://aeondigital.com.br", $newObj->get("second")->getValue());


        $cookies = \AeonDigital\Http\Data\Cookie::fromRawCookieHeader($headers["COOKIE"]);
        $newObj = $nMock->createCookieCollection($cookies);
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Data\\iCookieCollection", class_implements($newObj)));
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Data\\iCookieCollection", class_implements($newObj)));
        $this->assertTrue($newObj->has("first"));
        $this->assertSame("primeiro%20valor%3A%20rianna%40gmail.com", $newObj->get("first")->getValue(false));
        $this->assertSame("primeiro valor: rianna@gmail.com", $newObj->get("first")->getValue());
        $this->assertTrue($newObj->has("second"));
        $this->assertSame("segundo%20valor%3A%20http%3A%2F%2Faeondigital.com.br", $newObj->get("second")->getValue(false));
        $this->assertSame("segundo valor: http://aeondigital.com.br", $newObj->get("second")->getValue());


        $newObj = $nMock->createCookieCollection(0);
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Data\\iCookieCollection", class_implements($newObj)));
        $this->assertSame(0, $newObj->count());
    }


    public function test_method_create_querystring_collection()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();
        $headers = [
            "QUERY_STRING" => "qskey1=valor 1&qskey2=valor 2"
        ];


        $newObj = $nMock->createQueryStringCollection($headers["QUERY_STRING"]);
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Data\\iQueryStringCollection", class_implements($newObj)));
        $this->assertTrue($newObj->has("qskey1"));
        $this->assertSame("valor%201", $newObj->get("qskey1"));
        $this->assertTrue($newObj->has("qskey2"));
        $this->assertSame("valor%202", $newObj->get("qskey2"));


        $qs = "nparam1=param 1 value set&nparam2=param 2 value set";
        $newObj = $nMock->createQueryStringCollection($qs);
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Data\\iQueryStringCollection", class_implements($newObj)));
        $this->assertTrue($newObj->has("nparam1"));
        $this->assertSame("param%201%20value%20set", $newObj->get("nparam1"));
        $this->assertTrue($newObj->has("nparam2"));
        $this->assertSame("param%202%20value%20set", $newObj->get("nparam2"));


        $qs = ["aparam1" => "param 1 value set", "aparam2" => "param 2 value set"];
        $newObj = $nMock->createQueryStringCollection($qs);
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Data\\iQueryStringCollection", class_implements($newObj)));
        $this->assertTrue($newObj->has("aparam1"));
        $this->assertSame("param%201%20value%20set", $newObj->get("aparam1"));
        $this->assertTrue($newObj->has("aparam2"));
        $this->assertSame("param%202%20value%20set", $newObj->get("aparam2"));


        $newObj = $nMock->createQueryStringCollection(0);
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Data\\iQueryStringCollection", class_implements($newObj)));
        $this->assertSame(0, $newObj->count());
    }


    public function test_methdod_create_file_collection()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();

        $newObj = $nMock->createFileCollection();
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Data\\iFileCollection", class_implements($newObj)));
        $this->assertSame(0, $newObj->count());



        prov_defineGlobal_FILES();
        $initialValues = [];
        if (isset($_FILES) === true && count($_FILES) > 0) {
            foreach ($_FILES as $fieldName => $fieldData) {
                if (is_array($fieldData["error"]) === false) {
                    $initialValues[$fieldName] = new \AeonDigital\Http\Data\File(
                        new \AeonDigital\Http\Stream\FileStream($fieldData["tmp_name"]),
                        $fieldData["name"],
                        $fieldData["error"]
                    );
                } else {
                    $initialValues[$fieldName] = [];

                    foreach ($fieldData["name"] as $i => $v) {
                        $initialValues[$fieldName][] = new \AeonDigital\Http\Data\File(
                            new \AeonDigital\Http\Stream\FileStream($fieldData["tmp_name"][$i]),
                            $fieldData["name"][$i],
                            $fieldData["error"][$i]
                        );
                    }
                }
            }
        }


        $newObj = $nMock->createFileCollection($initialValues);
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Data\\iFileCollection", class_implements($newObj)));
        $this->assertSame(2, $newObj->count());

        $this->assertSame("ua-file-name.png", $newObj->get("fieldOne")->getClientFilename());
        $this->assertSame(10552, $newObj->get("fieldOne")->getSize());
        $this->assertSame("image/png", $newObj->get("fieldOne")->getClientMediaType());


        $multiField = $newObj->get("multiField");
        $this->assertSame(2, $newObj->count());
        $this->assertSame("upload-image-1.jpg", $multiField[0]->getClientFilename());
        $this->assertSame(10552, $multiField[0]->getSize());
        $this->assertSame("image/jpeg", $multiField[0]->getClientMediaType());

        $this->assertSame("upload-image-1.jpg", $multiField[1]->getClientFilename());
        $this->assertSame(10552, $multiField[1]->getSize());
        $this->assertSame("image/jpeg", $multiField[1]->getClientMediaType());


        $newObj->dropStreams();
        $newObj->clean();
    }


    public function test_method_create_uri()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();

        $expected = "http://test.server.com.br?param1=value1&param2=value2";

        $newObj = $nMock->createUri($expected);
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Uri\\iUrl", class_implements($newObj)));
        $this->assertSame($expected, $newObj->getAbsoluteUri());
    }


    public function test_method_create_stream()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();

        $useBody = "Test Body";
        $newObj = $nMock->createStream($useBody);

        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Stream\\iStream", class_implements($newObj)));
        $this->assertSame($useBody, (string)$newObj);
    }


    public function test__method_create_stream_from_file()
    {
        global $dirResources;

        $nMock = prov_instanceOf_EnGarde_HttpFactory();

        $tgtFile = to_system_path($dirResources . "/files/image-resource.jpg");
        $newObj = $nMock->createStreamFromFile($tgtFile);

        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Stream\\iFileStream", class_implements($newObj)));
        $this->assertSame($tgtFile, $newObj->getPathToFile());
    }


    public function test_method_create_stream_from_resource()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();

        $useBody = "Test Body";
        $useStream = fopen("data://text/plain;base64,", "r+");
        fwrite($useStream, $useBody);

        $newObj = $nMock->createStreamFromResource($useStream);

        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Stream\\iStream", class_implements($newObj)));
        $this->assertSame($useBody, (string)$newObj);
    }


    public function test_method_create_stream_from_body_request()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();

        $newObj = $nMock->createStreamFromBodyRequest();

        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Stream\\iStream", class_implements($newObj)));
        $this->assertSame("", (string)$newObj);
    }


    public function test_method_create_collection()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();
        $newObj = $nMock->createCollection();
        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Collection\\iCollection", class_implements($newObj)));
    }


    public function test_method_create_request_fail()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();
        try {
            $newObj = $nMock->createRequest("INVALID", "test.server.com.br");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid method [ \"INVALID\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_create_request()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();
        $newObj = $nMock->createRequest("", "test.server.com.br");

        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Message\\iRequest", class_implements($newObj)));
        $this->assertSame("GET", $newObj->getMethod());
        $this->assertSame("1.1", $newObj->getProtocolVersion());
        $this->assertSame("", $newObj->getHeaderLine("host"));
    }


    public function test_method_create_server_request_fail()
    {
        $fail = false;
        try {
            $nMock = prov_instanceOf_EnGarde_HttpFactory();
            $newObj = $nMock->createServerRequest("INVALID", "test.server.com.br?qskey1=valor 1&qskey2=valor 2");
        } catch (\Exception $ex) {
            $fail = true;
            $this->assertSame("Invalid method [ \"INVALID\" ].", $ex->getMessage());
        }
        $this->assertTrue($fail, "Test must fail");
    }


    public function test_method_create_server_request()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();
        $newObj = $nMock->createServerRequest("", "test.server.com.br?qskey1=valor 1&qskey2=valor 2");

        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Message\\iServerRequest", class_implements($newObj)));
        $this->assertSame("GET", $newObj->getMethod());
        $this->assertSame("1.1", $newObj->getProtocolVersion());
        $this->assertSame("", $newObj->getHeaderLine("host"));
    }


    public function test_method_create_response()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();
        $newObj = $nMock->createResponse();

        $this->assertTrue(in_array("AeonDigital\\Interfaces\\Http\\Message\\iResponse", class_implements($newObj)));
        $this->assertSame(200, $newObj->getStatusCode());
        $this->assertSame("OK", $newObj->getReasonPhrase());
    }










    public function test_method_execute_request()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();
        $parans = [
            "foo"=>"bar",
            "baz"=>"boom",
            "cow"=>"milk"
        ];
        $result = $nMock->executeRequest("GET", "http://google.com#ignore-hash", $parans);
        $this->assertNotNull($result);
    }
    /*
    public function test_method_execute_download()
    {
        $nMock = prov_instanceOf_EnGarde_HttpFactory();

        $ds = DIRECTORY_SEPARATOR;

        $absoluteURL = "http://aeondigital.com.br/Site/resources/img/desktop/bg_01.jpg";
        $absoluteSystemPathToDir = __DIR__ . $ds . "files" . $ds;

        // Exclui arquivo de teste
        $fileName = "background.jpg";
        @unlink($absoluteSystemPathToDir . $fileName);

        // Altera a extenção do arquivo para salvar
        // a extenção original deve ser mantida
        $fileName = "background.txt";


        $result = $nMock->executeDownload(
            $absoluteURL,
            $absoluteSystemPathToDir,
            $fileName
        );


        // Mantem a extenção original do arquivo.
        $fileName = "background.jpg";
        $this->assertTrue($result);
        $this->assertTrue(file_exists($absoluteSystemPathToDir . $fileName));
    }*/
}
