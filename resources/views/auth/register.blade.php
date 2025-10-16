<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Klinik</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col justify-between">
        <!-- Header -->
        <header class="bg-blue-600 text-white py-4 shadow-md">
            <div class="container mx-auto px-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Klinik</h1>
                <nav>
                    <a href="/" class="text-white hover:underline mx-2">Home</a>
                    <a href="#about" class="text-white hover:underline mx-2">About</a>
                    <a href="#services" class="text-white hover:underline mx-2">Services</a>
                    <a href="#contact" class="text-white hover:underline mx-2">Contact</a>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-6 py-12">
            <section class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Register</h2>
                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-gray-700">Full Name</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="password" class="block text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Register</button>
                </form>
                <p class="text-center text-sm text-gray-600 mt-4">Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login here</a>.</p>
            </section>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-4">
            <div class="container mx-auto text-center">
                <p>&copy; 2025 Klinik. All rights reserved.</p>
            </div>
        </footer>
    </div>
</body>
</html>
