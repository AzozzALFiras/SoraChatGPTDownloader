<?php

class SoraChatGPTClass
{
    private $apiUrl = 'https://sora.chatgpt.com/backend/public/generations/';
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Extracts the Sora ID from the provided URL.
     *
     * @return string The Sora ID extracted from the URL.
     */
    public function getSoraIdFromUrl()
    {
        $urlParts = explode('/', $this->url);
        return end($urlParts);
    }

    /**
     * Fetches data from the Sora API using the extracted Sora ID.
     *
     * @return array|false The decoded JSON response or false on failure.
     */
    public function getData()
    {
        $soraId = $this->getSoraIdFromUrl();
        $endpoint = $this->apiUrl . $soraId;

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; SoraChatGPT/1.0)',
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => true
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch) || $httpCode !== 200) {
            curl_close($ch);
            return false;
        }

        curl_close($ch);

        $data = json_decode($response, true);
        return $data !== null ? $data : false;
    }

    /**
     * Get video download URL for specified quality.
     *
     * @param string $quality Quality level (source, md, ld)
     * @return string|false Video URL or false if not found.
     */
    public function getVideoUrl($quality = 'source')
    {
        $data = $this->getData();

        if (!$data || !isset($data['encodings'][$quality]['path'])) {
            return false;
        }

        return $data['encodings'][$quality]['path'];
    }

    /**
     * Get video metadata.
     *
     * @return array|false Video metadata or false on failure.
     */
    public function getVideoInfo()
    {
        $data = $this->getData();

        if (!$data) {
            return false;
        }

        return [
            'id' => $data['id'] ?? null,
            'url' => $data['url'] ?? 'not found'
            'title' => $data['title'] ?? 'Untitled',
            'width' => $data['width'] ?? null,
            'height' => $data['height'] ?? null,
            'duration' => $data['encodings']['source']['duration_secs'] ?? null,
            'created_at' => $data['created_at'] ?? null,
            'available_qualities' => array_keys($data['encodings'] ?? [])
        ];
    }
}
