<?php

namespace App\Service;

use App\Exception\InvalidTokenException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class Google
{
    /**
     * @param $code
     * @param $clientId
     * @param $clientSecret
     * @param $redirectUrl
     * @return array
     * @throws InvalidTokenException
     */
    public function getToken($code, $clientId, $clientSecret, $redirectUrl): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://www.googleapis.com/oauth2/v4/token");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectUrl
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);

        return $this->handleResponse($body, $responseCode);
    }

    /**
     * @param string $response
     * @param int $responseCode
     * @throws InvalidTokenException
     * @throws RuntimeException
     * @return array
     */
    private function handleResponse(string $response, int $responseCode): array
    {
        if ($message = json_decode($response, true)) {
            if ($responseCode != Response::HTTP_OK) {
                throw new InvalidTokenException($message['error_description'], $responseCode);
            }

            if (empty($message['access_token']) || empty($message['refresh_token']) || empty($message['expires_in'])) {
                throw new RuntimeException('Щось пішло не так. Запит не повернув очікувані дані.');
            }

            return $message;
        } else {
            throw new RuntimeException('Непередбачувана помилка. ' . $response);
        }
    }
}