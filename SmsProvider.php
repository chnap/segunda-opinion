class SmsProvider {
    private string $authToken;

    public function __construct(string $authToken) {
        $this->authToken = $authToken;
    }

    /**
     * TODO / PLACEHOLDER: Integración pendiente de pasarela SMS oficial.
     */
    public function sendDriCloudAccessSms(string $phone, string $accessUrl): array {
        // Idempotencia y envío seguro sin incluir datos clínicos sensibles
        return [
            'success' => false,
            'error' => 'SMS Provider integration pending confirmation.',
            'message_id' => null
        ];
    }
}