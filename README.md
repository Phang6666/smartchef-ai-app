# 🍲 SmartChef AI - AI-Powered Recipe Generator

**SmartChef AI** is a full-stack web application that transforms user-provided ingredients into creative, delicious recipes using a multi-system AI platform. It features an intelligent backend, a polished user interface, and a custom-built machine learning model for nutritional analysis.

<!-- Optional: Add a link to the live demo once it's deployed -->
**[ ➡️ View Live Demo (Coming Soon!) ]**

---

### 🏛️ System Architecture

This project is built using a **multi-service architecture**, demonstrating the integration of several independent systems:

1.  **Main Web Application (This Repository):** A Laravel/PHP application that handles all user interaction, manages the frontend, and acts as the orchestrator for the various AI services.
2.  **Nutrition Prediction Service:** A separate Python/Flask microservice that hosts a custom-trained machine learning model to provide on-demand nutritional analysis.

The data flow is as follows:

[User] -> [SmartChef AI (Laravel App)]
              |
              +---> [Google Gemini API] (for creative recipe generation)
              |
              +---> [Pixabay API] (for intelligent image searching)
              |
              +---> [Nutrition ML Service (Python)] (for analytical predictions)

---

### ✨ Key Features

- **AI-Powered Recipe Generation:** Leverages the Google Gemini API to generate creative recipes, including descriptions, ingredients, and instructions, all in a structured JSON format.
- **Intelligent Image Search:** A sophisticated, multi-tiered search algorithm that finds the most relevant recipe photo from the Pixabay API, with multiple smart fallbacks and a default image to ensure a great UI.
- **ML-Based Nutrition Prediction:** Integrates with a **separate Python/Flask microservice** that uses a trained Random Forest model to predict nutritional information (calories, protein, fat, carbs) for each recipe.
- **Advanced Personalization:** Users can guide the AI by selecting from predefined cuisine and dietary goals, or by providing their own custom, free-text inputs.
- **Professional User Experience:**
    - A beautiful, modern, and fully responsive UI with custom CSS and animations.
    - A full suite of actions: Regenerate Recipe, Copy to Clipboard, Download as PDF, and Save as Image.
    - Robust error handling and user-friendly validation to handle unexpected inputs and API failures gracefully.

---

### 📸 Screenshots

<!-- Take a great screenshot of your final application and place it here! -->
<!-- To do this: 1. Create a `screenshots` folder in your project. 2. Save your image as `app-screenshot.png` inside it. 3. Uncomment the line below. -->
<!-- ![SmartChef AI Screenshot](screenshots/app-screenshot.png) -->

---

### 🛠️ Tech Stack

- **Backend:** PHP, Laravel
- **Frontend:** HTML, Custom CSS, JavaScript, Chart.js, dom-to-image
- **AI & APIs:**
    - **Recipe Generation:** Google Gemini API
    - **Image Search:** Pixabay API
- **Machine Learning Service:**
    - **Language/Framework:** Python, Flask
    - **Libraries:** scikit-learn, Pandas, joblib
- **Database (for future features):** MySQL (configured)
- **Development Server:** `php artisan serve`

---

### ⚙️ How to Run Locally

This is a multi-service application. You must have **both** the ML service and the Laravel app running at the same time for all features to work.

**Part 1: Set Up the ML Prediction Service**

1.  Clone and set up the ML service repository first.
    ```bash
    # In a new terminal...
    git clone https://github.com/YOUR_USERNAME/smartchef-ai-ml-service.git
    cd smartchef-ai-ml-service
    ```
2.  Follow the setup instructions in that repository's `README.md` file (create venv, install requirements).
3.  Start the Python server. It must be running for the main app to work.
    ```bash
    python app.py
    ```
    The ML service will now be running on `http://127.0.0.1:5001`.

**Part 2: Set Up the Main Laravel App (This Repository)**

1.  Clone this repository in a **separate location**.
    ```bash
    # In a new, separate terminal...
    git clone https://github.com/YOUR_USERNAME/smartchef-ai-app.git
    cd smartchef-ai-app
    ```
2.  Install all dependencies.
    ```bash
    # Install PHP dependencies
    composer install

    # Install JS dependencies
    npm install
    ```
3.  Configure your environment.
    ```bash
    # Copy the environment file
    cp .env.example .env

    # Generate an application key
    php artisan key:generate
    ```
4.  Add your API keys to the `.env` file. You will need:
    - `GEMINI_API_KEY`
    - `PIXABAY_API_KEY`

5.  Run the frontend asset compiler.
    ```bash
    # This will watch for changes
    npm run dev
    ```
6.  In a **third terminal**, run the Laravel development server.
    ```bash
    php artisan serve
    ```
Your main application is now running on `http://127.0.0.1:8000`. You can now open this URL in your browser.

---

### 🎓 What I Learned

This project was a deep dive into building a full-stack, multi-system AI application. Key learnings include:
- Architecting a system with multiple, independent API services (Laravel and Python/Flask).
- The entire machine learning pipeline, from raw data preprocessing with Pandas to training a Random Forest model and serving it via a Flask API.
- Advanced prompt engineering to ensure reliable, structured JSON output from a creative AI.
- The importance of robust, multi-tiered fallback logic when integrating different APIs (as seen in the image search algorithm).
- The critical role of environment configuration (local server issues vs. `php artisan serve`) and dependency management in both PHP and Python ecosystems.