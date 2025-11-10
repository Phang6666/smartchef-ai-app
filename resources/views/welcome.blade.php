<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartChef AI</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Animated background particles */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.08) 0%, transparent 50%);
            animation: particleFloat 20s ease-in-out infinite;
            pointer-events: none;
            z-index: 1;
        }
        
        @keyframes particleFloat {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
        }
        
        /* Glassmorphism container */
        .glass-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        /* Navbar */
        nav {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        
        .nav-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }
        
        .logo-icon {
            font-size: 2.5rem;
            filter: drop-shadow(0 2px 8px rgba(255, 255, 255, 0.3));
            animation: iconBounce 2s ease-in-out infinite;
        }
        
        @keyframes iconBounce {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-5px) rotate(5deg); }
        }
        
        .nav-link {
            color: white;
            text-decoration: none;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .nav-link:hover::before {
            left: 100%;
        }
        
        .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2);
        }
        
        /* Hero Section */
        .hero {
            text-align: center;
            padding: 5rem 2rem;
            position: relative;
            z-index: 2;
        }
        
        .hero h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 6vw, 5rem);
            font-weight: 900;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            animation: titleFadeIn 1s ease-out;
        }
        
        @keyframes titleFadeIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .hero .highlight {
            background: linear-gradient(135deg, #fff 0%, #f0f0f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            display: inline-block;
        }
        
        .hero .highlight::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, white, transparent);
            animation: underlineSlide 2s ease-in-out infinite;
        }
        
        @keyframes underlineSlide {
            0%, 100% { transform: translateX(-100%); opacity: 0; }
            50% { transform: translateX(0); opacity: 1; }
        }
        
        .hero p {
            color: rgba(255, 255, 255, 0.95);
            font-size: 1.25rem;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.8;
            font-weight: 300;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }
        
        /* Main Content */
        main {
            position: relative;
            z-index: 2;
            padding: 0 2rem 4rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Form Card */
        .form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.5);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .form-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.1) 0%, transparent 70%);
            animation: rotateGradient 10s linear infinite;
        }
        
        @keyframes rotateGradient {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .form-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.4);
        }
        
        .form-group {
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .form-label {
            display: block;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: #2d3748;
            position: relative;
            padding-left: 1.5rem;
        }
        
        .form-label::before {
            content: '✦';
            position: absolute;
            left: 0;
            color: #667eea;
            animation: sparkle 2s ease-in-out infinite;
        }
        
        @keyframes sparkle {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.2); }
        }
        
        .form-input, .form-select {
            width: 100%;
            padding: 1rem 1.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            font-family: 'Inter', sans-serif;
        }
        
        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1), 0 4px 20px rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }
        
        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 1.25rem;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 15px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }
        
        .submit-btn:hover::before {
            left: 100%;
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        }
        
        .submit-btn:active {
            transform: translateY(-1px);
        }
        
        .submit-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        /* Recipe Card */
        .recipe-card {
            background: white;
            border-radius: 40px;
            padding: 3rem;
            margin-top: 4rem;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
            animation: cardSlideUp 0.8s ease-out;
        }
        
        @keyframes cardSlideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .recipe-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #4facfe);
            background-size: 200% 100%;
            animation: gradientSlide 3s linear infinite;
        }
        
        @keyframes gradientSlide {
            to { background-position: 200% 0; }
        }
        
        .recipe-image-container {
            position: relative;
            border-radius: 25px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }
        
        .recipe-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .recipe-image-container:hover .recipe-image {
            transform: scale(1.05);
        }
        
        .recipe-image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
            display: flex;
            align-items: flex-end;
            padding: 2rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .recipe-image-container:hover .recipe-image-overlay {
            opacity: 1;
        }
        
        .recipe-title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 900;
            text-align: center;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            padding-bottom: 1rem;
        }
        
        .recipe-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }
        
        .diet-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            margin-bottom: 1.5rem;
        }
        
        .recipe-description {
            text-align: center;
            color: #4a5568;
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 2rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .disclaimer {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            color: #78350f;
            font-size: 0.95rem;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.2);
        }
        
        /* Details Grid */
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
            padding: 2rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-radius: 25px;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .detail-item {
            background: white;
            padding: 1.5rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .detail-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
        }
        
        .detail-item:hover::before {
            transform: translateX(0);
        }
        
        .detail-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .detail-icon {
            width: 3rem;
            height: 3rem;
            margin: 0 auto 0.75rem;
            color: #667eea;
        }
        
        .detail-label {
            font-size: 0.85rem;
            color: #718096;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }
        
        .detail-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2d3748;
        }
        
        /* Nutrition Section */
        .nutrition-section {
            margin: 3rem 0;
            padding: 2.5rem;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 25px;
            box-shadow: inset 0 2px 15px rgba(0, 0, 0, 0.05);
        }
        
        .nutrition-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            color: #2d3748;
        }
        
        .nutrition-note {
            text-align: center;
            font-size: 0.85rem;
            color: #718096;
            margin-bottom: 2rem;
        }
        
        .nutrition-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: center;
        }
        
        @media (max-width: 768px) {
            .nutrition-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .chart-container {
            background: white;
            padding: 1.5rem;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .macro-values {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .macro-item {
            padding: 1rem;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .macro-item:hover {
            transform: translateY(-3px);
        }
        
        .macro-item.protein { background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); }
        .macro-item.fat { background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); }
        .macro-item.carbs { background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); }
        
        .macro-value {
            font-size: 1.5rem;
            font-weight: 700;
            display: block;
        }
        
        .macro-item.protein .macro-value { color: #1e40af; }
        .macro-item.fat .macro-value { color: #991b1b; }
        .macro-item.carbs .macro-value { color: #92400e; }
        
        .macro-label {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 0.25rem;
            display: block;
        }
        
        .macro-item.protein .macro-label { color: #3b82f6; }
        .macro-item.fat .macro-label { color: #ef4444; }
        .macro-item.carbs .macro-label { color: #eab308; }
        
        /* Ingredients & Instructions */
        .content-section {
            margin: 3rem 0;
        }
        
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .section-title::before {
            content: '';
            width: 8px;
            height: 40px;
            background: linear-gradient(180deg, #667eea, #764ba2);
            border-radius: 4px;
        }
        
        .ingredients-list, .instructions-list {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .ingredients-list li, .instructions-list li {
            padding: 1rem;
            margin-bottom: 0.75rem;
            border-left: 3px solid #667eea;
            background: linear-gradient(90deg, #f7fafc 0%, white 100%);
            border-radius: 0 10px 10px 0;
            transition: all 0.3s ease;
            color: #2d3748;
            line-height: 1.6;
        }
        
        .ingredients-list li:hover, .instructions-list li:hover {
            background: linear-gradient(90deg, #edf2f7 0%, #f7fafc 100%);
            border-left-color: #764ba2;
            transform: translateX(5px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: flex-end;
            margin-bottom: 2rem;
        }
        
        .action-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            border: 2px solid;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }
        
        .action-btn:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .action-btn:active {
            transform: scale(0.95);
        }
        
        .action-btn svg {
            width: 1.25rem;
            height: 1.25rem;
            position: relative;
            z-index: 1;
        }
        
        .action-btn span {
            position: relative;
            z-index: 1;
        }
        
        .btn-share {
            background: linear-gradient(135deg, #c084fc 0%, #a855f7 100%);
            border-color: #9333ea;
            color: white;
        }
        
        .btn-copy {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-color: #047857;
            color: white;
        }
        
        .btn-pdf {
            background: linear-gradient(135deg, #64748b 0%, #475569 100%);
            border-color: #334155;
            color: white;
        }
        
        .btn-image {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-color: #1d4ed8;
            color: white;
        }
        
        .btn-regenerate {
            background: white;
            border-color: #10b981;
            color: #10b981;
            margin: 2rem auto 0;
            display: flex;
            padding: 1rem 2rem;
        }
        
        .btn-regenerate:hover {
            background: #10b981;
            color: white;
        }
        
        /* Footer */
        footer {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem;
            text-align: center;
            color: white;
            margin-top: 4rem;
        }
        
        footer a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            border-bottom: 2px solid rgba(255, 255, 255, 0.5);
            transition: border-color 0.3s ease;
        }
        
        footer a:hover {
            border-bottom-color: white;
        }
        
        /* Error Message */
        .error-message {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-left: 4px solid #dc2626;
            padding: 1.5rem;
            border-radius: 15px;
            margin-top: 2rem;
            color: #7f1d1d;
            display: flex;
            align-items: start;
            gap: 1rem;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.2);
            animation: errorShake 0.5s ease;
        }
        
        @keyframes errorShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        
        /* Loading Spinner */
        .spinner {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-content {
                padding: 1rem;
            }
            
            .logo {
                font-size: 1.5rem;
            }
            
            .hero {
                padding: 3rem 1rem;
            }
            
            .form-card, .recipe-card {
                padding: 2rem;
                border-radius: 20px;
            }
            
            .action-buttons {
                justify-content: center;
            }
        }
        
        /* Hide utility class */
        .hidden {
            display: none !important;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav>
        <div class="nav-content">
            <h1 class="logo">
                <span class="logo-icon">🍲</span>
                <span>SmartChef AI</span>
            </h1>
            <a href="{{ route('home') }}" class="nav-link">Get Started</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <h2>
            Turn Your Leftovers Into A <span class="highlight">Masterpiece!</span>
        </h2>
        <p>
            Enter the ingredients you have, and let SmartChef AI craft a delicious recipe tailored just for you.
        </p>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            <!-- Input Form -->
            <div class="form-card">
                <form action="{{ route('recipe.generate') }}" method="POST" id="recipe-form">
                    @csrf

                    <div class="form-group">
                        <label for="ingredients" class="form-label">Your Ingredients</label>
                        <input type="text" name="ingredients" id="ingredients"
                            class="form-input"
                            placeholder="e.g., chicken breast, tomatoes, rice, onion" required
                            value="{{ $previous_ingredients ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label for="cuisine-select" class="form-label">Cuisine Type (Optional)</label>

                        @php
                            $standardCuisines = ['any', 'Italian', 'Asian', 'Mexican', 'Mediterranean', 'Healthy', 'Dessert'];
                            $isOtherCuisine = isset($previous_cuisine) && !in_array($previous_cuisine, $standardCuisines);
                        @endphp

                        <select name="cuisine_select" id="cuisine-select" class="form-select">
                            <option value="any" {{ ($previous_cuisine ?? 'any') == 'any' ? 'selected' : '' }}>Any</option>
                            <option value="Italian" {{ ($previous_cuisine ?? '') == 'Italian' ? 'selected' : '' }}>Italian</option>
                            <option value="Asian" {{ ($previous_cuisine ?? '') == 'Asian' ? 'selected' : '' }}>Asian</option>
                            <option value="Mexican" {{ ($previous_cuisine ?? '') == 'Mexican' ? 'selected' : '' }}>Mexican</option>
                            <option value="Mediterranean" {{ ($previous_cuisine ?? '') == 'Mediterranean' ? 'selected' : '' }}>Mediterranean</option>
                            <option value="Healthy" {{ ($previous_cuisine ?? '') == 'Healthy' ? 'selected' : '' }}>Healthy</option>
                            <option value="Dessert" {{ ($previous_cuisine ?? '') == 'Dessert' ? 'selected' : '' }}>Dessert</option>
                            <option value="other" {{ $isOtherCuisine ? 'selected' : '' }}>Other...</option>
                        </select>

                        <input type="text" name="cuisine_other" id="cuisine-other-input"
                            class="form-input {{ !$isOtherCuisine ? 'hidden' : '' }}"
                            style="margin-top: 0.75rem;"
                            placeholder="e.g., Spicy Thai, Kid-Friendly, French"
                            value="{{ $isOtherCuisine ? ($previous_cuisine ?? '') : '' }}">
                    </div>

                    <div class="form-group">
                        <label for="diet-select" class="form-label">Dietary Goal (Optional)</label>

                        @php
                            $standardDiets = ['none', 'Low Calorie', 'High Protein', 'Vegetarian', 'Gluten-Free', 'Quick Meal'];
                            $isOtherDiet = isset($previous_diet) && !in_array($previous_diet, $standardDiets);
                        @endphp

                        <select name="diet_select" id="diet-select" class="form-select">
                            <option value="none" {{ ($previous_diet ?? 'none') == 'none' ? 'selected' : '' }}>None</option>
                            <option value="Low Calorie" {{ ($previous_diet ?? '') == 'Low Calorie' ? 'selected' : '' }}>Low Calorie</option>
                            <option value="High Protein" {{ ($previous_diet ?? '') == 'High Protein' ? 'selected' : '' }}>High Protein</option>
                            <option value="Vegetarian" {{ ($previous_diet ?? '') == 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                            <option value="Gluten-Free" {{ ($previous_diet ?? '') == 'Gluten-Free' ? 'selected' : '' }}>Gluten-Free</option>
                            <option value="Quick Meal" {{ ($previous_diet ?? '') == 'Quick Meal' ? 'selected' : '' }}>Quick Meal (under 20 mins)</option>
                            <option value="other" {{ $isOtherDiet ? 'selected' : '' }}>Other...</option>
                        </select>

                        <input type="text" name="diet_other" id="diet-other-input"
                            class="form-input {{ !$isOtherDiet ? 'hidden' : '' }}"
                            style="margin-top: 0.75rem;"
                            placeholder="e.g., Low Carb, Vegan, No Nuts"
                            value="{{ $isOtherDiet ? ($previous_diet ?? '') : '' }}">
                    </div>

                    <button type="submit" id="generate-button" class="submit-btn">
                        <svg id="loading-spinner"
                            class="spinner hidden"
                            style="width: 1.25rem; height: 1.25rem; margin-right: 0.75rem;"
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
                    <div id="recipe-card" class="recipe-card">
                        
                        @if (!empty($imageUrl))
                        <div class="recipe-image-container">
                            <img src="{{ $imageUrl }}" alt="Photo of {{ $recipe['recipeName'] }}" class="recipe-image">
                            <div class="recipe-image-overlay"></div>
                        </div>
                        @endif

                        <h2 class="recipe-title">{{ $recipe['recipeName'] }}</h2>

                        @if (isset($previous_diet) && $previous_diet !== 'none')
                            <div style="text-align: center; margin-bottom: 1.5rem;">
                                <span class="diet-badge">
                                    <span>🎯</span>
                                    <span>Goal: {{ $previous_diet }}</span>
                                </span>
                            </div>
                        @endif

                        <p class="recipe-description">
                            {{ $recipe['description'] }}
                        </p>

                        <div class="disclaimer">
                            <p><strong>⚠️ Please Note:</strong> SmartChef AI is a creative assistant. While it tries its best to follow cuisine and dietary requests, the results are AI-generated and may be creative interpretations. Always use your best judgment when cooking.</p>
                        </div>

                        <div class="action-buttons" data-html2canvas-ignore>
                            <button id="share-button" class="action-btn btn-share">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12s-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.368a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                                </svg>
                                <span id="share-text">Share</span>
                            </button>

                            <button id="copy-button" class="action-btn btn-copy">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span id="copy-text">Copy</span>
                            </button>

                            <form action="{{ route('recipe.download') }}" method="POST" style="display: inline-block;">
                                @csrf
                                <input type="hidden" name="recipe" value="{{ json_encode($recipe) }}">
                                <input type="hidden" name="imageUrl" value="{{ $imageUrl ?? '' }}">
                                <input type="hidden" name="nutrition" value="{{ isset($nutrition) ? json_encode($nutrition) : '' }}">

                                <button type="submit" class="action-btn btn-pdf">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>PDF</span>
                                </button>
                            </form>

                            <button id="save-image-button" class="action-btn btn-image">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span id="save-image-text">Image</span>
                            </button>
                        </div>

                        <div class="details-grid">
                            @php
                                $details = [
                                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'label' => 'Time', 'value' => $recipe['cookingTime']],
                                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>', 'label' => 'Difficulty', 'value' => $recipe['difficulty']],
                                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2h8a2 2 0 002-2v-1a2 2 0 012-2h1.945M7.737 11l-.261-2.61m1.104-5.52l.26-2.609M10.5 7.5l.261-2.61M13.5 7.5l.261-2.61M16.263 11l.261-2.61m1.104-5.52l-.26-2.609M12 21V11"/>', 'label' => 'Cuisine', 'value' => $recipe['cuisine']],
                                    ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>', 'label' => 'Servings', 'value' => $recipe['servings']],
                                ];
                            @endphp

                            @foreach ($details as $detail)
                                <div class="detail-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="detail-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        {!! $detail['icon'] !!}
                                    </svg>
                                    <span class="detail-label">{{ $detail['label'] }}</span>
                                    <span class="detail-value">{{ $detail['value'] }}</span>
                                </div>
                            @endforeach
                        </div>

                        @if (isset($nutrition) && is_array($nutrition))
                            <div class="nutrition-section">
                                <h3 class="nutrition-title">Predicted Nutrition Breakdown</h3>
                                <p class="nutrition-note">(Note: This is a basic prediction and does not account for ingredient quantities. It is for estimation purposes only.)</p>
                                <div class="nutrition-grid">
                                    <div class="chart-container" style="height: 300px;">
                                        <canvas id="macro-pie-chart"></canvas>
                                    </div>

                                    <div>
                                        <h4 style="font-size: 1.25rem; font-weight: 700; text-align: center; margin-bottom: 1rem; color: #2d3748;">Total Calories for Full Recipe</h4>
                                        <div style="text-align: center; margin-bottom: 1.5rem;">
                                            <div style="display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 1rem 2rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);">
                                                <span style="font-size: 2.5rem; font-weight: 700; display: block;">{{ round($nutrition['calories']) }}</span>
                                                <span style="font-size: 0.9rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">kcal</span>
                                            </div>
                                        </div>
                                        <div class="macro-values">
                                            <div class="macro-item protein">
                                                <span class="macro-value">{{ round($nutrition['protein']) }}g</span>
                                                <span class="macro-label">Protein</span>
                                            </div>
                                            <div class="macro-item fat">
                                                <span class="macro-value">{{ round($nutrition['fat']) }}g</span>
                                                <span class="macro-label">Fat</span>
                                            </div>
                                            <div class="macro-item carbs">
                                                <span class="macro-value">{{ round($nutrition['carbs']) }}g</span>
                                                <span class="macro-label">Carbs</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="content-section">
                            <h3 class="section-title">Ingredients</h3>
                            <ul class="ingredients-list" style="list-style: none; padding: 0;">
                                @foreach ($recipe['ingredients'] as $ingredient)
                                    <li>{{ $ingredient }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="content-section">
                            <h3 class="section-title">Instructions</h3>
                            <ol class="instructions-list" style="list-style: none; padding: 0; counter-reset: step-counter;">
                                @foreach ($recipe['instructions'] as $instruction)
                                    <li style="counter-increment: step-counter; position: relative; padding-left: 3rem;">
                                        <span style="position: absolute; left: 1rem; font-weight: 700; color: #667eea; font-size: 1.25rem;">{{ $loop->iteration }}.</span>
                                        {{ $instruction }}
                                    </li>
                                @endforeach
                            </ol>
                        </div>

                        <div style="text-align: center;" data-html2canvas-ignore>
                            <form action="{{ route('recipe.generate') }}" method="POST" id="regenerate-form" style="display: inline-block;">
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

                                <button type="submit" id="regenerate-button" class="action-btn btn-regenerate">
                                    <svg id="regenerate-spinner"
                                        class="spinner hidden"
                                        style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0
                                            0 5.373 0 12h4zm2 5.291A7.962
                                            7.962 0 014 12H0c0 3.042
                                            1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>

                                    <div id="regenerate-content" style="display: flex; align-items: center;">
                                        <svg id="regenerate-icon" xmlns="http://www.w3.org/2000/svg"
                                            style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;" fill="none" viewBox="0 0 24 24"
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

                @if (isset($error) || $errors->any())
                    <div id="error-message" class="error-message">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 1.5rem; height: 1.5rem; flex-shrink: 0;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 19a7 7 0 100-14 7 7 0 000 14z" />
                        </svg>
                        <div>
                            <strong style="font-weight: 700;">An Error Occurred</strong>
                            <span style="display: block; margin-top: 0.25rem;">
                                @if (isset($error))
                                    {{ $error }}
                                @else
                                    @foreach ($errors->all() as $validationError)
                                        {{ $validationError }}
                                    @endforeach
                                @endif
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p style="margin-bottom: 0.5rem;">
            Copyright &copy; {{ date('Y') }} <span style="font-weight: 600;">Phang Jet</span>. All Rights Reserved.
        </p>
        <p>
            Powered by <a href="https://deepmind.google/technologies/gemini/" target="_blank">Google Gemini AI</a> &amp; <a href="https://pixabay.com/" target="_blank">Pixabay</a>
        </p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>

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
                regenerateButton.disabled = true;
                regenerateIcon.classList.add('hidden');
                regenerateText.textContent = 'Regenerating...';
                regenerateSpinner.classList.remove('hidden');
                setTimeout(() => {
                    regenerateForm.submit();
                }, 700);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            const copyButton = document.getElementById('copy-button');
            if (copyButton) {
                copyButton.addEventListener('click', async () => {
                    const copyTextSpan = document.getElementById('copy-text');
                    const recipeName = `{!! html_entity_decode($recipe['recipeName'] ?? '') !!}`;
                    const description = `{!! html_entity_decode($recipe['description'] ?? '') !!}`;
                    const details = [
                        `Time: {{ $recipe['cookingTime'] ?? '' }}`,
                        `Difficulty: {{ $recipe['difficulty'] ?? '' }}`,
                        `Cuisine: {{ $recipe['cuisine'] ?? '' }}`,
                        `Servings: {{ $recipe['servings'] ?? '' }}`
                    ];
                    const ingredientsList = @json($recipe['ingredients'] ?? []);
                    const instructionsList = @json($recipe['instructions'] ?? []);
                    const nutritionData = @json($nutrition ?? null);

                    let recipeText = `RECIPE: ${recipeName}\n\n`;
                    recipeText += `${description}\n\n`;
                    recipeText += `--- DETAILS ---\n`;
                    recipeText += details.join(' | ') + `\n\n`;

                    if (nutritionData) {
                        recipeText += `--- NUTRITION (EST. FOR FULL RECIPE) ---\n`;
                        recipeText += `(Note: This is a basic prediction and does not account for ingredient quantities.)\n\n`;
                        recipeText += `Calories: ${Math.round(nutritionData.calories)} kcal\n`;
                        recipeText += `Protein: ${Math.round(nutritionData.protein)}g\n`;
                        recipeText += `Fat: ${Math.round(nutritionData.fat)}g\n`;
                        recipeText += `Carbs: ${Math.round(nutritionData.carbs)}g\n\n`;
                    }

                    recipeText += `--- INGREDIENTS ---\n`;
                    recipeText += ingredientsList.map(item => `- ${item}`).join('\n');
                    recipeText += `\n\n--- INSTRUCTIONS ---\n`;
                    recipeText += instructionsList.map((item, index) => `${index + 1}. ${item}`).join('\n');
                    recipeText += `\n\n---\nGenerated by SmartChef AI`;

                    try {
                        await navigator.clipboard.writeText(recipeText.trim());
                        copyTextSpan.textContent = 'Copied!';
                        setTimeout(() => {
                            copyTextSpan.textContent = 'Copy';
                        }, 2000);
                    } catch (err) {
                        console.error('Failed to copy:', err);
                        copyTextSpan.textContent = 'Error';
                    }
                });
            }

            const cuisineSelect = document.getElementById('cuisine-select');
            const cuisineOtherInput = document.getElementById('cuisine-other-input');

            if (cuisineSelect) {
                cuisineSelect.addEventListener('change', function() {
                    if (this.value === 'other') {
                        cuisineOtherInput.classList.remove('hidden');
                    } else {
                        cuisineOtherInput.classList.add('hidden');
                    }
                });
            }

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

            const saveImageButton = document.getElementById('save-image-button');

            if (saveImageButton) {
                saveImageButton.addEventListener('click', () => {
                    const recipeCard = document.getElementById('recipe-card');
                    const saveImageText = document.getElementById('save-image-text');
                    const originalText = saveImageText.textContent;

                    saveImageText.textContent = 'Saving...';
                    saveImageButton.disabled = true;

                    domtoimage.toPng(recipeCard, {
                        quality: 1.0,
                        bgcolor: '#ffffff',
                        style: {
                            transform: 'none',
                            webkitTransform: 'none'
                        }
                    }).then(function (dataUrl) {
                        const link = document.createElement('a');
                        const recipeName = recipeCard.querySelector('h2').innerText;
                        link.download = `${recipeName.replace(/ /g, '_')}.png`;
                        link.href = dataUrl;
                        link.click();

                        saveImageText.textContent = originalText;
                        saveImageButton.disabled = false;
                        saveImageButton.style.opacity = '1';
                    })
                    .catch(function (error) {
                        console.error('oops, something went wrong!', error);
                        saveImageText.textContent = 'Error!';
                        saveImageButton.disabled = false;
                        saveImageButton.style.opacity = '1';
                    });
                });
            }

            const recipeCard = document.getElementById('recipe-card');
            const errorBlock = document.getElementById('error-message');

            if (recipeCard) {
                const outputSection = document.getElementById('recipe-output-section');
                outputSection.scrollIntoView({ behavior: 'smooth' });
            } else if (errorBlock) {
                errorBlock.scrollIntoView({ behavior: 'smooth' });
            }

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
                        url: window.location.href
                    };

                    if (navigator.share) {
                        try {
                            await navigator.share(shareData);
                            shareText.textContent = 'Shared!';
                        } catch (err) {
                            console.log('Share was cancelled.');
                            shareText.textContent = 'Cancelled';
                        }
                    } else {
                        try {
                            await navigator.clipboard.writeText(window.location.href);
                            shareText.textContent = 'Link Copied!';
                        } catch (err) {
                            console.error('Failed to copy URL: ', err);
                            shareText.textContent = 'Error!';
                        }
                    }

                    setTimeout(() => {
                        shareText.textContent = originalText;
                    }, 2000);
                });
            }

            const nutritionData = @json($nutrition ?? null);

            if (nutritionData) {
                const pieCtx = document.getElementById('macro-pie-chart');
                if (pieCtx) {
                    new Chart(pieCtx, {
                        type: 'doughnut',
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
                                    'rgba(59, 130, 246, 0.7)',
                                    'rgba(239, 68, 68, 0.7)',
                                    'rgba(234, 179, 8, 0.7)'
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
            }
        });
    </script>
</body>
</html>
