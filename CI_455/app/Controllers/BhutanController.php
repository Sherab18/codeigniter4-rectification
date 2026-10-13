<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;

class BhutanController extends Controller
{
    use ResponseTrait;

    private string $baseUrl;
    private string $apiKey;
    private string $username;
    private string $password;

    public function __construct()
    {
        // Load configurations securely from environment variables (.env)
        $this->baseUrl  = getenv('WBES_BASE_URL') ?: 'https://gateway.grid-india.in/POSOCO/';
        $this->apiKey   = getenv('WBES_API_KEY') ?: '';
        $this->username = getenv('WBES_USERNAME') ?: '';
        $this->password = getenv('WBES_PASSWORD') ?: '';
    }

    public function dashboard()
    {
        $data = [
            'title'        => 'Bhutan Power Utilities Dashboard',
            'utilities'    => $this->getBhutanUtilityList(),
            'api_base_url' => $this->baseUrl,
            'last_updated' => date('Y-m-d H:i:s')
        ];

        return view('bhutan_dashboard', $data);
    }

    public function getUtilityData()
    {
        $utility = $this->request->getGet('utility');
        $date    = $this->request->getGet('date') ?: date('Y-m-d');

        $apiResult = $this->getUtilityApiData($utility, $date);

        if (!$apiResult['success']) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $apiResult['error_message'] ?? 'Failed to retrieve schedule data.'
            ]);
        }

        $responseData = $apiResult['response']['ResponseBody'] ?? null;

        return $this->response->setJSON([
            'status'       => 'success',
            'utility'      => $utility,
            'utility_data' => [
                'transformed_data' => $responseData
            ]
        ]);
    }

    private function getUtilityApiData($utility, $date = null)
    {
        $date = $date ?: date('Y-m-d');

        // FIX (SonarQube php:S4790): Replaced weak md5 hash algorithm with secure sha256
        $cacheKey = "wbes_schedule_" . hash('sha256', ($utility ?? 'ALL') . '_' . $date);

        if ($cachedData = cache($cacheKey)) {
            return $cachedData;
        }

        $dtObj = \DateTime::createFromFormat('Y-m-d', $date);
        $payloadDate = ($dtObj !== false) ? $dtObj->format('d-m-Y') : date('d-m-Y');

        $requestData = [
            "Date"            => $payloadDate,
            "SchdRevNo"       => -1,
            "UserName"        => $this->username,
            "UtilAcronymList" => $utility ? [$utility] : []
        ];

        $url = $this->baseUrl . 'reports/1.0/WebAccessAPI/GetUtilityExternalSharedData?apikey=' . urlencode($this->apiKey);
        $basicAuth = base64_encode($this->username . ':' . $this->password);

        $headers = [
            'Content-Type: application/json',
            'X-API-Key: ' . $this->apiKey,
            'Authorization: Basic ' . $basicAuth,
            'Accept: application/json',
            'Connection: close'
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($requestData),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_CONNECTTIMEOUT => 15,

            // Enforce secure SSL verification
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSLVERSION     => CURL_SSLVERSION_TLSv1_2,

            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) CodeIgniter-App',

            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_FORBID_REUSE   => true
        ]);

        $respBody   = curl_exec($ch);
        $curlErrNo  = curl_errno($ch);
        $curlError  = curl_error($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($curlErrNo !== 0 || $respBody === false) {
            log_message('error', "Grid-India cURL Error [Code {$curlErrNo}]: {$curlError}");

            return [
                'success'       => false,
                'status_code'   => 0,
                'error_message' => "Grid-India gateway connection error (cURL Error {$curlErrNo}). Please try again."
            ];
        }

        $data = json_decode($respBody, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            log_message('error', 'WBES JSON decode error: ' . json_last_error_msg());
            return [
                'success'       => false,
                'status_code'   => $statusCode,
                'error_message' => 'Invalid JSON structure received from Grid-India server.'
            ];
        }

        $statusObj = $data['Status'] ?? ($data['ResponseStatus'] ?? null);

        $statusCodeFromPayload = null;
        $statusMsgFromPayload  = null;

        if (is_array($statusObj)) {
            $statusCodeFromPayload = $statusObj['Code'] ?? null;
            $statusMsgFromPayload  = $statusObj['Message'] ?? null;
        }

        $hasResponseBody = isset($data['ResponseBody']) && !empty($data['ResponseBody']);
        $isPayloadOk     = ($statusCodeFromPayload == 200 || $statusCodeFromPayload === 0 || $statusCodeFromPayload === null || $hasResponseBody);

        $isSuccess = ($statusCode === 200) && $isPayloadOk;

        $result = [
            'success'       => $isSuccess,
            'status_code'   => $statusCode,
            'response'      => $data,
            'error_message' => !$isSuccess ? ($statusMsgFromPayload ?? 'API Error: Invalid status payload received.') : null
        ];

        if ($isSuccess) {
            cache()->save($cacheKey, $result, 180);
        }

        return $result;
    }

    private function getBhutanUtilityList()
    {
        return [
            "Bhutan_State"    => "Bhutan State (Net)",
            "CHUKHA"          => "Chukha Hydro Power Plant",
            "TALA"            => "Tala Hydro Power Plant",
            "MANGDECHU"       => "Mangdechhu Hydro Power Plant",
            "KURICHU"         => "Kurichhu Hydro Power Plant",
            "NVVN_Basochhu"   => "NVVN Basochhu Power Plant",
            "TPTCL_DHPPB"     => "TPTCL Dagachhu Power Plant",
            "Nikacchu_Bhutan" => "Nikachhu Hydro Power Plant"
        ];
    }

    public function debugUtility($utility)
    {
        $rawData = $this->getUtilityApiData($utility);
        return $this->respond($rawData);
    }
}