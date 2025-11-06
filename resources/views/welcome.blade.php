<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartChef AI</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-to-b from-green-50 via-white to-green-100 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white/90 backdrop-blur-sm shadow-lg sticky top-0 z-50">
        <div class="max-w-6xl mx-auto flex justify-between items-center p-4">
            <h1 class="text-2xl md:text-3xl font-extrabold text-green-600 tracking-tight flex items-center gap-2">
                🍲 <span>SmartChef AI</span>
            </h1>
            <a href="#recipe-form" class="text-sm font-semibold text-green-700 hover:text-green-800 transition">Get Started</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="text-center px-6 py-16 md:py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-green-100 via-white to-green-50 opacity-50 -z-10"></div>
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4 leading-tight">
            Turn Your Leftovers Into A <span class="text-green-600">Masterpiece!</span>
        </h2>
        <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
            Enter the ingredients you have, and let SmartChef AI craft a delicious recipe tailored just for you.
        </p>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        <div class="max-w-3xl mx-auto px-6">

            <!-- Input Form -->
            <div class="bg-white p-8 rounded-2xl shadow-xl border border-green-100 hover:shadow-2xl transition-all duration-300">
                <form action="{{ route('recipe.generate') }}" method="POST" id="recipe-form">
                    @csrf

                    <div class="mb-6">
                        <label for="ingredients" class="block text-lg font-semibold mb-2 text-gray-800">Your Ingredients</label>
                        <input type="text" name="ingredients" id="ingredients"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                            placeholder="e.g., chicken breast, tomatoes, rice, onion" required>
                    </div>

                    <div class="mb-6">
                        <label for="cuisine" class="block text-lg font-semibold mb-2 text-gray-800">Cuisine Type (Optional)</label>
                        <select name="cuisine" id="cuisine"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="any">Any</option>
                            <option value="Italian">Italian</option>
                            <option value="Asian">Asian</option>
                            <option value="Mexican">Mexican</option>
                            <option value="Mediterranean">Mediterranean</option>
                            <option value="Healthy">Healthy</option>
                            <option value="Dessert">Dessert</option>
                        </select>
                    </div>

                    <button type="submit" id="generate-button"
                        class="w-full bg-gradient-to-r from-green-600 to-green-500 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:from-green-700 hover:to-green-600 transition-all duration-300 flex items-center justify-center disabled:opacity-70">
                        <svg id="loading-spinner"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white hidden"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2
                                   5.291A7.962 7.962 0 014 12H0c0 3.042
                                   1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="button-text">Generate Recipe</span>
                    </button>
                </form>
            </div>

            <!-- Recipe Output -->
            @if (isset($recipe) && is_array($recipe))
                <div class="max-w-3xl mx-auto mt-12 p-6 md:p-10 bg-white rounded-3xl shadow-2xl relative overflow-hidden transition-all duration-300 hover:shadow-[0_0_30px_-5px_rgba(16,185,129,0.3)]">
                    <div class="absolute inset-0 bg-gradient-to-tr from-green-100 via-white to-transparent pointer-events-none rounded-3xl"></div>

                    <div class="relative">
                        <h2 class="text-4xl font-extrabold text-gray-900 mb-3 text-center">{{ $recipe['recipeName'] }}</h2>
                        <p class="text-gray-600 text-center mb-8 max-w-2xl mx-auto leading-relaxed">
                            {{ $recipe['description'] }}
                        </p>
                    </div>

                    <div class="relative grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl mb-10 border border-green-200 shadow-inner">
                        @php
                            $details = [
                                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'label' => 'Time', 'value' => $recipe['cookingTime']],
                                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>', 'label' => 'Calories', 'value' => $recipe['calories']],
                                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>', 'label' => 'Difficulty', 'value' => $recipe['difficulty']],
                                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2h8a2 2 0 002-2v-1a2 2 0 012-2h1.945M7.737 11l-.261-2.61m1.104-5.52l.26-2.609M10.5 7.5l.261-2.61M13.5 7.5l.261-2.61M16.263 11l.261-2.61m1.104-5.52l-.26-2.609M12 21V11"/>', 'label' => 'Cuisine', 'value' => $recipe['cuisine']],
                                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>', 'label' => 'Servings', 'value' => $recipe['servings']],
                            ];
                        @endphp

                        @foreach ($details as $detail)
                            <div class="flex flex-col items-center bg-white/80 backdrop-blur-sm p-4 rounded-xl shadow-sm hover:shadow-md transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    {!! $detail['icon'] !!}
                                </svg>
                                <span class="text-sm font-medium text-gray-600">{{ $detail['label'] }}</span>
                                <span class="text-lg font-semibold text-gray-900 mt-1">{{ $detail['value'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="relative mb-10">
                        <h3 class="text-2xl font-bold text-green-700 mb-4 flex items-center gap-2">
                            <span class="h-5 w-5 bg-green-500 rounded-full"></span> Ingredients
                        </h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-700 text-base leading-relaxed">
                            @foreach ($recipe['ingredients'] as $ingredient)
                                <li class="pl-2 hover:text-green-700 transition duration-150">{{ $ingredient }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="relative">
                        <h3 class="text-2xl font-bold text-green-700 mb-4 flex items-center gap-2">
                            <span class="h-5 w-5 bg-green-500 rounded-full"></span> Instructions
                        </h3>
                        <ol class="list-decimal list-inside space-y-4 text-gray-700 text-base leading-relaxed">
                            @foreach ($recipe['instructions'] as $instruction)
                                <li class="pl-2 hover:text-green-700 transition duration-150">{{ $instruction }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            @endif

            @if (isset($error))
                <div class="max-w-2xl mx-auto mt-10 bg-red-50 border border-red-300 text-red-800 px-6 py-4 rounded-2xl shadow-lg flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-red-600 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 19a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                    <div>
                        <strong class="font-bold">Error:</strong>
                        <span class="block">{{ $error }}</span>
                    </div>
                </div>
            @endif
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-6 mt-16 bg-white border-t border-green-100 text-gray-500">
        <p>Built by <span class="font-semibold text-green-700">Phang Jet</span> | Powered by <span class="font-semibold text-green-700">Google Gemini AI</span></p>
    </footer>

    <script>
        const recipeForm = document.getElementById('recipe-form');
        const generateButton = document.getElementById('generate-button');
        const buttonText = document.getElementById('button-text');
        const loadingSpinner = document.getElementById('loading-spinner');

        recipeForm.addEventListener('submit', function() {
            generateButton.disabled = true;
            loadingSpinner.classList.remove('hidden');
            buttonText.textContent = 'Generating...';
        });
    </script>
</body>
</html>
