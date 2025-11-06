<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartChef AI</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-md p-4">
        <div class="container mx-auto">
            <h1 class="text-2xl font-bold text-green-600">🍲 SmartChef AI</h1>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="container mx-auto p-6">
        <div class="text-center my-12">
            <h2 class="text-4xl font-bold mb-2">Turn Your Leftovers Into A Masterpiece!</h2>
            <p class="text-gray-600">Enter the ingredients you have, and our AI will create a custom recipe for you.</p>
        </div>

        <!-- Input Form -->
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <form action="{{ route('recipe.generate') }}" method="POST" id="recipe-form">
                @csrf
                <div class="mb-4">
                    <label for="ingredients" class="block text-lg font-medium mb-2">Your Ingredients:</label>
                    <input type="text" name="ingredients" id="ingredients" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="e.g., chicken breast, tomatoes, rice, onion" required>
                </div>
                <div class="mb-4">
                    <label for="cuisine" class="block text-lg font-medium mb-2">Cuisine Type (Optional):</label>
                    <select name="cuisine" id="cuisine" class="w-full p-3 border border-gray-300 rounded-lg">
                        <option value="any">Any</option>
                        <option value="Italian">Italian</option>
                        <option value="Asian">Asian</option>
                        <option value="Mexican">Mexican</option>
                        <option value="Mediterranean">Mediterranean</option>
                        <option value="Healthy">Healthy</option>
                        <option value="Dessert">Dessert</option>
                    </select>
                </div>

                <button type="submit" id="generate-button" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition duration-300 flex items-center justify-center disabled:bg-green-400">
                    <!-- This is the spinner icon, hidden by default -->
                    <svg id="loading-spinner" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="button-text">Generate Recipe</span>
                </button>
            </form>
        </div>

        <!-- Recipe Display Area -->
        @if (isset($recipe) && is_array($recipe))
            <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">

                <!-- Recipe Name -->
                <h2 class="text-3xl font-bold mb-2">{{ $recipe['recipeName'] }}</h2>

                <!-- Description -->
                <p class="text-gray-600 mb-6">{{ $recipe['description'] }}</p>

                <!-- Quick Details (Time & Calories, etc.) -->
                <div class="flex flex-wrap justify-around bg-green-50 p-4 rounded-lg mb-6 text-center">
                    <div class="p-2 min-w-[100px]">
                        <span class="block text-sm font-medium text-gray-500">Time</span>
                        <span class="text-lg font-bold text-green-700">{{ $recipe['cookingTime'] }}</span>
                    </div>
                    <div class="p-2 min-w-[100px]">
                        <span class="block text-sm font-medium text-gray-500">Calories</span>
                        <span class="text-lg font-bold text-green-700">{{ $recipe['calories'] }}</span>
                    </div>
                    <div class="p-2 min-w-[100px]">
                        <span class="block text-sm font-medium text-gray-500">Difficulty</span>
                        <span class="text-lg font-bold text-green-700">{{ $recipe['difficulty'] }}</span>
                    </div>
                    <div class="p-2 min-w-[100px]">
                        <span class="block text-sm font-medium text-gray-500">Cuisine</span>
                        <span class="text-lg font-bold text-green-700">{{ $recipe['cuisine'] }}</span>
                    </div>
                    <div class="p-2 min-w-[100px]">
                        <span class="block text-sm font-medium text-gray-500">Servings</span>
                        <span class="text-lg font-bold text-green-700">{{ $recipe['servings'] }}</span>
                    </div>
                </div>

                <!-- Ingredients -->
                <div class="mb-6">
                    <h3 class="text-2xl font-semibold mb-3">Ingredients</h3>
                    <ul class="list-disc list-inside space-y-2">
                        @foreach ($recipe['ingredients'] as $ingredient)
                            <li>{{ $ingredient }}</li>
                        @endforeach
                    </ul>
                </div>

                <!-- Instructions -->
                <div>
                    <h3 class="text-2xl font-semibold mb-3">Instructions</h3>
                    <ol class="list-decimal list-inside space-y-3">
                        @foreach ($recipe['instructions'] as $instruction)
                            <li>{{ $instruction }}</li>
                        @endforeach
                    </ol>
                </div>

            </div>
        @endif

        @if (isset($error))
            <div class="max-w-2xl mx-auto bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow-lg mt-10" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ $error }}</span>
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="text-center p-6 mt-12 text-gray-500">
        <p>Built by Phang Jet | Powered by Google Gemini AI</p>
    </footer>

    <script>
        // Find the form on the page
        const recipeForm = document.getElementById('recipe-form');

        // Find the elements inside the button
        const generateButton = document.getElementById('generate-button');
        const buttonText = document.getElementById('button-text');
        const loadingSpinner = document.getElementById('loading-spinner');

        // Listen for when the form is submitted
        recipeForm.addEventListener('submit', function() {
            // When submitted, do the following:

            // 1. Disable the button to prevent multiple clicks
            generateButton.disabled = true;

            // 2. Show the spinner
            loadingSpinner.classList.remove('hidden');

            // 3. Change the button text
            buttonText.textContent = 'Generating...';
        });
    </script>

</body>
</html>