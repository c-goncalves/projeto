<?php

class PdfController {

    public function generate($documento)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            http_response_code(400);
            echo json_encode([
                'status' => 'error',
                'message' => 'Missing or invalid JSON payload'
            ]);
            return;
        }

        switch ($documento) {
            case "termo":
                $script = "pages/solicitacoes/forms/pdf/gerar_termo_estagio.php";
                break;

            case "plano":
                $script = "pages/solicitacoes/forms/pdf/gerar_plano_atv.php";
                break;

            case "relatorio":
                $script = "pages/solicitacoes/forms/pdf/gerar_relatorio_semestral.php";
                break;

            case "aditivo-obrig":
                $script = "pages/solicitacoes/forms/pdf/gerar_termo_aditivo_obrig.php";
                break;

            case "aditivo-n-obrig":
                $script = "pages/solicitacoes/forms/pdf/gerar_termo_aditivo_n_obrig copy.php";
                break;

            default:
                http_response_code(404);
                echo json_encode(["error" => "Documento inválido"]);
                exit;
        }

        $GLOBALS['formData'] = $data; // manda pros templates

        require $script; // script de PDF
    }
}
