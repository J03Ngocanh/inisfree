<?php
require_once dirname(dirname(dirname(__FILE__))) . '/core/controller.php';

class chatController extends Controller
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = $this->model('productModel');
    }

    public function chat()
    {
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);
        $message = $data['message'] ?? '';
        $category = $data['category'] ?? '';

        // Get products by category
        $productResult = $this->productModel->getByCategory($category);

        $products = [];
        $i = 0;
        while ($row = $productResult->fetch_assoc()) {
            if ($i == 10) {
                break;
            }
            $products[] = "Name: {$row['name']}, Price: " . number_format($row['price'], 0, ',', '.') . " VND";
            $i++;
        }

        $productData = implode("\n", $products);

        $messages = [
            [
                'role' => 'system',
                'content' => "You are a cosmetics advisor. Here are the current products. Reply briefly and clearly:\n\n" . $productData . "\n\nAdvise the customer based on the list above."
            ],
            ['role' => 'user', 'content' => $message]
        ];

        $apiKey = $_ENV['GPT_KEY'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages,
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);

        $result = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($result, true);

        if (isset($response['error'])) {
            echo "Sorry, the system is overloaded. Please try again later.";
        }

        echo $response['choices'][0]['message']['content'];
    }

    public function categories()
    {
        $categories = $this->productModel->getCategories();
        $categories = [];

        while ($row = $categories->fetch_assoc()) {
            $categories[] = [
                'id' => $row['id'],
                'name' => $row['tendanhmuc']
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($categories);
    }
}