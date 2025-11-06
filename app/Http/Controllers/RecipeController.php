<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str; // Make sure to import Str

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
            'cuisine' => 'nullable|string',
        ]);

        // 2. Get the inputs from the request
        $ingredients = $request->input('ingredients');
        $cuisine = $request->input('cuisine', 'any');

        // 3. Build the prompt for the AI
        $prompt = "You are a recipe API. Your job is to return a recipe in a valid JSON format.
        Do not include any introductory text, just the JSON object.
        The recipe should use the following ingredients: {$ingredients}.";

        // Conditionally add the cuisine style to the prompt
        if ($cuisine !== 'any') {
            $prompt .= "\nThe recipe must be in the style of {$cuisine} cuisine.";
        }

        $prompt .= "\n\nThe JSON object must have the following structure:
        {
        \"recipeName\": \"A creative and short recipe name\",
        \"description\": \"A brief, engaging, one-paragraph description of the dish.\",
        \"cookingTime\": \"A string, e.g., 'Approx. 45 minutes'\",
        \"calories\": \"A string, e.g., '~650 kcal per serving'\",
        \"difficulty\": \"A string, either Easy, Medium, or Hard\",
        \"cuisine\": \"A string matching the requested cuisine style, e.g., '{$cuisine}'\",
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

            return view('welcome', [
                'recipe' => $recipeData,
                'previous_ingredients' => $ingredients,
                'previous_cuisine' => $cuisine
            ]);

        } else {
            $error = "Failed to generate recipe. The API returned an error: " . $response->body();
            return view('welcome', ['error' => $error]);
        }
    }


    public function generateMock(Request $request)
    {
        // 1. We still validate the inputs to make sure the form is working
        $request->validate([
            'ingredients' => 'required|string|min:5',
            'cuisine' => 'nullable|string',
        ]);

        // 2. We get the inputs so we can display them in the mock data
        $ingredients = $request->input('ingredients');
        $cuisine = $request->input('cuisine', 'any');

        // 3. Create a fake recipe data array with the exact same structure
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

        // 4. Simulate a 1-second delay to test your loading spinner
        sleep(1);

        // 5. Return the view with the mock data
        return view('welcome', [
            'recipe' => $mockRecipeData,
            'previous_ingredients' => $ingredients,
            'previous_cuisine' => $cuisine
        ]);
    }

}