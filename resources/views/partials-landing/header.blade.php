@vite('resources/css/app.css')
<header class="fixed top-0 left-0 w-full z-50">
    <div class="bg-ijobg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center text-ijofont">
                <img src="{{ asset('img/a_logo.png') }}" alt="logo" class="h-12 w-12 mr-2" />
                <span class="font-semibold text-xl">ACCREDITATION SYSTEM</span>
            </a>

            <div class="flex items-center">
                <nav class="hidden md:flex items-center">
                    <a href="{{ route('home') }}" class="nav-link font-semibold text-ijofont">Home</a>
                    <a href="#" class="nav-link font-semibold text-ijofont">Information</a>

                    <!-- Dropdown Criteria -->
                    <div class="relative group">
                        <button class="nav-link font-semibold flex items-center text-ijofont focus:outline-none"
                            onclick="toggleDropdown()">
                            Criteria
                            <svg class="ml-1 h-4 w-4 transform transition-transform duration-200" id="dropdown-arrow"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdown-menu"
                            class="absolute left-0 mt-2 w-64 bg-white rounded-md shadow-lg opacity-0 invisible transform scale-95 transition-all duration-200 ease-out z-50">
                            <div class="py-2">
                                <a href="{{ route('criteria.1') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-ijobg hover:text-white transition-colors duration-150">
                                    <div class="font-semibold">Criteria 1</div>

                                </a>
                                <a href="{{ route('criteria.2') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-ijobg hover:text-white transition-colors duration-150">
                                    <div class="font-semibold">Criteria 2</div>

                                </a>
                                <a href="{{ route('criteria.3') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-ijobg hover:text-white transition-colors duration-150">
                                    <div class="font-semibold">Criteria 3</div>

                                </a>
                                <a href="{{ route('criteria.4') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-ijobg hover:text-white transition-colors duration-150">
                                    <div class="font-semibold">Criteria 4</div>

                                </a>
                                <a href="{{ route('criteria.5') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-ijobg hover:text-white transition-colors duration-150">
                                    <div class="font-semibold">Criteria 5</div>

                                </a>
                                <a href="{{ route('criteria.6') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-ijobg hover:text-white transition-colors duration-150">
                                    <div class="font-semibold">Criteria 6</div>

                                </a>
                                <a href="{{ route('criteria.7') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-ijobg hover:text-white transition-colors duration-150">
                                    <div class="font-semibold">Criteria 7</div>

                                </a>
                                <a href="{{ route('criteria.8') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-ijobg hover:text-white transition-colors duration-150">
                                    <div class="font-semibold">Criteria 8</div>

                                </a>
                                <a href="{{ route('criteria.9') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-ijobg hover:text-white transition-colors duration-150">
                                    <div class="font-semibold">Criteria 9</div>

                                </a>
                            </div>
                        </div>
                    </div>
                </nav>

                <a href="{{ route('login') }}"
                    class="ml-4 bg-ijologin hover:bg-light-accent text-white font-semibold py-2 px-8 rounded-md">
                    Login
                </a>

                <!-- Mobile Menu Button -->
                <button class="md:hidden ml-4 text-white" onclick="toggleMobileMenu()">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-ijobg border-t border-green-600">
            <div class="px-4 py-2 space-y-2">
                <a href="{{ route('home') }}" class="block py-2 text-ijofont font-semibold">Home</a>
                <a href="#" class="block py-2 text-ijofont font-semibold">Information</a>

                <!-- Mobile Criteria Dropdown -->
                <div>
                    <button onclick="toggleMobileCriteria()"
                        class="w-full text-left py-2 text-ijofont font-semibold flex items-center justify-between">
                        Criteria
                        <svg class="h-4 w-4 transform transition-transform duration-200" id="mobile-arrow"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div id="mobile-criteria" class="hidden pl-4 space-y-1">
                        <a href="{{ route('criteria.1') }}" class="block py-1 text-sm text-ijofont">Criteria 1</a>
                        <a href="{{ route('criteria.2') }}" class="block py-1 text-sm text-ijofont">Criteria 2</a>
                        <a href="{{ route('criteria.3') }}" class="block py-1 text-sm text-ijofont">Criteria 3</a>
                        <a href="{{ route('criteria.4') }}" class="block py-1 text-sm text-ijofont">Criteria 4</a>
                        <a href="{{ route('criteria.5') }}" class="block py-1 text-sm text-ijofont">Criteria 5</a>
                        <a href="{{ route('criteria.6') }}" class="block py-1 text-sm text-ijofont">Criteria 6</a>
                        <a href="{{ route('criteria.7') }}" class="block py-1 text-sm text-ijofont">Criteria 7</a>
                        <a href="{{ route('criteria.8') }}" class="block py-1 text-sm text-ijofont">Criteria 8</a>
                        <a href="{{ route('criteria.9') }}" class="block py-1 text-sm text-ijofont">Criteria 9</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Spacer to prevent content from hiding behind the fixed header -->
<div class="h-[72px]"></div>

<style>
    .nav-link {
        @apply px-4 py-2 transition-colors duration-150 hover:text-gray-200;
    }

    .fixed-header-shadow {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    /* Dropdown visibility classes */
    .dropdown-visible {
        opacity: 1 !important;
        visibility: visible !important;
        transform: scale(1) !important;
    }
</style>

<script>
    let dropdownTimeout;

    // Desktop dropdown functions
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown-menu');
        const arrow = document.getElementById('dropdown-arrow');

        dropdown.classList.toggle('dropdown-visible');
        arrow.classList.toggle('rotate-180');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown-menu');
        const button = event.target.closest('.relative.group button');

        if (!button && !dropdown.contains(event.target)) {
            dropdown.classList.remove('dropdown-visible');
            document.getElementById('dropdown-arrow').classList.remove('rotate-180');
        }
    });

    // Mobile menu functions
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    }

    function toggleMobileCriteria() {
        const mobileCriteria = document.getElementById('mobile-criteria');
        const mobileArrow = document.getElementById('mobile-arrow');

        mobileCriteria.classList.toggle('hidden');
        mobileArrow.classList.toggle('rotate-180');
    }

    // Header shadow on scroll
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
