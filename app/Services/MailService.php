<?php
namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;

class MailService {
    private PHPMailer $mailer;

    public function __construct(PHPMailer $mailer) {
        $this->mailer = $mailer;
    }

    public function enviarConfirmacaoSolicitacao(array $dados, string $chaveAluno, $arquivoPdf = null): bool {
    try {
        $this->mailer->addAddress($dados['aluno_email'], $dados['aluno_nome']);
        $this->mailer->isHTML(true);
        $this->mailer->Subject = "Protocolo de Envio de Documentação de Estágio - {$dados['aluno_nome']}";
        if ($arquivoPdf && $arquivoPdf->getError() === UPLOAD_ERR_OK) {
            $conteudoBinario = $arquivoPdf->getStream()->getContents();
            $nomeArquivo = $arquivoPdf->getClientFilename();

            $this->mailer->addStringAttachment(
                $conteudoBinario,
                $nomeArquivo,
                'base64',
                'application/pdf'
            );
        }

        $this->mailer->Body = "<div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden;'>
            <div style='background-color: #09332a; color: white; padding: 20px; text-align: center;'>
                <h1 style='margin: 0;'>IFSP - Sistema de Gestão de Estágio</h1>
                <p style='margin: 5px 0 0;'>Protocolo de Solicitação de Estágio</p>
            </div>
            <div style='padding: 20px; color: #333;'>
                <p>Olá, <strong>{$dados['aluno_nome']}</strong>,</p>
                <p>Recebemos sua documentação de estágio. Abaixo estão os dados registrados:</p>
                
                <table style='width: 100%; border-collapse: collapse; margin: 20px 0;'>                    
                    <tr>
                        <td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Chave de Acesso:</strong></td>
                        <td style='padding: 8px; border-bottom: 1px solid #eee;'><code>{$chaveAluno}</code></td>
                    </tr>
                    <tr>
                        <td style='padding: 8px; border-bottom: 1px solid #eee;'><strong>Data:</strong></td>
                        <td style='padding: 8px; border-bottom: 1px solid #eee;'>" . date('d/m/Y H:i') . "</td>
                    </tr>
                </table>

                <div style='background-color: #f9f9f9; padding: 15px; border-left: 4px solid #b91c1c;'>
                    <p style='margin: 0; font-size: 14px;'><strong>Importante:</strong> O documento enviado segue em anexo a este e-mail para sua conferência.</p>
                </div>
                
                <p style='margin-top: 30px; font-size: 12px; color: #777; text-align: center;'>
                    Este é um e-mail automático, por favor não responda.
                </p>
            </div>
        </div>";
        
        return $this->mailer->send();
    } catch (\Exception $e) {
        error_log("Erro E-mail: " . $e->getMessage());
        return false;
    } finally {
        $this->mailer->clearAttachments();
        $this->mailer->clearAddresses();
    }
}

}