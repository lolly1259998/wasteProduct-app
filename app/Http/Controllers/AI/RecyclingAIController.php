<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecyclingAIController extends Controller
{
    private $aiServiceUrl = 'http://localhost:5002';

    /**
     * Classify waste with AI
     */
    public function classifyWaste(Request $request)
    {
        try {
            $response = Http::timeout(10)->post($this->aiServiceUrl . '/classify-waste', [
                'type' => $request->input('type'),
                'weight' => $request->input('weight'),
                'description' => $request->input('description')
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'success' => false,
                'error' => 'AI Service unavailable'
            ], 503);

        } catch (\Exception $e) {
            Log::error('AI Classification Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error during classification'
            ], 500);
        }
    }

    /**
     * Predict the quality of a recycled product
     */
    public function predictQuality(Request $request)
    {
        try {
            $response = Http::timeout(10)->post($this->aiServiceUrl . '/predict-quality', [
                'waste_type' => $request->input('waste_type'),
                'recycling_method' => $request->input('recycling_method'),
                'waste_condition' => $request->input('waste_condition', 'good'),
                'storage_days' => $request->input('storage_days', 0)
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'success' => false,
                'error' => 'AI Service unavailable'
            ], 503);

        } catch (\Exception $e) {
            Log::error('AI Quality Prediction Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error during quality prediction'
            ], 500);
        }
    }

    /**
     * Estimate the price of a recycled product
     */
    public function estimatePrice(Request $request)
    {
        try {
            $response = Http::timeout(10)->post($this->aiServiceUrl . '/estimate-price', [
                'product_name' => $request->input('product_name'),
                'waste_category' => $request->input('waste_category'),
                'quality_score' => $request->input('quality_score', 70),
                'recycling_cost' => $request->input('recycling_cost', 10),
                'market_demand' => $request->input('market_demand', 50)
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'success' => false,
                'error' => 'AI Service unavailable'
            ], 503);

        } catch (\Exception $e) {
            Log::error('AI Price Estimation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error during price estimation'
            ], 500);
        }
    }

    /**
     * Generate a product description
     */
    public function generateDescription(Request $request)
    {
        try {
            $response = Http::timeout(10)->post($this->aiServiceUrl . '/generate-description', [
                'product_name' => $request->input('product_name'),
                'source_material' => $request->input('source_material'),
                'recycling_method' => $request->input('recycling_method'),
                'specifications' => $request->input('specifications', [])
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'success' => false,
                'error' => 'AI Service unavailable'
            ], 503);

        } catch (\Exception $e) {
            Log::error('AI Description Generation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error during description generation'
            ], 500);
        }
    }

    /**
     * Optimize a recycling process
     */
    public function optimizeProcess(Request $request)
    {
        try {
            $response = Http::timeout(10)->post($this->aiServiceUrl . '/optimize-process', [
                'process_data' => $request->input('process_data', []),
                'current_efficiency' => $request->input('current_efficiency', 70)
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'success' => false,
                'error' => 'AI Service unavailable'
            ], 503);

        } catch (\Exception $e) {
            Log::error('AI Process Optimization Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Error during process optimization'
            ], 500);
        }
    }

    /**
     * Check AI service status
     */
    public function healthCheck()
    {
        try {
            $response = Http::timeout(5)->get($this->aiServiceUrl . '/health');

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json([
                'status' => 'unhealthy',
                'error' => 'AI Service unavailable'
            ], 503);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'unhealthy',
                'error' => 'Unable to contact AI service'
            ], 503);
        }
    }
}
