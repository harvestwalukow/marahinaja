<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIWizardController extends Controller
{
    /**
     * Show the AI Wizard form
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('ai-wizard.index');
    }

    /**
     * Process the AI Wizard form and generate recommendations
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function generateRecommendations(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'gender' => 'required|in:male,female',
            'job_status' => 'required|string',
            'age' => 'required|numeric|min:13|max:100',
            'anger_reason' => 'required|string|max:500',
            'anger_level' => 'required|numeric|min:1|max:10',
        ]);

        try {
            // Generate text recommendations using Hugging Face API
            $recommendations = $this->getRecommendationsFromAPI($validated);
            
            // Generate images for each recommendation
            $images = $this->generateImagesForRecommendations($recommendations, $validated);
            
            // Combine recommendations with images
            $results = [];
            for ($i = 0; $i < 3; $i++) {
                $results[] = [
                    'title' => $recommendations[$i]['title'],
                    'description' => $recommendations[$i]['description'],
                    'image' => $images[$i]
                ];
            }
            
            return view('ai-wizard.results', [
                'results' => $results,
                'userInput' => $validated
            ]);
            
        } catch (\Exception $e) {
            Log::error('AI Wizard error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan dalam memproses permintaan. Silakan coba lagi.')
                ->withInput();
        }
    }

    /**
     * Get recommendations from Hugging Face API
     *
     * @param  array  $data
     * @return array
     */
    private function getRecommendationsFromAPI($data)
    {
        // Create prompt based on user data
        $genderText = $data['gender'] == 'male' ? 'Laki-laki' : 'Perempuan';
        
        $prompt = "Berikan 3 rekomendasi praktis untuk seorang {$genderText} berusia {$data['age']} tahun yang bekerja sebagai {$data['job_status']} " .
                 "yang sedang marah karena '{$data['anger_reason']}' dengan tingkat kemarahan {$data['anger_level']}/10.\n\n" .
                 "Format jawaban:\n" .
                 "1. Judul: [judul rekomendasi 1]\nDeskripsi: [deskripsi singkat rekomendasi 1]\n" .
                 "2. Judul: [judul rekomendasi 2]\nDeskripsi: [deskripsi singkat rekomendasi 2]\n" .
                 "3. Judul: [judul rekomendasi 3]\nDeskripsi: [deskripsi singkat rekomendasi 3]";

        try {
            // Make the actual API call to Hugging Face
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_TOKEN'),
                'Content-Type' => 'application/json',
            ])->post('https://api-inference.huggingface.co/models/mistralai/Mistral-7B-Instruct-v0.2', [
                'inputs' => $prompt,
                'parameters' => [
                    'max_new_tokens' => 500,
                    'temperature' => 0.7,
                    'top_p' => 0.95,
                    'return_full_text' => false
                ]
            ]);
            
            if ($response->successful()) {
                $result = $response->json();
                
                // Extract the generated text from the response
                $generatedText = $result[0]['generated_text'] ?? '';
                
                // Parse the recommendations from the generated text
                return $this->parseAPIResponse($generatedText);
            } else {
                // Log the error
                Log::error('Hugging Face API error: ' . $response->body());
                
                // Fallback to mock recommendations if API fails
                return $this->getFallbackRecommendations($data);
            }
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Hugging Face API exception: ' . $e->getMessage());
            
            // Fallback to mock recommendations
            return $this->getFallbackRecommendations($data);
        }
    }

    /**
     * Parse API response and extract recommendations
     *
     * @param string $text
     * @return array
     */
    private function parseAPIResponse($text)
    {
        $recommendations = [];
        
        // Regular expression to match recommendation pattern
        $pattern = '/(\d+)\.\s*Judul:\s*([^\n]+)\s*\nDeskripsi:\s*([^\n]+)/i';
        
        if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $recommendations[] = [
                    'title' => trim($match[2]),
                    'description' => trim($match[3])
                ];
                
                // Only need 3 recommendations
                if (count($recommendations) >= 3) {
                    break;
                }
            }
        }
        
        // If we couldn't parse 3 recommendations, fill with defaults
        while (count($recommendations) < 3) {
            $recommendations[] = [
                'title' => 'Rekomendasi ' . (count($recommendations) + 1),
                'description' => 'Teknik menenangkan diri dan mengelola emosi negatif.'
            ];
        }
        
        return $recommendations;
    }

    /**
     * Get fallback recommendations if API fails
     * 
     * @param array $data
     * @return array
     */
    private function getFallbackRecommendations($data)
    {
        // Use the existing mock implementation
        return $this->parseRecommendations($data);
    }

    /**
     * Parse text recommendations into structured format
     * 
     * This is a placeholder method with mock data
     *
     * @param  array  $data
     * @return array
     */
    private function parseRecommendations($data)
    {
        // Mock recommendations based on user input
        $recommendations = [];
        
        if ($data['job_status'] == 'Mahasiswa') {
            $recommendations = [
                [
                    'title' => 'Fokus Persiapan Semester Berikutnya',
                    'description' => 'Gunakan waktu ini untuk memperbaiki pemahaman materi dan jadwal belajar yang lebih konsisten.'
                ],
                [
                    'title' => 'Tenangkan Pikiran Lewat Aktivitas Fisik',
                    'description' => 'Luangkan waktu untuk olahraga ringan seperti jalan pagi atau meditasi agar pikiran lebih segar.'
                ],
                [
                    'title' => 'Cari Dukungan Teman',
                    'description' => 'Ceritakan pengalamanmu ke teman dekat atau kelompok belajar untuk saling memberi semangat.'
                ]
            ];
        } elseif ($data['job_status'] == 'Karyawan') {
            $recommendations = [
                [
                    'title' => 'Atur Keseimbangan Hidup & Kerja',
                    'description' => 'Tetapkan batasan jelas antara waktu kerja dan pribadi untuk mengurangi stres berlebih.'
                ],
                [
                    'title' => 'Komunikasikan Dengan Baik',
                    'description' => 'Bicarakan masalah dengan atasan atau rekan kerja untuk mencari solusi yang konstruktif.'
                ],
                [
                    'title' => 'Manfaatkan Waktu Istirahat',
                    'description' => 'Gunakan waktu istirahat untuk aktivitas yang menenangkan, seperti meditasi singkat atau stretching.'
                ]
            ];
        } else {
            $recommendations = [
                [
                    'title' => 'Refleksi Diri',
                    'description' => 'Luangkan waktu untuk mengenali pola pemicu kemarahan dan bagaimana mengatasinya lebih baik di masa depan.'
                ],
                [
                    'title' => 'Aktivitas Pengalih Perhatian',
                    'description' => 'Lakukan kegiatan yang membuat pikiran teralihkan seperti hobi kreatif atau aktivitas fisik.'
                ],
                [
                    'title' => 'Praktik Mindfulness',
                    'description' => 'Coba teknik pernapasan dalam dan mindfulness untuk menenangkan pikiran dan meredakan emosi.'
                ]
            ];
        }
        
        return $recommendations;
    }

    /**
     * Generate images for recommendations
     *
     * @param  array  $recommendations
     * @param  array  $userData
     * @return array
     */
    private function generateImagesForRecommendations($recommendations, $userData)
    {
        $genderText = $userData['gender'] == 'male' ? 'Laki-laki' : 'Perempuan';
        $ageText = $userData['age'];
        $jobText = $userData['job_status'];
        
        // Image prompts based on the recommendations content
        $imagePrompts = [
            0 => "A {$genderText} aged {$ageText} working as {$jobText} studying in a bedroom, focused preparation for next semester, detailed, realistic, high quality",
            1 => "A {$genderText} aged {$ageText} meditating or taking morning walk, calming the mind through physical activity, peaceful, serene, high quality",
            2 => "A {$genderText} aged {$ageText} discussing with friends, seeking support, coffee shop setting, friendly conversation, supportive atmosphere, high quality"
        ];
        
        $images = [];
        
        for ($i = 0; $i < 3; $i++) {
            try {
                // Make API call to Hugging Face for image generation
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('HUGGINGFACE_API_TOKEN'),
                    'Content-Type' => 'application/json',
                ])->post('https://api-inference.huggingface.co/models/stabilityai/stable-diffusion-xl-base-1.0', [
                    'inputs' => $imagePrompts[$i],
                    'parameters' => [
                        'negative_prompt' => 'ugly, deformed, disfigured, poor quality, blurry',
                        'num_inference_steps' => 30,
                        'guidance_scale' => 7.5
                    ]
                ]);
                
                if ($response->successful()) {
                    // Save the image to public/storage/ai-wizard
                    $imageData = $response->body();
                    $filename = 'recommendation-' . $userData['gender'] . '-' . $i . '-' . time() . '.jpg';
                    $path = 'ai-wizard/' . $filename;
                    
                    // Ensure the directory exists
                    if (!file_exists(public_path('storage/ai-wizard'))) {
                        mkdir(public_path('storage/ai-wizard'), 0755, true);
                    }
                    
                    // Save the image
                    file_put_contents(public_path('storage/' . $path), $imageData);
                    
                    // Store the image URL
                    $images[] = asset('storage/' . $path);
                } else {
                    // Log error and use fallback
                    Log::error('Image generation API error: ' . $response->body());
                    $images[] = $this->getFallbackImage($i, $userData);
                }
            } catch (\Exception $e) {
                // Log exception and use fallback
                Log::error('Image generation exception: ' . $e->getMessage());
                $images[] = $this->getFallbackImage($i, $userData);
            }
        }
        
        return $images;
    }
    
    /**
     * Get fallback images if API fails
     *
     * @param int $index
     * @param array $userData
     * @return string
     */
    private function getFallbackImage($index, $userData)
    {
        $genderPrefix = $userData['gender'] == 'male' ? 'male' : 'female';
        $ageGroup = $userData['age'] < 25 ? 'young' : 'adult';
        
        // Check if placeholder images exist
        $placeholderPath = 'images/ai-wizard/' . $genderPrefix . '-' . $ageGroup . '-' . ($index + 1) . '.jpg';
        
        if (file_exists(public_path($placeholderPath))) {
            return asset($placeholderPath);
        }
        
        // If no placeholder images, use generic images based on recommendation type
        switch ($index) {
            case 0:
                return asset('images/ai-wizard/study-placeholder.jpg');
            case 1:
                return asset('images/ai-wizard/meditation-placeholder.jpg');
            case 2:
                return asset('images/ai-wizard/friends-placeholder.jpg');
            default:
                return asset('images/ai-wizard/default-placeholder.jpg');
        }
    }
} 