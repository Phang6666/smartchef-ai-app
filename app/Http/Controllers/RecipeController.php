<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use PDF;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    /**
     * Display the homepage with the ingredient form.
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Handle the form submission and call the Gemini API.
     */

    public function generate(Request $request)
    {
        // 1. Validate all user inputs
        $request->validate([
            'ingredients' => 'required|string|min:5',
            'cuisine_select' => 'nullable|string',
            'cuisine_other' => 'nullable|string',
            'diet_select' => 'nullable|string',
            'diet_other' => 'nullable|string',
        ]);

        // 2. We get the inputs so we can display them in the mock data
        $ingredients = $request->input('ingredients');
        $cuisineSelection = $request->input('cuisine_select');
        $cuisineOther = $request->input('cuisine_other');

        // If the user chose "Other" AND typed something, use their text.
        // Otherwise, use the dropdown selection. Default to 'any'.
        // --- HYBRID LOGIC FOR CUISINE ---
        if ($cuisineSelection === 'other' && !empty($cuisineOther)) {
            $cuisine = $cuisineOther;
        } else {
            $cuisine = $cuisineSelection ?: 'any';
        }

        // --- HYBRID LOGIC FOR DIET ---
        $dietSelection = $request->input('diet_select');
        $dietOther = $request->input('diet_other');

        if ($dietSelection === 'other' && !empty($dietOther)) {
            $diet = $dietOther;
        } else {
            $diet = $dietSelection ?: 'none';
        }

        // 3. Build the prompt for the AI
        $prompt = "You are a recipe API. Your job is to return a recipe in a valid JSON format.
        Do not include any introductory text, just the JSON object.
        The recipe should use the following ingredients: {$ingredients}.";

        // Conditionally add the cuisine style to the prompt
        if ($cuisine !== 'any') {
            $prompt .= "\nThe recipe must be in the style of {$cuisine} cuisine.";
        }

        if ($diet !== 'none') {
            $prompt .= "\nThe recipe must adhere to the following goal or dietary restriction: {$diet}.";
        }

        $prompt .= "\n\nThe JSON object must have the following structure:
        {
        \"recipeName\": \"A creative and short recipe name\",
        \"description\": \"A brief, engaging, one-paragraph description of the dish.\",
        \"cookingTime\": \"A string, e.g., 'Approx. 45 minutes'\",
        \"calories\": \"A string, e.g., '~650 kcal per serving'\",
        \"difficulty\": \"A string, either Easy, Medium, or Hard\",
        \"cuisine\": \"A string describing the cuisine style of the generated recipe\",
        \"servings\": \"A string, e.g., 'Serves 2-3 people'\",
        \"ingredients\": [
            \"A string for ingredient 1, including quantity\",
            \"A string for ingredient 2\"
        ],
        \"instructions\": [
            \"A string for step 1\",
            \"A string for step 2\"
        ]
        }
        ";

        // 4. Prepare and send the API request
        $apiKey = config('services.gemini.api_key');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro-latest:generateContent?key={$apiKey}";
        $data = [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ];

        $response = Http::withOptions(['verify' => 'C:\\wamp64\\bin\\php\\php7.4.33\\extras\\ssl\\cacert.pem'])
                        ->post($url, $data);

        // 5. Handle the API response
        if ($response->successful()) {
            $rawText = $response->json('candidates.0.content.parts.0.text');
            preg_match('/\{.*\}/s', $rawText, $matches);

            if (empty($matches)) {
                $error = "Failed to find a valid recipe format in the AI's response.";
                return view('welcome', ['error' => $error]);
            }

            $jsonString = $matches[0];
            $recipeData = json_decode($jsonString, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $error = "Failed to parse the recipe. The AI returned an invalid format. Reason: " . json_last_error_msg();
                return view('welcome', ['error' => $error]);
            }

            // --- CUISINE NORMALIZATION ---
            $aiCuisine = $recipeData['cuisine'] ?? '';
            // If the user requested a custom "other" cuisine...
            if ($cuisine !== 'any' && !in_array($cuisine, ['Italian', 'Asian', 'Mexican', 'Mediterranean', 'Healthy', 'Dessert'])) {
                // ...and the AI's response is something long or contains "inspired" or "experimental"...
                if (strlen($aiCuisine) > 20 || str_contains(strtolower($aiCuisine), 'inspired') || str_contains(strtolower($aiCuisine), 'experimental')) {
                    // ...then override the AI's verbose response with the user's clean input.
                    $recipeData['cuisine'] = ucfirst($cuisine);
                }
            }

            // Get the image URL
            $imageUrl = $this->getImageUrlForRecipe($recipeData['recipeName'], $ingredients);

            // **NEW:** Call our ML service to get nutritional data
            // We use the ingredients list that the Gemini AI provided in its response
            $nutritionData = $this->getNutritionData($recipeData['ingredients']);

            // Return the final view with all the data, including nutrition
            return view('welcome', [
                'recipe' => $recipeData,
                'imageUrl' => $imageUrl,
                'nutrition' => $nutritionData, // Pass the new nutrition data to the view
                'previous_ingredients' => $ingredients,
                'previous_cuisine' => $cuisine,
                'previous_diet' => $diet
            ]);

        } else {
            $error = "Failed to generate recipe. The API returned an error: " . $response->body();
            return view('welcome', ['error' => $error]);
        }
    }


    public function generateMock(Request $request)
    {
        // 1. Validate all user inputs
        $request->validate([
            'ingredients' => 'required|string|min:5',
            'cuisine_select' => 'nullable|string',
            'cuisine_other' => 'nullable|string',
            'diet_select' => 'nullable|string',
            'diet_other' => 'nullable|string',
        ]);

        // 2. We get the inputs so we can display them in the mock data
        $ingredients = $request->input('ingredients');
        $cuisineSelection = $request->input('cuisine_select');
        $cuisineOther = $request->input('cuisine_other');

        // If the user chose "Other" AND typed something, use their text.
        // Otherwise, use the dropdown selection. Default to 'any'.
        // --- HYBRID LOGIC FOR CUISINE ---
        if ($cuisineSelection === 'other' && !empty($cuisineOther)) {
            $cuisine = $cuisineOther;
        } else {
            $cuisine = $cuisineSelection ?: 'any';
        }

        // --- HYBRID LOGIC FOR DIET ---
        $dietSelection = $request->input('diet_select');
        $dietOther = $request->input('diet_other');

        if ($dietSelection === 'other' && !empty($dietOther)) {
            $diet = $dietOther;
        } else {
            $diet = $dietSelection ?: 'none';
        }

        // 3. Create a fake recipe and nutrition data array with the exact same structure
        $mockRecipeData = [
            "recipeName" => "Mock Spicy Noodles (For Testing)",
            "description" => "A delicious and easy-to-make mock noodle dish perfect for testing the UI. This confirms the form is working. The cuisine style requested was: " . htmlspecialchars(ucfirst($cuisine)),
            "cookingTime" => "Approx. 10 minutes",
            "calories" => "~400 kcal per serving",
            "difficulty" => "Easy",
            "cuisine" => htmlspecialchars(ucfirst($cuisine)),
            "servings" => "Serves 1",
            "ingredients" => [
                "1 packet of instant noodles",
                "1 egg",
                "A splash of soy sauce",
                "Your ingredients: " . htmlspecialchars($ingredients)
            ],
            "instructions" => [
                "This is a mock recipe. Boil water and cook noodles.",
                "While noodles are cooking, fry an egg.",
                "Drain the noodles, add the seasoning packet and soy sauce.",
                "Place the fried egg on top and enjoy testing the beautiful UI you've built!"
            ]
        ];

        $mockNutritionData = [
            'calories' => 450.75,
            'protein' => 25.5,
            'fat' => 15.2,
            'carbs' => 50.1
        ];

        // 4. Simulate a 1-second delay to test your loading spinner
        sleep(1);

        // **NEW:** Provide a hard-coded placeholder image for mock mode
        $mockImageUrl = 'https://cdn.pixabay.com/photo/2017/01/16/17/45/pancake-1984716_640.jpg';

        // **NEW:** Pass the mock recipe data AND the mock image URL to the view
        return view('welcome', [
            'recipe' => $mockRecipeData,
            'imageUrl' => $mockImageUrl,
            'nutrition' => $mockNutritionData,
            'previous_ingredients' => $ingredients,
            'previous_cuisine' => $cuisine,
            'previous_diet' => $diet,
        ]);
    }



    /**
     * Searches for an image using a multi-tiered fallback system with keyword analysis.
     *
     * @param string $recipeName The creative recipe name from the AI.
     * @param string $ingredients The user's original ingredients string.
     * @return string|null The URL of the best image found, or null.
     */
    private function getImageUrlForRecipe(string $recipeName, string $ingredients): ?string
    {
        $apiKey = config('services.pixabay.api_key');

        // Tier 1: Smart combined search (NEW)
        $smartQuery = $this->buildSmartSearchQuery($recipeName, $ingredients);
        $imageUrl = $this->fetchPixabayImage($smartQuery, $apiKey);
        if ($imageUrl) return $imageUrl;

         // Tier 2: Try a simplified version of the recipe name
        $simplifiedName = $this->simplifyRecipeName($recipeName);
        if ($simplifiedName && $simplifiedName !== $recipeName) {
            $imageUrl = $this->fetchPixabayImage($simplifiedName, $apiKey);
            if ($imageUrl) {
                return $imageUrl;
            }
        }

        // Tier 3: If that failed, try searching for the raw ingredients
        $imageUrl = $this->fetchPixabayImage($ingredients, $apiKey);
        if ($imageUrl) {
            return $imageUrl; // Success on the fallback query!
        }

        // Tier 4: Find the "hero ingredient"
        $heroIngredient = $this->findHeroIngredient($ingredients);
        if ($heroIngredient) {
            $imageUrl = $this->fetchPixabayImage($heroIngredient, $apiKey);
            if ($imageUrl) {
                return $imageUrl; // Success on the "hero ingredient"!
            }
        }

        // If all three tiers fail, we give up and return null.
        return 'https://cdn.pixabay.com/photo/2017/01/22/19/20/spices-2003656_1280.jpg';
    }

    /**
     * A helper function to find the most important "hero" ingredient from a string.
     *
     * @param string $ingredients The user's input string.
     * @return string|null The best keyword found, or null.
     */
    private function findHeroIngredient(string $ingredients): ?string
    {
        // A list of common, generic words to ignore.
        $stopWords = [
            'salt', 'pepper', 'oil', 'water', 'sugar', 'flour', 'spice', 'spices', 'herbs',
            'sauce', 'garlic', 'onion', 'powder', 'flakes', 'dried', 'fresh', 'ground'
        ];

        // 1. Split the user's input into individual words.
        $words = preg_split('/[,\s]+/', strtolower($ingredients));

        // 2. Filter out any empty words and the common "stop words".
        $keywords = array_filter($words, function ($word) use ($stopWords) {
            return !empty($word) && !in_array($word, $stopWords);
        });

        // 3. Return the first important keyword we find.
        // reset() gets the first element of an array without needing to know its index.
        return reset($keywords) ?: null;
    }


    /**
     * A helper function to perform the actual Pixabay API call.
     * (This function remains unchanged)
     */
    private function fetchPixabayImage(string $query, string $apiKey): ?string
    {
        if (empty($query)) {
            return null;
        }
        $url = "https://pixabay.com/api/?key={$apiKey}&q=" . urlencode($query) . "&image_type=photo&orientation=horizontal&safesearch=true&per_page=3";
        try {
            $response = Http::withOptions(['verify' => 'C:\\wamp64\\bin\\php\\php7.4.33\\extras\\ssl\\cacert.pem'])->get($url);
            if ($response->successful() && !empty($response->json('hits'))) {
                return $response->json('hits.0.webformatURL');
            }
        } catch (\Exception $e) {
            return null;
        }
        return null;
    }

    /**
     * Simplifies creative AI recipe names by removing adjectives and extra words.
     * Example: "Sunset Chicken with Golden Rice Volcano" → "Chicken Rice"
     */
    private function simplifyRecipeName(string $name): string
    {
        // Convert to lowercase and remove punctuation
        $cleaned = strtolower(preg_replace('/[^a-zA-Z\s]/', '', $name));

        // Split into words
        $words = explode(' ', $cleaned);

        // List of common adjectives and fluff words to ignore
        $ignoreWords = [
            'sunset', 'golden', 'creamy', 'hearty', 'delicious', 'tasty', 'spicy', 'sweet',
            'savory', 'fluffy', 'volcano', 'fusion', 'burst', 'bowl', 'delight', 'dream',
            'perfect', 'crunchy', 'juicy', 'flavor', 'amazing', 'inspired', 'special', 'ultimate'
        ];

        // Filter out unhelpful words
        $filtered = array_filter($words, function ($word) use ($ignoreWords) {
            return !in_array($word, $ignoreWords) && strlen($word) > 2;
        });

        // Keep at most 2 main keywords for a clean query
        $main = array_slice($filtered, 0, 2);

        // Return simplified, title-cased name
        return ucwords(implode(' ', $main));
    }

    private function buildSmartSearchQuery(string $recipeName, string $ingredients): string
    {
        // Clean and lowercase both recipe name and ingredients
        $text = strtolower($recipeName . ' ' . $ingredients);
        $text = preg_replace('/[^a-z\s]/', '', $text);

        // Split into individual words
        $words = explode(' ', $text);

        // Common stop/adjective words to remove
        $ignoreWords = [
            'the','a','and','with','of','in','on','for','style','fusion',
            'golden','spicy','sweet','creamy','crunchy','fresh','flavor',
            'delicious','tasty','amazing','perfect','savory','ultimate'
        ];

        // Keep meaningful food-related keywords
        $filtered = array_filter($words, function ($word) use ($ignoreWords) {
            return !in_array($word, $ignoreWords) && strlen($word) > 2;
        });

        // De-duplicate and keep at most 3–4 strong terms
        $keywords = array_unique(array_slice($filtered, 0, 4));

        // Join them into one powerful search query
        return implode(' ', $keywords);
    }


    /**
     * Generates and downloads a PDF for a given recipe.
     */
    public function downloadPdf(Request $request)
    {
        // Get the raw JSON string from the input
        $recipeJson = $request->input('recipe');
        $imageUrl = $request->input('imageUrl');

        $recipeData = json_decode($recipeJson, true);

        if (empty($recipeData) || !is_array($recipeData)) {
            // This error will now only happen if something is truly wrong
            return back()->with('error', 'Could not generate PDF: Invalid recipe data provided.');
        }

        // Load the PDF view with the (now correctly formatted) data
        $pdf = PDF::loadView('recipe-pdf', [
            'recipe' => $recipeData,
            'imageUrl' => $imageUrl
        ]);

        // Create a clean filename for the download
        $filename = Str::slug($recipeData['recipeName'] ?? 'recipe') . '.pdf';

        // Prompt the user to download the file
        return $pdf->download($filename);
    }

    /**
     * Calls the ML microservice to get nutritional predictions for a list of ingredients.
     *
     * @param array $ingredients The list of ingredient strings from the Gemini recipe.
     * @return array|null The nutritional data or null if the call fails.
     */
    private function getNutritionData(array $ingredients): ?array
    {
        // The URL of our local Python/Flask service
        $url = 'http://127.0.0.1:5001/predict';

        try {
            // We don't need the SSL fix here because it's a local, non-HTTPS call
            $response = Http::post($url, [
                'ingredients' => $ingredients
            ]);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            // If the Flask service is down or there's a connection error
            // Log the error in a real app: Log::error('ML service connection failed: ' . $e->getMessage());
            return null;
        }

        return null;
    }
}