@extends('landing')

@section('content')
<style>
  html, body {
    overflow-x: hidden; /* Prevent unwanted scroll */
  }
</style>
<section class="relative bg-gradient-to-br from-yellow-50 via-white to-blue-50 py-16 overflow-hidden">
    <!-- Background design -->
    <div class="absolute -top-20 -left-20 w-72 h-72 bg-yellow-300 rounded-full blur-3xl opacity-30"></div>
    <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-blue-300 rounded-full blur-3xl opacity-30"></div>

    <div class="relative max-w-5xl mx-auto px-6">
        <!-- Heading -->
        <div class="text-center mb-10">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-3">
                📩 Contact <span class="text-yellow-500">Us</span>
            </h1>
            <p class="text-gray-600 text-sm max-w-xl mx-auto">
                Have questions or feedback? We’d love to hear from you!
                Send us a message and our team will get back to you shortly.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Contact Form -->
            <div class="bg-white shadow-md rounded-xl p-6 border border-gray-100 hover:shadow-lg transition">
                <form action="" method="POST" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1">Full Name</label>
                        <input type="text" name="name" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1">Email</label>
                        <input type="email" name="email" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    </div>

                    <!-- Subject -->
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1">Subject</label>
                        <input type="text" name="subject"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                    </div>

                    <!-- Message -->
                    <div>
                        <label class="block text-gray-700 text-sm font-semibold mb-1">Message</label>
                        <textarea name="message" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none"></textarea>
                    </div>

                    <!-- Submit -->
                    <div class="text-right">
                        <button type="submit"
                            class="bg-yellow-500 text-white text-sm font-semibold px-6 py-2 rounded-full hover:bg-yellow-600 transition duration-300 shadow-md hover:shadow-lg">
                             Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="flex flex-col justify-center bg-gradient-to-br from-yellow-400 to-yellow-500 text-white rounded-xl p-6 shadow-lg">
                <h2 class="text-base sm:text-lg font-bold mb-4">📞 Get in Touch</h2>
                <p class="text-sm mb-4 leading-relaxed">
                    Have any inquiries about offers, business partnerships, or support?
                    We’re always happy to assist you!
                </p>

                <div class="space-y-3 text-sm">
                    <div class="flex items-center gap-2">
                        <span>📍</span>
                        <p>Buenos Aires, Argentina</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>📧</span>
                        <p>support@cashcash.com</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>📱</span>
                        <p>+54 11 1234-5678</p>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="mt-6 flex gap-4 justify-center">
                    <a href="#" class="bg-white text-yellow-500 rounded-full w-8 h-8 flex items-center justify-center hover:scale-110 transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="bg-white text-yellow-500 rounded-full w-8 h-8 flex items-center justify-center hover:scale-110 transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="bg-white text-yellow-500 rounded-full w-8 h-8 flex items-center justify-center hover:scale-110 transition">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tagline -->
        <div class="mt-10 text-center text-gray-600 italic text-sm">
            “CashCash Argentina — <span class="text-yellow-500 font-semibold">We’re just a message away.</span>”
        </div>
    </div>
</section>
@endsection
