<?php


require_once __DIR__ . '/../../services/mpdf/vendor/autoload.php'; 

use Mpdf\Mpdf;
use Mpdf\MpdfException;

$template_checklist_path = BASE_PATH . 'templates/pdfs/checklist_tce.html';
if (!file_exists($template_checklist_path)) {
    die("Erro: Template do Checklist não encontrado em: " . $template_checklist_path);
}

$html_content = file_get_contents($template_checklist_path);

try {
    $mpdf = new Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_left' => 15,
        'margin_right' => 15,
        'margin_top' => 15,
        'margin_bottom' => 15,
    ]);
    
    $mpdf->SetHeader('IFSP - Câmpus Guarulhos | Checklist TCE');
    $mpdf->SetFooter('|Página {PAGENO}|');
    $mpdf->WriteHTML($html_content);
    $filename = 'Checklist_TCE_' . date('Ymd') . '.pdf';
    $mpdf->Output($filename, 'I');  // Mudar para D para forçar a impressao
    exit;
    
} catch (MpdfException $e) {
    die("Erro ao gerar PDF do Checklist: " . $e->getMessage());
}

?>