import random
import requests

# 1. Redirige la petición al controlador que procesa la base de datos
ENDPOINT_URL = "http://localhost/onco-opinion/api.php"

diagnosticos = [
    "Carcinoma ductal infiltrante de mama estadio IIA",
    "Melanoma cutáneo maligno lentiginoso acral",
    "Adenocarcinoma de pulmón estadificación T2N1M0",
    "Carcinoma de próstata localizado de riesgo intermedio",
]

payload = {
    "action": "submit_request",  # Clave requerida por el backend PHP para procesar la orden
    "nombre": "Nacho Ortega",
    "consulta_para": "Mi mismo/a",
    "email": "iom01@lasallecordoba.es",
    "telefono": "689456123",
    "diagnostico": random.choice(diagnosticos),
    "motivo": "Solicitud de prueba automatizada.",
    "aspecto_valorar": "Valoración de tratamiento adyuvante.",
    "politica_privacidad": "on",
}

# 2. Envía la petición en formato JSON
response = requests.post(ENDPOINT_URL, json=payload)

print("Código de respuesta:", response.status_code)
print("--- Respuesta del servidor ---")
print(response.text[:500])