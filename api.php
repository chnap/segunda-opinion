<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
ob_start();

error_reporting(0);
ini_set('display_errors', '0');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    ob_end_clean();
    http_response_code(200);
    exit;
}

try {
    $pdo = null;
    if (file_exists('conexion_db.php')) {
        try {
            require_once 'conexion_db.php';
        } catch (\Throwable $e) {}
    }

    if (!$pdo) {
        try {
            $host = 'localhost';
            $dbname = 'db_oncologia';
            $username = 'root';
            $password = '';
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (\Throwable $e) {}
    }

    if (file_exists('PHPMailer/src/Exception.php')) {
        require_once 'PHPMailer/src/Exception.php';
        require_once 'PHPMailer/src/PHPMailer.php';
        require_once 'PHPMailer/src/SMTP.php';
    }

    define('DEFAULT_DRICLOUD_URL', 'https://pagoseguro.dricloud.net/?URL=dricloud_juan_19849786&ConsultasOnline=true');

    define('SMTP_HOST', 'smtp.gmail.com');
    define('SMTP_USER', 'nachonon9@gmail.com');
    define('SMTP_PASS', 'vtsg ejhd msga feeu');
    define('SMTP_PORT', 587);
    define('SMTP_SECURE', PHPMailer::ENCRYPTION_STARTTLS);
    define('SMTP_FROM_EMAIL', 'nachonon9@gmail.com');
    define('SMTP_FROM_NAME', 'Consulta Dr. Juan De la Haba');

    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    if (!is_array($input)) $input = [];

    $action = strtolower(trim($_GET['action'] ?? $_POST['action'] ?? ($input['action'] ?? '')));

    if (empty($action)) {
        ob_end_clean();
        echo json_encode(['ok' => false, 'error' => 'No se ha proporcionado ninguna acción.']);
        exit;
    }

    function getCleanPatientName($name) {
        $trimmed = trim((string)$name);
        return !empty($trimmed) ? htmlspecialchars($trimmed, ENT_QUOTES, 'UTF-8') : 'paciente';
    }

    // Plantilla HTML unificada con soporte dinámico para Modo Claro y Modo Oscuro
    function getHtmlEmailTemplate($title, $bodyContent) {
        return '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</title>
            <style>
                body { background-color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; margin: 0; padding: 0; color: #1e293b; }
                .wrapper { width: 100%; table-layout: fixed; background-color: #f8fafc; padding: 40px 0; }
                .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #e2e8f0; }
                .header { background-color: #0b131f; padding: 24px; text-align: center; color: #d4af37; font-size: 20px; font-weight: bold; letter-spacing: 0.5px; }
                .content { padding: 32px; font-size: 16px; line-height: 1.6; color: #334155; }
                .button { display: inline-block; padding: 14px 28px; background-color: #d4af37; color: #0b131f !important; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 24px; text-align: center; }
                .footer { background-color: #f1f5f9; padding: 20px; text-align: center; font-size: 13px; color: #64748b; border-top: 1px solid #e2e8f0; }

                /* Soporte para Modo Oscuro en clientes de correo compatibles (Apple Mail, Outlook, etc.) */
                @media (prefers-color-scheme: dark) {
                    body, .wrapper { background-color: #070b12 !important; color: #f1f5f9 !important; }
                    .container { background-color: #0b131f !important; border-color: #1e293b !important; box-shadow: 0 4px 12px rgba(0,0,0,0.4) !important; }
                    .header { background-color: #0b131f !important; color: #fbbf24 !important; border-bottom: 1px solid #1e293b; }
                    .content { color: #cbd5e1 !important; }
                    .footer { background-color: #070b12 !important; color: #94a3b8 !important; border-top: 1px solid #1e293b !important; }
                    .button { background-color: #fbbf24 !important; color: #070b12 !important; }
                }
            </style>
        </head>
        <body>
            <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <table class="container" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="header">Dr. Juan De la Haba Rodríguez</td>
                            </tr>
                            <tr>
                                <td class="content">
                                    ' . $bodyContent . '
                                </td>
                            </tr>
                            <tr>
                                <td class="footer">
                                    &copy; ' . date('Y') . ' Consulta de Oncología Médica. Todos los derechos reservados.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>';
    }

    function sendReceivedEmail($toEmail, $patientName) {
        if (empty($toEmail) || !class_exists('PHPMailer\PHPMailer\PHPMailer')) return false;
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST; $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER; $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = SMTP_SECURE; $mail->Port = SMTP_PORT;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress($toEmail, $patientName);
            $mail->isHTML(true);
            $mail->Subject = 'Solicitud Recibida - Consulta Dr. Juan De la Haba';
            
            $cleanName = getCleanPatientName($patientName);
            $bodyHtml = "<p>Estimado/a <strong>{$cleanName}</strong>,</p>
                         <p>Hemos recibido correctamente su solicitud de valoración médica y la documentación aportada. Su caso se encuentra en proceso de revisión de triaje médico.</p>
                         <p>Nos pondremos en contacto con usted a la mayor brevedad posible para informarle sobre los siguientes pasos.</p>
                         <p style='margin-top: 30px;'>Atentamente,<br><strong>Dr. Juan De la Haba Rodríguez</strong></p>";

            $mail->Body = getHtmlEmailTemplate('Solicitud Recibida', $bodyHtml);
            $mail->send();
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    function sendFormEmail($toEmail, $patientName, $formUrl) {
        if (empty($toEmail) || !class_exists('PHPMailer\PHPMailer\PHPMailer')) return false;
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST; $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER; $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = SMTP_SECURE; $mail->Port = SMTP_PORT;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress($toEmail, $patientName);
            $mail->isHTML(true);
            $mail->Subject = 'Caso Aceptado - Formulario de Primera Consulta';
            
            $cleanName = getCleanPatientName($patientName);
            $cleanUrl = htmlspecialchars($formUrl, ENT_QUOTES, 'UTF-8');
            $bodyHtml = "<p>Estimado/a <strong>{$cleanName}</strong>,</p>
                         <p>Nos complace comunicarle que su caso ha sido <strong>aceptado</strong> tras la revisión médica inicial de triaje.</p>
                         <p>Para continuar con el proceso y formalizar su consulta, por favor acceda al formulario oficial y seguro a través del siguiente botón:</p>
                         <div style='text-align: center;'>
                             <a href='{$cleanUrl}' class='button' target='_blank'>Acceder al Formulario de Consulta</a>
                         </div>
                         <p style='margin-top: 30px; font-size: 14px; color: #64748b;'>Si el botón no funciona, copie y pegue este enlace en su navegador:<br><a href='{$cleanUrl}' style='color: #d4af37;'>{$cleanUrl}</a></p>
                         <p style='margin-top: 30px;'>Atentamente,<br><strong>Dr. Juan De la Haba Rodríguez</strong></p>";

            $mail->Body = getHtmlEmailTemplate('Caso Aceptado', $bodyHtml);
            $mail->send();
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    function sendRejectionEmail($toEmail, $patientName, $reason) {
        if (empty($toEmail) || !class_exists('PHPMailer\PHPMailer\PHPMailer')) return false;
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST; $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER; $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = SMTP_SECURE; $mail->Port = SMTP_PORT;
            $mail->CharSet = 'UTF-8';
            $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
            $mail->addAddress($toEmail, $patientName);
            $mail->isHTML(true);
            $mail->Subject = 'Actualización sobre su solicitud de consulta';
            
            $cleanName = getCleanPatientName($patientName);
            $cleanReason = nl2br(htmlspecialchars($reason, ENT_QUOTES, 'UTF-8'));
            $bodyHtml = "<p>Estimado/a <strong>{$cleanName}</strong>,</p>
                         <p>Lamentamos informarle que tras la evaluación médica de su solicitud, no ha sido posible aceptar su caso en este momento por el siguiente motivo:</p>
                         <div style='background-color: rgba(212, 175, 55, 0.1); border-left: 4px solid #d4af37; padding: 15px; margin: 20px 0; border-radius: 4px;'>
                             {$cleanReason}
                         </div>
                         <p>Agradecemos la confianza depositada en nuestro equipo médico.</p>
                         <p style='margin-top: 30px;'>Atentamente,<br><strong>Dr. Juan De la Haba Rodríguez</strong></p>";

            $mail->Body = getHtmlEmailTemplate('Actualización de Solicitud', $bodyHtml);
            $mail->send();
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    function recordCaseEvent($pdo, $caseId, $eventType, $actor = null, $metadata = null) {
        if (empty($actor)) {
            $actor = $_SESSION['username'] ?? $_SESSION['user_email'] ?? 'Usuario del panel';
        }
        $event = [
            'type' => $eventType,
            'at' => date('Y-m-d H:i:s'),
            'actor' => $actor,
            'metadata' => is_array($metadata) ? implode(' · ', $metadata) : ($metadata ?? '')
        ];
        if (!$pdo || empty($caseId)) return $event;
        try {
            $stmt = $pdo->prepare("INSERT INTO case_events (case_id, event_type, actor, metadata) VALUES (?, ?, ?, ?)");
            $stmt->execute([$caseId, $eventType, $actor, $metadata ? json_encode($metadata, JSON_UNESCAPED_UNICODE) : null]);
        } catch (\Throwable $e) {
            try {
                $caseStmt = $pdo->prepare("SELECT case_data FROM cases WHERE id = ?");
                $caseStmt->execute([$caseId]);
                $caseRow = $caseStmt->fetch(PDO::FETCH_ASSOC);
                if ($caseRow) {
                    $caseData = json_decode($caseRow['case_data'] ?? '{}', true);
                    if (!is_array($caseData)) $caseData = [];
                    $events = is_array($caseData['events'] ?? null) ? $caseData['events'] : [];
                    $events[] = $event;
                    $caseData['events'] = $events;
                    $updateStmt = $pdo->prepare("UPDATE cases SET case_data = ?, updated_at = NOW() WHERE id = ?");
                    $updateStmt->execute([json_encode($caseData, JSON_UNESCAPED_UNICODE), $caseId]);
                }
            } catch (\Throwable $fallbackError) {}
        }
        return $event;
    }

    function normalizeCaseEvent($event) {
        if (!is_array($event)) return null;
        return [
            'type' => $event['type'] ?? $event['event_type'] ?? 'ACTIVITY',
            'at' => $event['at'] ?? $event['created_at'] ?? null,
            'actor' => $event['actor'] ?? '',
            'metadata' => is_array($event['metadata'] ?? null) ? implode(' · ', $event['metadata']) : ($event['metadata'] ?? '')
        ];
    }

    ob_clean();

    switch ($action) {
        case 'get_cases':
        case 'getcases':
            $cases = [];
            if ($pdo) {
                $eventsByCase = [];
                try {
                    $eventStmt = $pdo->query("SELECT case_id, event_type, actor, metadata, created_at FROM case_events ORDER BY created_at ASC, id ASC");
                    while ($event = $eventStmt->fetch(PDO::FETCH_ASSOC)) {
                        $eventsByCase[$event['case_id']][] = normalizeCaseEvent($event);
                    }
                } catch (\Throwable $e) {}
                $stmt = $pdo->query("SELECT * FROM cases ORDER BY updated_at DESC");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $caseEvents = [];
                    $caseData = json_decode($row['case_data'] ?? '', true);
                    if (!is_array($caseData)) $caseData = [];
                    $storedChecklist = is_array($caseData['checklist'] ?? null) ? $caseData['checklist'] : [];
                    $storedChecklistStatuses = [];
                    foreach ($storedChecklist as $item) {
                        if (!is_array($item) || empty($item['id'])) continue;
                        $status = $item['status'] ?? '';
                        $storedChecklistStatuses[$item['id']] = [
                            'PRESENT' => 'Aportado',
                            'MISSING' => 'Pendiente',
                            'NOT_REQUIRED' => 'No requerida'
                        ][$status] ?? $status;
                    }
                    if (!empty($caseData['events']) && is_array($caseData['events'])) {
                        foreach ($caseData['events'] as $event) {
                            $normalized = normalizeCaseEvent($event);
                            if ($normalized) $caseEvents[] = $normalized;
                        }
                    }
                    foreach ($eventsByCase[$row['id']] ?? [] as $event) $caseEvents[] = $event;
                    if (empty($caseEvents) && !empty($row['created_at'])) {
                        $caseEvents[] = ['type' => 'NEW_REQUEST', 'at' => $row['created_at'], 'actor' => 'Paciente (Web Pública)', 'metadata' => ''];
                    }
                    usort($caseEvents, static function ($a, $b) { return strcmp((string)($a['at'] ?? ''), (string)($b['at'] ?? '')); });
                    $cases[] = [
                        "id" => $row['id'],
                        "priority" => $row['priority'] ?? 'NORMAL',
                        "patient" => $row['patient_name'],
                        "subtext" => ($row['email'] ?? '') . ' • ' . ($row['phone'] ?? ''),
                        "status" => $row['status'],
                        "pathology" => $row['diagnosis'],
                        "patientQuestion" => $row['clinical_question'],
                        "updatedAt" => $row['updated_at'],
                        "createdAt" => $row['created_at'] ?? null,
                        "rejectionReason" => $row['rejection_reason'] ?? ($caseData['rejectionReason'] ?? ''),
                        "events" => $caseEvents,
                        "checklist" => [
                            ['id' => 'medical_report', 'name' => 'Diagnóstico', 'status' => $storedChecklistStatuses['medical_report'] ?? 'Aportado'],
                            ['id' => 'pathology', 'name' => 'Anatomía patológica', 'status' => $storedChecklistStatuses['pathology'] ?? 'Pendiente'],
                            ['id' => 'imaging', 'name' => 'Pruebas de imagen', 'status' => $storedChecklistStatuses['imaging'] ?? 'Pendiente'],
                            ['id' => 'treatments', 'name' => 'Tratamientos previos', 'status' => $storedChecklistStatuses['treatments'] ?? 'Pendiente'],
                            ['id' => 'labs', 'name' => 'Analítica reciente', 'status' => $storedChecklistStatuses['labs'] ?? 'Pendiente'],
                            ['id' => 'patient_question', 'name' => 'Pregunta del paciente', 'status' => $storedChecklistStatuses['patient_question'] ?? 'Aportado']
                        ]
                    ];
                }
            }
            echo json_encode(['ok' => true, 'cases' => $cases]);
            break;

        case 'submit_case':
        case 'submit_request':
        case 'create_case':
            $fullName = !empty($input['fullName']) ? trim($input['fullName']) : (!empty($input['patient_name']) ? trim($input['patient_name']) : (!empty($input['name']) ? trim($input['name']) : 'Paciente Nuevo'));
            $email = $input['email'] ?? '';
            $phone = $input['phone'] ?? '';
            $diagnosis = $input['diagnosis'] ?? 'Pendiente de diagnóstico';
            $question = $input['question'] ?? ($input['clinical_question'] ?? 'Primera consulta');
            $caseId = 'ONC-' . rand(8100, 8999);
            $updatedAt = date('Y-m-d H:i:s');
            $caseDataJson = !empty($rawInput) ? $rawInput : '{}';

            if (!$pdo) {
                throw new \Exception("No hay conexión con la base de datos.");
            }

            $stmt = $pdo->prepare("INSERT INTO cases (id, patient_name, email, phone, status, diagnosis, clinical_question, case_data, priority, updated_at) VALUES (?, ?, ?, ?, 'NEW_REQUEST', ?, ?, ?, 'ALTA', ?)");
            $stmt->execute([$caseId, $fullName, $email, $phone, $diagnosis, $question, $caseDataJson, $updatedAt]);
            recordCaseEvent($pdo, $caseId, 'NEW_REQUEST', 'Paciente (Web Pública)');

            if (!empty($email)) {
                @sendReceivedEmail($email, $fullName);
            }
            
            $newCase = [
                "id" => $caseId,
                "priority" => "ALTA",
                "patient" => $fullName,
                "subtext" => $email . ' • ' . $phone,
                "status" => "NEW_REQUEST",
                "pathology" => $diagnosis,
                "patientQuestion" => $question,
                "updatedAt" => $updatedAt
            ];
            echo json_encode(['ok' => true, 'caseId' => $caseId, 'id' => $caseId, 'case' => $newCase]);
            break;

        case 'accept_case':
            $caseId = $input['caseId'] ?? '';
            $event = null;
            if ($pdo && !empty($caseId)) {
                $stmt = $pdo->prepare("UPDATE cases SET status = 'ACCEPTED', updated_at = NOW() WHERE id = ?");
                $stmt->execute([$caseId]);
                $event = recordCaseEvent($pdo, $caseId, 'ACCEPTED');

                $stmtEmail = $pdo->prepare("SELECT patient_name, email FROM cases WHERE id = ?");
                $stmtEmail->execute([$caseId]);
                $patient = $stmtEmail->fetch(PDO::FETCH_ASSOC);
                if ($patient && !empty($patient['email'])) {
                    @sendFormEmail($patient['email'], $patient['patient_name'], DEFAULT_DRICLOUD_URL);
                }
            }
            echo json_encode(['ok' => true, 'success' => true]);
            break;

        case 'reject_case':
            $caseId = $input['caseId'] ?? '';
            $reason = $input['reason'] ?? 'No especificado';
            $event = null;
            if ($pdo && !empty($caseId)) {
                $stmt = $pdo->prepare("SELECT case_data FROM cases WHERE id = ?");
                $stmt->execute([$caseId]);
                $caseRow = $stmt->fetch(PDO::FETCH_ASSOC);
                $caseData = json_decode($caseRow['case_data'] ?? '{}', true);
                if (!is_array($caseData)) $caseData = [];
                $caseData['rejectionReason'] = $reason;
                $stmt = $pdo->prepare("UPDATE cases SET status = 'REJECTED', case_data = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([json_encode($caseData, JSON_UNESCAPED_UNICODE), $caseId]);
                $event = recordCaseEvent($pdo, $caseId, 'REJECTED', null, ['Motivo' => $reason]);

                $stmtEmail = $pdo->prepare("SELECT patient_name, email FROM cases WHERE id = ?");
                $stmtEmail->execute([$caseId]);
                $patient = $stmtEmail->fetch(PDO::FETCH_ASSOC);
                if ($patient && !empty($patient['email'])) {
                    @sendRejectionEmail($patient['email'], $patient['patient_name'], $reason);
                }
            }
            echo json_encode(['ok' => true, 'success' => true]);
            break;

        case 'update_checklist':
            $caseId = $input['caseId'] ?? '';
            $checklist = is_array($input['checklist'] ?? null) ? $input['checklist'] : [];
            if ($pdo && !empty($caseId)) {
                $caseStmt = $pdo->prepare("SELECT case_data FROM cases WHERE id = ?");
                $caseStmt->execute([$caseId]);
                $caseRow = $caseStmt->fetch(PDO::FETCH_ASSOC);
                if ($caseRow) {
                    $caseData = json_decode($caseRow['case_data'] ?? '{}', true);
                    if (!is_array($caseData)) $caseData = [];
                    $caseData['checklist'] = $checklist;
                    $stmt = $pdo->prepare("UPDATE cases SET case_data = ?, updated_at = NOW() WHERE id = ?");
                    $stmt->execute([json_encode($caseData, JSON_UNESCAPED_UNICODE), $caseId]);
                    recordCaseEvent($pdo, $caseId, 'DOCUMENTATION_UPDATED');
                }
            }
            echo json_encode(['ok' => true, 'success' => true]);
            break;

        case 'resend_email':
            $caseId = $input['caseId'] ?? '';
            if ($pdo && !empty($caseId)) {
                $stmtEmail = $pdo->prepare("SELECT patient_name, email FROM cases WHERE id = ?");
                $stmtEmail->execute([$caseId]);
                $patient = $stmtEmail->fetch(PDO::FETCH_ASSOC);
                if ($patient && !empty($patient['email'])) {
                    @sendFormEmail($patient['email'], $patient['patient_name'], DEFAULT_DRICLOUD_URL);
                }
            }
            echo json_encode(['ok' => true, 'success' => true]);
            break;

        case 'reset_demo':
            if ($pdo) {
                $pdo->exec("DELETE FROM cases");
                $pdo->exec("INSERT INTO `cases` (`id`, `patient_name`, `email`, `phone`, `status`, `diagnosis`, `clinical_question`, `case_data`, `priority`, `updated_at`) VALUES
                ('ONC-8101', 'María Dolores Sánchez', 'm.dolores.sanchez@example.com', '+34 622 33 44 55', 'NEW_REQUEST', 'Melanoma cutáneo maligno lentiginoso acral', 'Consulta sobre opciones de tratamiento', '{}', 'NORMAL', NOW()),
                ('ONC-8102', 'Javier Fernández Ortiz', 'j.fernandez@example.com', '+34 633 44 55 66', 'NEW_REQUEST', 'Carcinoma basocelular nodular infiltrante', 'Valoración de lesión cutánea', '{}', 'NORMAL', NOW()),
                ('ONC-8103', 'Antonio Gómez Ruiz', 'antonio.gomez@example.com', '+34 611 22 33 44', 'ACCEPTED', 'Adenocarcinoma de pulmón estadificación T2N1...', 'Segunda opinión sobre quimioterapia', '{}', 'NORMAL', NOW()),
                ('ONC-8104', 'Carmen Martínez López', 'carmen.martinez@example.com', '+34 600 11 22 33', 'NEW_REQUEST', 'Carcinoma ductal infiltrante de mama estadio IIA', 'Dudas sobre protocolo quirúrgico', '{}', 'NORMAL', NOW())");
            }
            echo json_encode(['ok' => true, 'success' => true]);
            break;

        default:
            echo json_encode(['ok' => true]);
            break;
    }

    ob_end_flush();

} catch (\Throwable $e) {
    if (ob_get_length()) ob_end_clean();
    http_response_code(200);
    echo json_encode([
        'ok' => false, 
        'error' => $e->getMessage()
    ]);
}
?>
