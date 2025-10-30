<?php

class ValidationController {

    public function validar()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!$input) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid JSON'
            ]);
            return;
        }

        // Validador externo (API do outro time)
        $url = "https://validator-squad-url.com/api/validar";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($input));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;
    }
}
