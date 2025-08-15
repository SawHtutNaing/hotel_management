<div>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    <div class="relative bg-gray-100 min-h-screen">
        <!-- Hero Section -->
        <div class="relative bg-cover bg-center py-16" style="background-image: url('{{ asset('storage/images/hotel-bg.jpg') }}')">
            <div class="absolute inset-0 bg-black opacity-40"></div> <!-- Overlay for text readability -->
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Hotel Branding SVG -->
                <div class="flex justify-center mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M4 22V2h2v20H4zm14 0V2h2v20h-2zM8 22V10h2v12H8zm6 0V10h2v12h-2zM8 8V6a4 4 0 018 0v2h-2V6a2 2 0 00-4 0v2H8z" />
                        <text x="50%" y="95%" text-anchor="middle" font-size="5" fill="currentColor" font-family="Arial, sans-serif">HOTEL</text>
                    </svg>
                </div>
                <h1 class="text-5xl font-extrabold mb-4 tracking-tight text-white">Hotel Booking System</h1>
                <h1 class="text-5xl font-extrabold mb-4 tracking-tight text-white">Welcome to LuxeStay Hotel</h1>
                <p class="text-lg mb-8 text-gray-100">Experience comfort and luxury with seamless booking at your fingertips.</p>

                <!-- Call-to-Action Buttons -->
                @if (auth()->check())
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('rooms.search') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg shadow-md hover:bg-blue-50 font-medium transition duration-300">Search Rooms</a>
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.room-types') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-700 font-medium transition duration-300">Admin Dashboard</a>
                        @endif
                    </div>
                @else
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('login') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg shadow-md hover:bg-blue-50 font-medium transition duration-300">Login</a>
                        <a href="{{ route('register') }}" class="bg-gray-800 text-white px-6 py-3 rounded-lg shadow-md hover:bg-gray-900 font-medium transition duration-300">Register</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Features Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Why Choose LuxeStay?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Luxurious Rooms</h3>
                    <p class="text-gray-700">Enjoy modern amenities and comfort in our beautifully designed rooms.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Easy Booking</h3>
                    <p class="text-gray-700">Book your stay in just a few clicks with our intuitive system.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">24/7 Support</h3>
                    <p class="text-gray-700">Our team is always ready to assist you with any inquiries.</p>
                </div>
            </div>
        </div>

        <!-- About Us Section -->
        <div class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">About Us</h2>
                <div class="flex flex-col md:flex-row items-center">
                    <div class="md:w-1/2 p-4">
                        <img src="{{ asset('storage/images/about-us.jpg') }}" alt="About Us" class="rounded-lg shadow-md">
                    </div>
                    <div class="md:w-1/2 p-4">
                        <p class="text-gray-700 text-lg">
                            LuxeStay Hotel is dedicated to providing an exceptional guest experience. Our mission is to offer a perfect blend of comfort, luxury, and convenience. From our elegantly designed rooms to our top-notch amenities, every detail is crafted to ensure your stay is memorable.
                        </p>
                        <p class="text-gray-700 text-lg mt-4">
                            Located in the heart of the city, LuxeStay offers easy access to major attractions and business centers. Whether you're here for leisure or business, our professional staff is committed to making your stay seamless and enjoyable.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p>© {{ date('Y') }} LuxeStay Hotel. All rights reserved.</p>
            </div>
        </footer>
    </div>


</div>