<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class RecipeController extends BaseController
{
    private string $apiKey;
    private string $baseUrl = 'https://api.spoonacular.com';

    public function __construct()
    {
        $this->apiKey = env('SPOONACULAR_API_KEY', '');
    }

    // ─── FIND BY INGREDIENTS (Updated Method Name for Academic Report) ───
    public function findByIngredients(): ResponseInterface
    {
        $query        = $this->request->getGet('query') ?? '';
        $diet         = $this->request->getGet('diet') ?? '';
        $intolerances = $this->request->getGet('intolerances') ?? '';
        $offset       = (int) ($this->request->getGet('offset') ?? 0);

        $queryParams = [
            'offset'               => $offset,
            'number'               => 3,
            'addRecipeInformation' => 'true', 
            'apiKey'               => $this->apiKey,
        ];

        if ($query !== '') {
            // Smart Detection Logic
            if (str_contains($query, ',')) {
                $queryParams['includeIngredients'] = $query;
            } else {
                $queryParams['query'] = $query;
            }
        }
        
        if ($diet !== '') {
            $queryParams['diet'] = $diet;
        }
        if ($intolerances !== '') {
            $queryParams['intolerances'] = $intolerances;
        }

        $url = $this->baseUrl . '/recipes/complexSearch?' . http_build_query($queryParams);

        $result = $this->callApi($url);

        if ($result === null) {
            return $this->response->setStatusCode(502)->setJSON(['error' => 'Gagal menghubungi Spoonacular API.']);
        }

        return $this->response->setJSON($result);
    }

    // ─── RANDOM RECIPE ────────────────────────────────────────────
    public function random(): ResponseInterface
    {
        $url = $this->baseUrl . '/recipes/random?' . http_build_query([
            'number' => 3,
            'apiKey' => $this->apiKey,
        ]);

        $result = $this->callApi($url);

        if ($result === null) {
            return $this->response->setStatusCode(502)->setJSON(['error' => 'Gagal menghubungi Spoonacular API.']);
        }

        return $this->response->setJSON($result);
    }

    // ─── RECIPE DETAIL ───────────────────────────────────────────
    public function detail(int $id): ResponseInterface
    {
        $url = $this->baseUrl . "/recipes/{$id}/information?" . http_build_query([
            'includeNutrition' => 'true',
            'apiKey'           => $this->apiKey,
        ]);

        $result = $this->callApi($url);

        if ($result === null) {
            return $this->response->setStatusCode(502)->setJSON(['error' => 'Gagal memuat detail resep.']);
        }

        return $this->response->setJSON($result);
    }

    // ─── HELPER: HTTP GET (cURL Service) ───────────────────────────
    private function callApi(string $url): mixed
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_HTTPHEADER     => ['Accept: application/json'],
            CURLOPT_SSL_VERIFYPEER => false, 
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false || $httpCode !== 200) {
            return null;
        }

        return json_decode($response, true);
    }
}