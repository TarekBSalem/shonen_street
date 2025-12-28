<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found | Shonen Street</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(102, 126, 234, 0.5); }
            50% { box-shadow: 0 0 40px rgba(102, 126, 234, 0.8); }
        }
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="/assets/logos/logo_header.png" alt="Shonen Street" class="h-16 w-auto mx-auto object-contain">
        </div>

        <!-- Main Error Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header with Gradient -->
            <div class="bg-gradient-to-r from-purple-600 via-blue-600 to-pink-600 p-8 text-center">
                <div class="float-animation inline-block">
                    <svg class="w-32 h-32 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-6xl md:text-8xl font-bold text-white mt-4">404</h1>
                <p class="text-2xl md:text-3xl text-white/90 mt-2 font-semibold">Page Not Found</p>
            </div>

            <!-- Content -->
            <div class="p-8 md:p-12 text-center">
                <div class="mb-8">
                    <p class="text-xl text-gray-700 mb-4">
                        Oops! Looks like this page went on an adventure and got lost.
                    </p>
                    <p class="text-gray-600">
                        The page you're looking for doesn't exist or has been moved to another dimension.
                    </p>
                </div>

                <!-- Suggestions -->
                <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-2xl p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Here's what you can do:</h3>
                    <ul class="text-left space-y-3 max-w-md mx-auto">
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Check the URL for typos</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Go back to the previous page</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Visit our homepage and start fresh</span>
                        </li>
                    </ul>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="javascript:history.back()" 
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-semibold rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Go Back
                    </a>
                    <a href="/" 
                       class="pulse-glow inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 via-blue-600 to-pink-600 text-white font-semibold rounded-xl hover:from-purple-700 hover:via-blue-700 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Back to Home
                    </a>
                </div>

                <!-- Fun Message -->
                <div class="mt-8 text-sm text-gray-500">
                    <p>Error Code: 404 | Lost in the manga universe 📚</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-600">
            <p>&copy; {{ date('Y') }} Shonen Street. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

