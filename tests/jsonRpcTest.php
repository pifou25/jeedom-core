<?php
// generic script to test jsonrpc Jeedom API
// JSON files are into /tests/jsonrpc

const JEEDOM_URL = 'http://localhost/core/api/jeeApi.php';
const JEEDOM_APIKEY = 'ESiXoiOj0BKXivES3f4zbCJw15xINgT50yWdkuoESbArH07y1sMgmndOqVvtexT4';
const JSONRPC_DIR = __DIR__ . '/jsonrpc';
$results = [];

echo "Test JSON RPC API Jeedom: " . JEEDOM_URL . "\n\n";
// browse directory
$files = scandir(JSONRPC_DIR);
foreach ($files as $file) {
	if (strpos($file, '.json') === false) {
		continue;
	}
	$json = file_get_contents(JSONRPC_DIR . '/' . $file);
    // replace apikey
    $json = str_replace('{{apikey}}', JEEDOM_APIKEY, $json);

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => JEEDOM_URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $json,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: text/plain'
    ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    echo "$file => $httpcode\n";
    $results[$file] = [
            'httpcode' => $httpcode,
            'response' => $response
        ];

}

$err = 0;
// lister les tests en erreur
foreach ($results as $file => $data) {
    if ($data['httpcode'] != 200) {
        echo "Test $file failed : ";
        echo "HTTP Code: " . $data['httpcode'] . "\n";
        echo "Response: " . $data['response'] . "\n";
        $err++;
    }
}

if ($err == 0) {
    echo "All tests passed\n";
} else {
    echo "$err tests failed\n";
    // exit with error code
    exit(1);
}
