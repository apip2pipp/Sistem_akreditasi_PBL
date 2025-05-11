@vite('resources/css/app.css')
<header class="fixed top-0 left-0 w-full z-50">
    <div class="bg-ijobg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center text-ijofont">
                <img src="{{ asset('img/a_logo.png') }}" alt="logo" class="h-12 w-12 mr-2" />

                <span class="font-semibold text-xl ">ACCREDITATION SYSTEM</span>
            </a>

            <div class="flex items-center">
                <nav class="hidden md:flex items-center">
                    <a href="{{ route('home') }}" class="nav-link font-semibold text-ijofont">Home</a>
                    <a href="#" class="nav-link font-semibold text-ijofont">Information</a>
                    <div class="relative group">
                        <a href="#" class="nav-link font-semibold flex items-center text-ijofont">
                            Criteria
                            <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                    </div>
                </nav>

                <a href="#" class="ml-4 bg-ijologin hover:bg-light-accent text-white font-semibold py-2 px-8 rounded-md ">
                    Login
                </a>

                <button class="md:hidden ml-4 text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Spacer to prevent content from hiding behind the fixed header -->
<div class="h-[72px]"></div>

<!-- You may want to add custom CSS in your app.css file -->
<style>
    /* You can add this to your app.css file if needed */
    .fixed-header-shadow {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
</style>

<!-- Optional JavaScript to add shadow on scroll -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.querySelector('header');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 10) {
                header.classList.add('fixed-header-shadow');
            } else {
                header.classList.remove('fixed-header-shadow');
            }
        });
    });
</script>
