<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/controller.php';

class homeController extends Controller
{
    private $homeModel;

    public function __construct()
    {
        $this->homeModel = $this->model('homeModel');
    }
    public function chatbot()
    {
        header('Content-Type: text/plain');

        $message = $_POST['message'] ?? '';
        if (empty($message)) {
            echo "Hỏi gì đi nha, mình đợi bạn á!";
            exit;
        }

        try {
            // Path to JSON Service Account file
            $credentialsFile = dirname(dirname(dirname(__FILE__))) . '/beauty-wbee-3c0c842e188f.json';

            if (!file_exists($credentialsFile)) {
                echo "Error: JSON file not found at: " . $credentialsFile;
                exit;
            }

            $client = new Google_Client();
            $client->setAuthConfig($credentialsFile);
            $client->addScope('https://www.googleapis.com/auth/cloud-platform');
            $client->addScope('https://www.googleapis.com/auth/dialogflow');

            $accessTokenResult = $client->fetchAccessTokenWithAssertion();
            if (isset($accessTokenResult['access_token'])) {
                $accessToken = $accessTokenResult['access_token'];
            } else {
                echo "Error: Could not get Access Token. Details: " . json_encode($accessTokenResult);
                exit;
            }

            $projectId = 'beauty-wbee';
            $url = "https://dialogflow.googleapis.com/v2/projects/{$projectId}/agent/sessions/123456789:detectIntent";

            $data = [
                'queryInput' => [
                    'text' => [
                        'text' => $message,
                        'languageCode' => 'vi'
                    ]
                ]
            ];

            $options = [
                'http' => [
                    'header'  => "Content-Type: application/json\r\n" .
                        "Authorization: Bearer $accessToken\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data),
                ]
            ];

            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);

            if ($response === false) {
                $error = error_get_last();
                echo "Error: " . $error['message'];
                exit;
            }

            $result = json_decode($response, true);
            $reply = $result['queryResult']['fulfillmentText'] ?? "Mình chưa hiểu lắm, bạn hỏi lại nha!";
            echo $reply;

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }
    public function home()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $productTypes = $this->homeModel->getProductTypes();
        $bestSellers = $this->homeModel->getBestSellers();
        $newItems = $this->homeModel->getNewItems();
        $rank_up = $_SESSION['rank_up'] ?? null;
        unset($_SESSION['rank_up']);

        $info = null;
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $info = $this->homeModel->info($customerId);
        }

        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('home/home', ['bestSellers' => $bestSellers, 'newItems' => $newItems, 'rank_up' => $rank_up]);
        $this->view('footer');
    }


    public function profile()
    {
        $history = null;
        $info = null;
        $info1 = null;
        if (isset($_SESSION['customer_id'])) {
            $customerId = $_SESSION['customer_id'];
            $history = $this->homeModel->getOrderHistory($customerId);
            $info = $this->homeModel->info($customerId);
            $info1 = $this->homeModel->info($customerId);
        }
        $productTypes = $this->homeModel->getProductTypes();
        $this->view('menu', ['productTypes' => $productTypes, 'info' => $info]);
        $this->view('profile/profile', ['info1' => $info1, 'history' => $history]);
    }

}

?>
