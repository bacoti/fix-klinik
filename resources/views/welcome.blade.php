<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Klinik</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col justify-between">
        <!-- Header -->
        <header class="bg-blue-600 text-white py-4 shadow-md">
            <div class="container mx-auto px-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Klinik</h1>
                <nav>
                    <a href="#about" class="text-white hover:underline mx-2">About</a>
                    <a href="#services" class="text-white hover:underline mx-2">Services</a>
                    <a href="#contact" class="text-white hover:underline mx-2">Contact</a>
                    <a href="{{ route('login') }}" class="bg-white text-blue-600 hover:bg-blue-50 rounded px-4 py-2 ml-4">Login</a>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-6 py-12">
            <section class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800">Welcome to Klinik</h2>
                <p class="text-lg text-gray-600 mt-4">Your trusted healthcare partner for all your medical needs.</p>
            </section>

            <section id="about" class="mb-12">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">About Us</h3>
                <p class="text-gray-600 leading-relaxed">Klinik is dedicated to providing top-notch healthcare services to our community. From general consultations to specialized treatments, we are here to ensure your well-being.</p>
            </section>

            <section id="services" class="mb-12">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Our Services</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white shadow-md rounded-lg p-6 text-center">
                        <h4 class="text-xl font-bold text-gray-800">General Consultation</h4>
                        <p class="text-gray-600 mt-2">Comprehensive health check-ups and advice.</p>
                    </div>
                    <div class="bg-white shadow-md rounded-lg p-6 text-center">
                        <h4 class="text-xl font-bold text-gray-800">Pharmacy</h4>
                        <p class="text-gray-600 mt-2">Access to a wide range of medicines and prescriptions.</p>
                    </div>
                    <div class="bg-white shadow-md rounded-lg p-6 text-center">
                        <h4 class="text-xl font-bold text-gray-800">Specialized Treatments</h4>
                        <p class="text-gray-600 mt-2">Expert care for specific medical conditions.</p>
                    </div>
                </div>
            </section>

            <section id="contact" class="text-center">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Get in Touch</h3>
                <p class="text-gray-600 mb-4">Have questions or need assistance? Contact us today!</p>
                <a href="/contact" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">Contact Us</a>
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
