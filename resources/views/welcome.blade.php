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
                            placeholder="e.g., chicken breast, tomatoes, rice, onion" required
                            value="{{ $previous_ingredients ?? '' }}">
                    </div>

                    <div class="mb-6">
                        <label for="cuisine-select" class="block text-lg font-semibold mb-2 text-gray-800">Cuisine Type (Optional)</label>

                        @php
                            // This is the logic block that was missing
                            $standardCuisines = ['any', 'Italian', 'Asian', 'Mexican', 'Mediterranean', 'Healthy', 'Dessert'];
                            $isOtherCuisine = isset($previous_cuisine) && !in_array($previous_cuisine, $standardCuisines);
                        @endphp

                        <select name="cuisine_select" id="cuisine-select" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="any" {{ ($previous_cuisine ?? 'any') == 'any' ? 'selected' : '' }}>Any</option>
                            <option value="Italian" {{ ($previous_cuisine ?? '') == 'Italian' ? 'selected' : '' }}>Italian</option>
                            <option value="Asian" {{ ($previous_cuisine ?? '') == 'Asian' ? 'selected' : '' }}>Asian</option>
                            <option value="Mexican" {{ ($previous_cuisine ?? '') == 'Mexican' ? 'selected' : '' }}>Mexican</option>
                            <option value="Mediterranean" {{ ($previous_cuisine ?? '') == 'Mediterranean' ? 'selected' : '' }}>Mediterranean</option>
                            <option value="Healthy" {{ ($previous_cuisine ?? '') == 'Healthy' ? 'selected' : '' }}>Healthy</option>
                            <option value="Dessert" {{ ($previous_cuisine ?? '') == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                            <!-- This line is now fixed -->
                            <option value="other" {{ $isOtherCuisine ? 'selected' : '' }}>Other...</option>
                        </select>

                        <!-- These attributes are now fixed -->
                        <input type="text" name="cuisine_other" id="cuisine-other-input"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 mt-2 {{ !$isOtherCuisine ? 'hidden' : '' }}"
                            placeholder="e.g., Spicy Thai, Kid-Friendly, French"
                            value="{{ $isOtherCuisine ? ($previous_cuisine ?? '') : '' }}">
                    </div>

                    <div class="mb-6">
                        <label for="diet-select" class="block text-lg font-semibold mb-2 text-gray-800">Dietary Goal (Optional)</label>

                        @php
                            $standardDiets = ['none', 'Low Calorie', 'High Protein', 'Vegetarian', 'Gluten-Free', 'Quick Meal'];
                            $isOtherDiet = isset($previous_diet) && !in_array($previous_diet, $standardDiets);
                        @endphp

                        <select name="diet_select" id="diet-select" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="none" {{ ($previous_diet ?? 'none') == 'none' ? 'selected' : '' }}>None</option>
                            <option value="Low Calorie" {{ ($previous_diet ?? '') == 'Low Calorie' ? 'selected' : '' }}>Low Calorie</option>
                            <option value="High Protein" {{ ($previous_diet ?? '') == 'High Protein' ? 'selected' : '' }}>High Protein</option>
                            <option value="Vegetarian" {{ ($previous_diet ?? '') == 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                            <option value="Gluten-Free" {{ ($previous_diet ?? '') == 'Gluten-Free' ? 'selected' : '' }}>Gluten-Free</option>
                            <option value="Quick Meal" {{ ($previous_diet ?? '') == 'Quick Meal' ? 'selected' : '' }}>Quick Meal (under 20 mins)</option>
                            <option value="other" {{ $isOtherDiet ? 'selected' : '' }}>Other...</option>
                        </select>

                        <input type="text" name="diet_other" id="diet-other-input"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 mt-2 {{ !$isOtherDiet ? 'hidden' : '' }}"
                            placeholder="e.g., Low Carb, Vegan, No Nuts"
                            value="{{ $isOtherDiet ? ($previous_diet ?? '') : '' }}">
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
            <div id="recipe-output-section">
                @if (isset($recipe) && is_array($recipe))
                    <div id="recipe-card" class="max-w-3xl mx-auto mt-12 p-6 md:p-10 bg-white rounded-3xl shadow-2xl relative overflow-hidden transition-all duration-300 hover:shadow-[0_0_30px_-5px_rgba(16,185,129,0.3)] opacity-0 transition-opacity duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-tr from-green-100 via-white to-transparent pointer-events-none rounded-3xl"></div>

                        <div class="flex justify-end mb-6 relative z-10" data-html2canvas-ignore>
                            <!-- "SHARE" BUTTON HERE -->
                            <button id="share-button" class="flex items-center gap-2 bg-purple-100 text-purple-800 font-semibold py-2 px-4 rounded-lg shadow-sm border border-purple-300 hover:bg-purple-200 active:scale-95 transition-all duration-200 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12s-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.368a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                </svg>
                                <span id="share-text">Share</span>
                            </button>

                            <!-- "COPY" BUTTON HERE -->
                            <button id="copy-button"
                                class="flex items-center gap-2 bg-green-100/80 text-green-800 font-semibold py-2 px-4 rounded-lg shadow-sm border border-green-300 hover:bg-green-200 hover:shadow-md active:scale-95 transition-all duration-200 text-sm backdrop-blur-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span id="copy-text">Copy</span>
                            </button>

                            <!-- "DOWNLOAD" BUTTON HERE -->
                            <form action="{{ route('recipe.download') }}" method="POST" class="ml-2">
                                @csrf
                                <!-- use hidden inputs to pass the recipe data to the download controller -->
                                <input type="hidden" name="recipe" value="{{ json_encode($recipe) }}">
                                <input type="hidden" name="imageUrl" value="{{ $imageUrl ?? '' }}">

                                <button type="submit" class="flex items-center gap-2 bg-slate-100 text-slate-700 font-semibold py-2 px-4 rounded-lg shadow-sm border border-slate-300 hover:bg-slate-200 active:scale-95 transition-all duration-200 text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>PDF</span>
                                </button>
                            </form>

                            <!-- "SAVE AS IMAGE" BUTTON HERE -->
                            <button id="save-image-button" class="ml-2 flex items-center gap-2 bg-blue-100 text-blue-800 font-semibold py-2 px-4 rounded-lg shadow-sm border border-blue-300 hover:bg-blue-200 active:scale-95 transition-all duration-200 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span id="save-image-text">Image</span>
                            </button>
                        </div>

                        @if (!empty($imageUrl))
                        <div class="relative mb-6">
                            <img src="{{ $imageUrl }}" alt="Photo of {{ $recipe['recipeName'] }}" class="w-full h-64 object-cover rounded-2xl shadow-lg">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent rounded-2xl"></div>
                        </div>
                        @endif

                        <div class="relative">
                            <h2 class="text-4xl font-extrabold text-gray-900 mb-3 text-center">{{ $recipe['recipeName'] }}</h2>

                            @if (isset($previous_diet) && $previous_diet !== 'none')
                                <div class="text-center mb-6">
                                    <span class="inline-block bg-cyan-100 text-cyan-800 text-sm font-semibold px-3 py-1 rounded-full border border-cyan-200">
                                        Goal: {{ $previous_diet }}
                                    </span>
                                </div>
                            @endif

                            <p class="text-gray-600 text-center mb-8 max-w-2xl mx-auto leading-relaxed">
                                {{ $recipe['description'] }}
                            </p>
                            <div class="relative bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded-r-lg mb-8 max-w-2xl mx-auto text-sm">
                                <p><strong>Please Note:</strong> SmartChef AI is a creative assistant. While it tries its best to follow cuisine and dietary requests, the results are AI-generated and may be creative interpretations. Always use your best judgment when cooking.</p>
                            </div>
                        </div>

                        <div class="relative grid grid-cols-2 md:grid-cols-4 gap-6 bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl mb-10 border border-green-200 shadow-inner">
                            @php
                                $details = [
                                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'label' => 'Time', 'value' => $recipe['cookingTime']],
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

                        @if (isset($nutrition) && is_array($nutrition))
                            <div class="relative mt-8">
                                <h3 class="text-2xl font-bold text-green-700 mb-6 text-center">Predicted Nutrition Breakdown</h3>
                                <p class="text-xs text-center text-gray-500 mb-4">(Note: This is a basic prediction and does not account for ingredient quantities. It is for estimation purposes only.)</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center bg-slate-50 p-6 rounded-2xl border shadow-inner">

                                    <!-- Left Side: Pie Chart for Macros -->
                                    <div class="w-full h-64 flex justify-center items-center">
                                        <canvas id="macro-pie-chart"></canvas>
                                    </div>

                                    <!-- Right Side: Calorie Bar Chart and Details -->
                                    <div class="flex flex-col justify-center">
                                        <h4 class="text-xl font-semibold text-slate-800 text-center mb-3">Total Calories for Full Recipe</h4>
                                        <div class="w-full h-20 mb-4">
                                            <canvas id="calorie-bar-chart"></canvas>
                                        </div>
                                        <div class="grid grid-cols-3 gap-2 text-center">
                                            <div class="bg-blue-100 p-2 rounded-lg">
                                                <span class="text-lg font-bold text-blue-800">{{ round($nutrition['protein']) }}g</span>
                                                <span class="block text-sm font-medium text-blue-600">Protein</span>
                                            </div>
                                            <div class="bg-red-100 p-2 rounded-lg">
                                                <span class="text-lg font-bold text-red-800">{{ round($nutrition['fat']) }}g</span>
                                                <span class="block text-sm font-medium text-red-600">Fat</span>
                                            </div>
                                            <div class="bg-yellow-100 p-2 rounded-lg">
                                                <span class="text-lg font-bold text-yellow-800">{{ round($nutrition['carbs']) }}g</span>
                                                <span class="block text-sm font-medium text-yellow-600">Carbs</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

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
                        <div class="mt-8 text-center" data-html2canvas-ignore>
                            <form action="{{ route('recipe.generate') }}" method="POST" id="regenerate-form" class="inline-block">
                                @csrf
                                <input type="hidden" name="ingredients" value="{{ $previous_ingredients ?? '' }}">

                                @php
                                    $standardCuisines = ['any', 'Italian', 'Asian', 'Mexican', 'Mediterranean', 'Healthy', 'Dessert'];
                                    $isOtherCuisine = !in_array($previous_cuisine ?? 'any', $standardCuisines);
                                @endphp
                                <input type="hidden" name="cuisine_select" value="{{ $isOtherCuisine ? 'other' : ($previous_cuisine ?? 'any') }}">
                                <input type="hidden" name="cuisine_other" value="{{ $isOtherCuisine ? ($previous_cuisine ?? '') : '' }}">
                                <input type="hidden" name="diet_select" value="{{ $isOtherDiet ? 'other' : ($previous_diet ?? 'none') }}">
                                <input type="hidden" name="diet_other" value="{{ $isOtherDiet ? ($previous_diet ?? '') : '' }}">

                                <button type="submit" id="regenerate-button"
                                    class="bg-green-100 text-green-800 font-semibold py-2 px-5 rounded-lg border border-green-200 hover:bg-green-200 hover:border-green-300 transition-all duration-300 flex items-center justify-center mx-auto disabled:opacity-60 relative overflow-hidden">
                                    <!-- Spinner -->
                                    <svg id="regenerate-spinner"
                                        class="hidden animate-spin h-5 w-5 text-green-700 mr-2"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0
                                            0 5.373 0 12h4zm2 5.291A7.962
                                            7.962 0 014 12H0c0 3.042
                                            1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>

                                    <!-- Text + Icon -->
                                    <div id="regenerate-content" class="flex items-center transition-all duration-200">
                                        <svg id="regenerate-icon" xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 4v5h5M20 20v-5h-5M4 20h5v-5M20 4h-5v5" />
                                        </svg>
                                        <span id="regenerate-text">Regenerate Recipe</span>
                                    </div>
                                </button>
                            </form>
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
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center py-6 mt-16 bg-white border-t border-green-100 text-gray-500">
        <p>Built by <span class="font-semibold text-green-700">Phang Jet</span> | Powered by <span class="font-semibold text-green-700">Google Gemini AI</span></p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

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


        const regenerateForm = document.getElementById('regenerate-form');
        const regenerateButton = document.getElementById('regenerate-button');
        const regenerateSpinner = document.getElementById('regenerate-spinner');
        const regenerateIcon = document.getElementById('regenerate-icon');
        const regenerateText = document.getElementById('regenerate-text');

        if (regenerateForm) {
            regenerateForm.addEventListener('submit', function(event) {
                event.preventDefault();

                // Disable button immediately
                regenerateButton.disabled = true;

                // Swap text + icon for spinner
                regenerateIcon.classList.add('hidden');
                regenerateText.textContent = 'Regenerating...';
                regenerateSpinner.classList.remove('hidden');

                // Subtle glowing pulse effect
                regenerateButton.classList.add('animate-pulse', 'bg-green-200');

                // Small delay so user sees animation before reload
                setTimeout(() => {
                    regenerateForm.submit();
                }, 700);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const copyButton = document.getElementById('copy-button');
            if (copyButton) {
                copyButton.addEventListener('click', async () => {
                    const recipeCard = document.getElementById('recipe-card');
                    const copyTextSpan = document.getElementById('copy-text');
                    const recipeName = recipeCard.querySelector('h2').innerText;
                    const description = recipeCard.querySelector('p').innerText;
                    const ingredientsList = Array.from(recipeCard.querySelectorAll('ul li')).map(li => `- ${li.innerText}`);
                    const instructionsList = Array.from(recipeCard.querySelectorAll('ol li')).map(li => `${li.innerText}`);

                    const recipeText = `
${recipeName}
${description}

--- INGREDIENTS ---
${ingredientsList.join('\n')}

--- INSTRUCTIONS ---
${instructionsList.join('\n')}

Generated by SmartChef AI
            `;

                    try {
                        await navigator.clipboard.writeText(recipeText.trim());
                        copyTextSpan.textContent = 'Copied!';
                        copyButton.classList.add('bg-green-100', 'text-green-800');
                        setTimeout(() => {
                            copyTextSpan.textContent = 'Copy';
                            copyButton.classList.remove('bg-green-100', 'text-green-800');
                        }, 2000);
                    } catch (err) {
                        console.error('Failed to copy:', err);
                        copyTextSpan.textContent = 'Error';
                    }
                });
            }

            //CUISINE HYBRID DROPDOWN
            const cuisineSelect = document.getElementById('cuisine-select');
            const cuisineOtherInput = document.getElementById('cuisine-other-input');

            if (cuisineSelect) {
                cuisineSelect.addEventListener('change', function() {
                    // If the selected value is "other"
                    if (this.value === 'other') {
                        // Show the text input
                        cuisineOtherInput.classList.remove('hidden');
                    } else {
                        // Otherwise, make sure the text input is hidden
                        cuisineOtherInput.classList.add('hidden');
                    }
                });
            }

            // HYBRID DIET DROPDOWN
            const dietSelect = document.getElementById('diet-select');
            const dietOtherInput = document.getElementById('diet-other-input');

            if (dietSelect) {
                dietSelect.addEventListener('change', function() {
                    if (this.value === 'other') {
                        dietOtherInput.classList.remove('hidden');
                    } else {
                        dietOtherInput.classList.add('hidden');
                    }
                });
            }

            // --- SCRIPT FOR THE "SAVE AS IMAGE" BUTTON ---
            const saveImageButton = document.getElementById('save-image-button');

            if (saveImageButton) {
                saveImageButton.addEventListener('click', () => {
                    const recipeCard = document.getElementById('recipe-card');
                    const saveImageText = document.getElementById('save-image-text');
                    const originalText = saveImageText.textContent;

                    // Temporarily change button text to show it's working
                    saveImageText.textContent = 'Saving...';
                    saveImageButton.disabled = true;

                    // Use html2canvas to render the recipe card
                    html2canvas(recipeCard, {
                        // Options to improve image quality
                        scale: 2, // Render at 2x resolution
                        useCORS: true, // Important for loading the external Pixabay image
                        backgroundColor: null // Use the actual background
                    }).then(canvas => {
                        // Create a temporary link element
                        const link = document.createElement('a');

                        // Create a filename from the recipe name
                        const recipeName = recipeCard.querySelector('h2').innerText;
                        link.download = `${recipeName.replace(/ /g, '_')}.png`;

                        // Convert the canvas to a PNG image data URL
                        link.href = canvas.toDataURL('image/png');

                        // Trigger the download
                        link.click();

                        // Revert button text
                        saveImageText.textContent = originalText;
                        saveImageButton.disabled = false;
                    }).catch(err => {
                        console.error('oops, something went wrong!', err);
                        saveImageText.textContent = 'Error!';
                        saveImageButton.disabled = false;
                    });
                });
            }

            // --- SCRIPT FOR SCROLL & ANIMATION ---
            const recipeCard = document.getElementById('recipe-card');

            if (recipeCard) {
                // Find the target section
                const outputSection = document.getElementById('recipe-output-section');

                // 1. Smoothly scroll to the recipe card
                outputSection.scrollIntoView({ behavior: 'smooth' });

                // 2. Trigger the fade-in animation
                // We use a small timeout to ensure the scroll happens first
                setTimeout(() => {
                    recipeCard.classList.remove('opacity-0');
                }, 300); // 300ms delay
            }


            // --- SCRIPT FOR THE SHARE BUTTON ---
            const shareButton = document.getElementById('share-button');

            if (shareButton) {
                shareButton.addEventListener('click', async () => {
                    const recipeCard = document.getElementById('recipe-card');
                    const recipeName = recipeCard.querySelector('h2').innerText;
                    const shareText = document.getElementById('share-text');
                    const originalText = shareText.textContent;

                    const shareData = {
                        title: recipeName,
                        text: `Check out this recipe for "${recipeName}" I just made with SmartChef AI!`,
                        url: window.location.href // This shares the current page URL
                    };

                    // Check if the browser supports the Web Share API
                    if (navigator.share) {
                        try {
                            await navigator.share(shareData);
                            // The share dialog was successful
                            shareText.textContent = 'Shared!';
                        } catch (err) {
                            // The user cancelled the share dialog
                            console.log('Share was cancelled.');
                            shareText.textContent = 'Cancelled';
                        }
                    } else {
                        // Fallback for desktop browsers: Copy the URL to the clipboard
                        try {
                            await navigator.clipboard.writeText(window.location.href);
                            shareText.textContent = 'Link Copied!';
                        } catch (err) {
                            console.error('Failed to copy URL: ', err);
                            shareText.textContent = 'Error!';
                        }
                    }

                    // Revert the button text after 2 seconds
                    setTimeout(() => {
                        shareText.textContent = originalText;
                    }, 2000);
                });
            }

            // --- SCRIPT FOR THE NUTRITION CHARTS ---
            const nutritionData = @json($nutrition ?? null); // Safely pass Laravel data to JS

            if (nutritionData) {
                // --- 1. Create the Pie Chart for Macros ---
                const pieCtx = document.getElementById('macro-pie-chart');
                if (pieCtx) {
                    new Chart(pieCtx, {
                        type: 'doughnut', // Doughnut is a pie chart with a hole, looks more modern
                        data: {
                            labels: ['Protein (g)', 'Fat (g)', 'Carbs (g)'],
                            datasets: [{
                                label: 'Macronutrients',
                                data: [
                                    nutritionData.protein,
                                    nutritionData.fat,
                                    nutritionData.carbs
                                ],
                                backgroundColor: [
                                    'rgba(59, 130, 246, 0.7)', // Blue for Protein
                                    'rgba(239, 68, 68, 0.7)',  // Red for Fat
                                    'rgba(234, 179, 8, 0.7)'   // Yellow for Carbs
                                ],
                                borderColor: [
                                    'rgba(59, 130, 246, 1)',
                                    'rgba(239, 68, 68, 1)',
                                    'rgba(234, 179, 8, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Macronutrient Ratio'
                                }
                            }
                        }
                    });
                }

                // --- 2. Create the Bar Chart for Calories ---
                const barCtx = document.getElementById('calorie-bar-chart');
                if (barCtx) {
                    new Chart(barCtx, {
                        type: 'bar',
                        data: {
                            labels: ['Calories'],
                            datasets: [{
                                label: 'Total Calories (kcal)',
                                data: [nutritionData.calories],
                                backgroundColor: ['rgba(22, 163, 74, 0.7)'], // Green
                                borderColor: ['rgba(22, 163, 74, 1)'],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            indexAxis: 'y', // Makes the bar horizontal
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false // Hide legend for a single bar
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            }
        });


    </script>
</body>
</html>
