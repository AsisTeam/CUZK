# Application

To be used for searching of property owners.

You must have your dedicated CUZK credentials `username` and `password` in order to access the API.
When using the API you are charged for performed requests.

## Content

- [KN- list vlastnictví](#listVlastnictvi)

Integrations:
- [Nette](#Nette)

---

## listVlastnictvi

This API provides information about land parcels and their ownerships.
The API is asynchronous. It means that at first you must generate the request for the `report` document.
This request is then being processed by CUZK servers. After some while, you may check if the `report` is ready by doing getReport call.
When the 'report' is ready, there is non-empty content of the `src/Entity/Report.php` entity.

Once the generateXYZ is called, the simple `report` object is returned.
Only few of `report` object properties are filled with data, but `ID` is always filled.
You may then use this `ID` for querying this specific report and it's content once generated. 

### Available API calls:
- getReports(): []Report
- getReport(int $id): Report
- deleteReport(int $id): void


- generateByLvId(string $lvId, $format = Report::FORMAT_XML, '?DateTime $date = null, bool $appendXml = false): Report[]
- generateByCodeAndLvNo(string $codeKU, string $lvNo, $format = Report::FORMAT_XML, ?DateTime $date = null, bool $appendXml = false): Report[]
- generateByCodeAndOsId(string $codeKU, string $osId, $format = Report::FORMAT_XML, ?DateTime $date = null, bool $appendXml = false): Report[]

___

Param Notes:
- __lvId__: ID LV, které se má vygenerovat
- __codeKU__: Kód k.ú. (šestimístný)
- __lvNo__: Číslo listu vlastnictví
- __osId__: ID oprávněného subjektu (nebo master tohoto OS)
- __date__: Datum, ke kterému bude sestava vygenerována.
- __appendXml__: V případě, že formát je PDF, operace vrátí současně sestavu i v XML formátu bez dalšího poplatku.

___

Format Notes:

You may choose among multiple output file types when generating the report. 
The default format is `Report::FORMAT_XML`.
If you require the PDF, use Report::FORMAT_PDF instead. When generating report in PDF the `$appendXml` param may be used (when using other formats `$appendXml` is ignored).
When `$appendXml` is used it the free of charge XML report is added to PDF report you are charged for. 

### List Vlastnictvi entity

If you requested to generate the `xml` version of LV. You may pass the received content to `ListVlastnictvi` entity.
It validates the received `xml` data structure and wraps the content by methods you may use to read the file.

### Usage

```php
use AsisTeam\CUZK\Client\LVClientFactory;
use AsisTeam\CUZK\Entity\ListVlastnictvi;

// 'WSTEST' and 'WSHESLO' are trial credentials
$client = (new CiselnikClientFactory('WSTEST', 'WSHESLO', true)->create();

// generates just XML version
$reportRequests = $client->generateByLvId('807841306')
// $reportRequests[0] contains XML file info

// generates both the PDF and XML versions
$reportRequests = $client->generateByLvId('807841306', Report::FORMAT_PDF, null, true)
// report request should contain 2 items 
// $reportRequests[0] contains PDF file info
// $reportRequests[1] contains XML file info
 
// wait some time for CUZK server to generate the reports
sleep(10);

// save the pdf file
$reportPdf = $client->getReport($reportRequests[0]->getId());
echo 'The charged price for generating the reports was: ' . $reportPdf->getPrice();
file_put_contents($reportPdf->getId().'.pdf', $reportPdf->getContent());

// read the xml
$xml = $client->getXmlReport($reportRequests);
$reportXml = $client->getReport($xml->getId);
$lv = ListVlastnictvi($reportXml->getContent());
echo 'Vytvoreno:' . $lv->vytvoreno();
foreach ($i => $lv->texty() as $txt) {
    echo 'strana ' . $i . "\n";
    echo  $txt->zahlavi->cisloLv();
    //
    // ...
    //
}
```

Please see the `SestavyCLient` unit/integration test for more examples of client usage.

## Nette

You can setup package as Nette compiler extension using neon config
Extension will create all client factories as services

### Usage

```neon
extensions:
	cuzk: AsisTeam\CUZK\DI\CUZKExtension
	
cuzk:
	user: username
	pass: password
	test: true

```
