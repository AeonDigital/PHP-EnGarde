<?php
declare (strict_types = 1);

namespace AeonDigital\EnGarde\MimeHandler;

use AeonDigital\Http\Message\Interfaces\iServerRequest as iServerRequest;
use AeonDigital\Http\Message\Interfaces\iResponse as iResponse;
use AeonDigital\EnGarde\Config\Interfaces\iServerConfig as iServerConfig;
use AeonDigital\EnGarde\Config\Interfaces\iDomainConfig as iDomainConfig;
use AeonDigital\EnGarde\Config\Interfaces\iApplicationConfig as iApplicationConfig;
use AeonDigital\EnGarde\Config\Interfaces\iRouteConfig as iRouteConfig;
use AeonDigital\EnGarde\MimeHandler\aMimeHandler as aMimeHandler;


/**
 * Manipulador para gerar documentos XLSX.
 * 
 * @package     AeonDigital\EnGarde
 * @version     0.9.0 [alpha]
 * @author      Rianna Cantarelli <rianna@aeondigital.com.br>
 * @copyright   GNUv3
 */
class XLSX extends aMimeHandler
{





    /**
     * Inicia uma nova instância.
     *
     * @param       iServerConfig $serverConfig
     *              Instância "iServerConfig".
     * 
     * @param       iDomainConfig $domainConfig
     *              Instância "iDomainConfig".
     * 
     * @param       iApplicationConfig $applicationConfig
     *              Instância "iApplicationConfig".
     * 
     * @param       iServerRequest $serverRequest
     *              Instância "iServerRequest".
     * 
     * @param       array $rawRouteConfig
     *              Instância "iServerConfig".
     * 
     * @param       iRouteConfig $routeConfig
     *              Instância "iRouteConfig".
     * 
     * @param       iResponse $response
     *              Instância "iResponse".
     */
    function __construct(
        iServerConfig $serverConfig,
        iDomainConfig $domainConfig,
        iApplicationConfig $applicationConfig,
        iServerRequest $serverRequest,
        array $rawRouteConfig,
        iRouteConfig $routeConfig,
        iResponse $response
    ) {
        parent::__construct(
            $serverConfig,
            $domainConfig,
            $applicationConfig,
            $serverRequest,
            $rawRouteConfig,
            $routeConfig,
            $response
        );
    }





    /**
     * Gera uma string que representa a resposta a ser enviada
     * para o UA, compatível com o mimetype que esta classe está
     * apta a manipular.
     * 
     * @return      string
     */
    public function createResponseBody() : string
    {
        $this->setDocumentMetaData();

		$viewData = $this->response->getViewData();
        $dataTable = (isset($viewData->dataTable) ? $viewData->dataTable : []);
		$finalArray = $this->prepareArrayToCreateSpreadSheet($dataTable);

		return $this->createXLSXBody($finalArray);
    }







    private $usedStrings = [];
    private $usedStringsPositions = [];
    /**
     * A partir do array que representa a planilha a ser criada,
     * gera uma string compatível com o formato XLS.
	 * 
	 * Baseado no original:
	 * https://gist.github.com/kasparsd/ade34dd94a80b97fb9ec59391a0c620f
     *
     * @param       array $dataTable
     *              Array de arrays contendo cada uma das linhas de
     *              dados a ser usado na planilha.
     * 
     * @return      string
     */
    private function createXLSXBody(array $dataTable) : string
    {
        $str = "";
		$msgError = null;

		
		if (class_exists("ZipArchive", false) === false) {
			$msgError = "This PHP instalation does not support creating ZIP files. It is required for creating XLSX files.";
		} 
		else {
			$tempFileName   = tempnam(sys_get_temp_dir(), "engarde-framework-xlsx");
			$tempZip        = new \ZipArchive();
			$isCreated      = $tempZip->open($tempFileName, \ZipArchive::CREATE);

			
			if ($isCreated === false) {
				$msgError = "Failed to create XLSX file [err 01].";
			} 
			else {
				$tempZip->addEmptyDir(		"docProps");
				$tempZip->addFromString(	"docProps/app.xml", 			$this->retrieveXLSXDocPart("Properties"));
				$tempZip->addFromString(	"docProps/core.xml", 			$this->retrieveXLSXDocPart("cp:coreProperties"));
				$tempZip->addEmptyDir(		"_rels");
				$tempZip->addFromString(	"_rels/.rels", 					$this->retrieveXLSXDocPart("Relationships1"));
				$tempZip->addEmptyDir(		"xl/worksheets");
				$tempZip->addFromString(	"xl/worksheets/sheet1.xml", 	$this->retrieveSheetXML($dataTable));
				$tempZip->addFromString(	"xl/workbook.xml", 				$this->retrieveXLSXDocPart("workbook"));
				$tempZip->addFromString(	"xl/sharedStrings.xml", 		$this->retrieveXLSXDocPart("sst"));
				$tempZip->addEmptyDir(		"xl/_rels");
				$tempZip->addFromString(	"xl/_rels/workbook.xml.rels", 	$this->retrieveXLSXDocPart("Relationships2"));
				$tempZip->addFromString(	"[Content_Types].xml", 			$this->retrieveXLSXDocPart("Types"));
				$tempZip->close();


				$stream = fopen($tempFileName, "r");
				if ($stream === false) {
					$msgError = "Impossible to get XLSX stream.";
				} 
				else {
					while (feof($stream) === false) {
						$str .= fread($stream, 2);
					}
					fclose($stream);
				}
			}
		}
        

        // Havendo algum erro, mostra a falha.
        if ($msgError !== null) {
            throw new \Exception($msgError);
		}
		

        return $str;        
    }





	/**
     * Retorna documentos XML que devem ser incorporados 
     * no corpo do ZIP que compõe o documento XLSX final.
     *
     * @param       string $partName
     *              Nome da parte que está sendo requisitada.
     * 
     * @return      string
     */
    private function retrieveXLSXDocPart(string $partName) : string 
    {
        $str = "";

        switch ($partName) {
            case "Properties":
                $str = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                    <Properties xmlns="http://schemas.openxmlformats.org/officeDocument/2006/extended-properties" xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">
                        <Application>Microsoft Excel</Application>
                    </Properties>';
                break;
            
            case "cp:coreProperties":
		        $str = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                    <cp:coreProperties xmlns:cp="http://schemas.openxmlformats.org/package/2006/metadata/core-properties" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:dcterms="http://purl.org/dc/terms/" xmlns:dcmitype="http://purl.org/dc/dcmitype/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                        <dcterms:created xsi:type="dcterms:W3CDTF">' . $this->createdDate->format("Y-m-d\TH:i:s.00\Z") . '</dcterms:created>
                        <dc:creator>' . $this->companyName . " | " . $this->authorName . '</dc:creator>
                        <dc:description>' . $this->description . '</dc:description>
                    </cp:coreProperties>';
                break;

            case "Relationships1":
		        $str = '<?xml version="1.0" encoding="UTF-8"?>
                    <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
                        <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
                        <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/package/2006/relationships/metadata/core-properties" Target="docProps/core.xml"/>
                        <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/extended-properties" Target="docProps/app.xml"/>
                    </Relationships>';
                break;

            case "workbook":
                $str = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                    <workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
                    <sheets>
                        <sheet name="Sheet1" sheetId="1" r:id="rId1" />
                    </sheets>
                    </workbook>';
                break;
            
            case "Relationships2":
                $str = '<?xml version="1.0" encoding="UTF-8"?>
                    <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
                        <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
                        <Relationship Id="rId4" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>
                    </Relationships>';
                break;

            case "Types":
                $str = '<?xml version="1.0" encoding="UTF-8"?>
                    <Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
                        <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
                        <Default Extension="xml" ContentType="application/xml"/>
                        <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
                        <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
                        <Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
                        <Override PartName="/docProps/core.xml" ContentType="application/vnd.openxmlformats-package.core-properties+xml"/>
                        <Override PartName="/docProps/app.xml" ContentType="application/vnd.openxmlformats-officedocument.extended-properties+xml"/>
                    </Types>';
				break;
				
			case "sst":
				$usedStrings = [];
				
				foreach ($this->usedStrings as $string => $string_count) {
					$usedStrings[] = sprintf(
						'<si><t>%s</t></si>',
						filter_var($string, FILTER_SANITIZE_SPECIAL_CHARS)
					);
				}

				$str = sprintf(
					'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
					<sst count="%d" uniqueCount="%d" xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">%s</sst>',
					array_sum($this->usedStrings),
					count($this->usedStrings),
					implode("\n", $usedStrings)
				);
				break;
        }

        return $str;
    }





	/**
     * Cria o XML que representa os dados da planilha que está
     * sendo incorporada no documento final.
     *
     * @param       array $dataTable
     *              Array de arrays contendo cada uma das linhas de
     *              dados a ser usado na planilha.
     * 
     * @return      string
     */
    private function retrieveSheetXML(array $dataTable) : string
    {
        $str = "";

		$xmlRows = [];
		$rowNumber = 0;
        foreach ($dataTable as $i => $rowData) 
        {
			$rowNumber++;
			$xmlCells = [];
            foreach ($rowData as $columnNumber => $value) 
            {
				$celName 		= $this->generateCellName($rowNumber, $columnNumber);
                $valueType 		= (is_numeric($value) ? "n" : "s");
				$valuePosition 	= $this->setUsedStringsAndRetrieveItPosition($value);
				
				$xmlCells[] = sprintf(
					'<c r="%s" t="%s"><v>%d</v></c>',
					$celName,
					$valueType,
					$valuePosition
				);
            }

			$xmlRows[] = sprintf(
				'<row r="%s">%s</row>',
				$rowNumber,
				implode( "\n", $xmlCells)
			);
		}

		$str = sprintf(
			'<?xml version="1.0" encoding="utf-8" standalone="yes"?>
			<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
				<sheetData>%s</sheetData>
			</worksheet>',
			implode("\n", $xmlRows)
		);

        return $str;
    }





    /**
     * Registra o uso de cada uma das strings usadas no XLSX na variável
     * "$this->usedStrings" relacionando à ela a quantidade de vezes que a 
     * mesma é usada na planilha.
     * Registra também na variável "$this->usedStringsPositions" cada uma das
     * strings relacionadas à seus índices de acesso em "$this->usedStrings".
     * 
     * Ao final, retorna a posição da string que foi atualmente definida ou
     * cula contagem foi incrementada.
     *
     * @param       string $value
     *              String que está sendo usada no documento.
     * 
     * @return      int
     */
    private function setUsedStringsAndRetrieveItPosition(string $value) : int
    {
		if (isset($this->usedStrings[$value]) === true) {
            // Incrementa contagem de uso da string
			$this->usedStrings[$value]++;
		} else {
            // Inicia a contagem de uso da string
			$this->usedStrings[$value] = 1;
        }
        
		if (isset($usedStringsPositions[$value]) === false) {
			$usedStringsPositions[$value] = array_search($value, array_keys($this->usedStrings));
        }
        
		return $usedStringsPositions[$value];
    }
    /**
	 * Gera um nome para ser usado por uma célula em uma planilha XLSX.
	 * Este nome é também a posição da célula na planilha (A1, B4, AB22 ...).
	 *
	 * @param 		int $rowNumber
	 * 				Número da linha.
	 * 
	 * @param 		int $columnNumber
	 * 				Número da coluna.
	 * 
	 * @return 		string
	 */
    private function generateCellName(int $rowNumber, int $columnNumber) : string
    {
        $str = "";
		$n = $columnNumber;
        for ($str = ""; $n >= 0; $n = intval($n / 26) - 1) {
			$str = chr(($n % 26) + 0x41) . $str;
		}
		return $str . $rowNumber;
	}
}
