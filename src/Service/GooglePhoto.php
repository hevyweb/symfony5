<?php

namespace App\Service;

class GooglePhoto {
    const PAGE_SIZE = 100;

    public function getPhotoList($pageToken)
    {
        $this->buildRequest($pageToken);
    }

    private function buildRequest(?string $pageToken)
    {
        $ch = curl_init();
        $parameters = http_build_query([
            'pageSize' => self::PAGE_SIZE,
            'pageToken' => $pageToken ?? null
        ]);
        curl_setopt($ch, CURLOPT_URL, "https://photoslibrary.googleapis.com/v1/mediaItems?" . $parameters);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    }
}