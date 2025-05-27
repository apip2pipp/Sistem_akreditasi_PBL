@extends('layouts.app')

@section('content')
    @vite('resources/css/app.css')
    <!-- Hero Section -->
    <section id="home" class="relative bg-cover bg-center h-[1250px]"
        style="background-image: url('{{ asset('img/gedung.png') }}');">
        <div class="absolute inset-0 bg-primary bg-opacity-50"></div>
        <div class="container mx-auto px-4 h-full flex items-center relative z-10">
            <div class="max-w-2xl">
                <div class="relative inline-block mb-20 mt-2">
                    <div class="relative px-4 py-2 text-ijofont font-bold bg-ijobg rounded-md">
                        THE ACREDITATITON
                    </div>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-ijofont mb-6">THIS IS AN ACCREDITATION WEBSITE FOR ACCREDITING
                    CAMPUS, DEPARTMENT OR STUDY PROGRAM</h1>
                <p class="text-ijofont mb-8">You are part of advancing the results for value that we share.</p>
                <a href="https://www.instagram.com/apip.pipp/" target="_blank"
                    class="inline-flex items-center px-6 py-3 text-ijofont bg-ijobg rounded-full hover:bg-opacity-90 transition">
                    Read More
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3">
                        </path>
                    </svg>
                </a>
            </div>

            <!-- Logo Polinema -->
            <div class="absolute right-48 top-[30%] z-20">
                <!-- Pindah lebih dekat ke kanan (right-8) dan turunkan sedikit (top-[30%]) -->
                <img src="{{ asset('img/Polinema.png') }}" alt="University Logo" class="h-56 w-56">
                <!-- Ukuran sedikit diperkecil (h-36 w-36) -->
            </div>

            <!-- Logo JTI -->
            <div class="absolute right-0 top-[46%] z-20">
                <!-- Posisi horizontal sama (right-8), vertikal lebih bawah (top-[55%]) -->
                <img src="{{ asset('img/jti.png') }}" alt="Study Program Logo" class="h-56 w-56">
                <!-- Ukuran sama dan hapus mb-10 -->
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="info"class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Akreditasi -->
                <div class="bg-white p-8 text-center rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
                        <img src="img\Frame18.png">
                    </div>
                    <h3 class="text-xl font-semibold text-primary mb-2">AKREDITASI</h3>
                    <p class="text-gray-600">Assessment of the feasibility and quality of higher education conducted by
                        authorized institutions.</p>
                </div>

                <!-- Score -->
                <div class="bg-white p-8 text-center rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
                        <img src="img\Frame 23.png">
                    </div>
                    <h3 class="text-xl font-semibold text-primary mb-2">SCORE</h3>
                    <p class="text-gray-600">Assessment of the feasibility and quality of higher education conducted by
                        authorized institutions.</p>
                </div>

                <!-- User -->
                <div class="bg-white p-8 text-center rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
                        <img src="img\Frame 21.png">
                    </div>
                    <h3 class="text-xl font-semibold text-primary mb-2">USER</h3>
                    <p class="text-gray-600">University accreditation is usually carried out by institution or bodies that
                        have the authority and authority to assess the quality and feasibility of an educational
                        institution.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Criteria Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <div class="lg:col-span-5">
                    <div class="relative">
                        <img src="{{ asset('img/Component2.png') }}" alt="Students" class="rounded-lg">
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <h2 class="text-3xl font-bold text-primary mb-4">What is the meaning of Kriteria?</h2>
                    <p class="text-gray-600 mb-8">These criteria contain explanations that include setting, implementing,
                        evaluating, controlling, and improvement of Higher Education Standards related to the vision,
                        mission, goals, and strategies for achieving goals (VMTS) of LPPIS.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <!-- Vision -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="flex items-center mb-4">

                                <img src="img\Vision.png" class="">

                                <h3 class="text-xl font-semibold p-4 text-green-800">Vision</h3>
                            </div>

                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Becoming a Leading Study Program</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Sieres Information System</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Both at the National Level</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Also International Level</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Mission -->
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="flex items-center mb-4">

                                <img src="img\Mission.png" class="">

                                <h3 class="text-xl font-semibold p-4 text-green-800">Mission</h3>
                            </div>

                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Implement innovative vocational education</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Develop research</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Carry out community service</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-primary mr-2"></i>
                                    <span>Realizing mutually beneficial cooperation</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="https://siakad.polinema.ac.id/login/index/err/6" target="_blank"
                            class="read-more bg-ijolanding text-white px-4 py-2 rounded inline-flex items-center hover:bg-ijobg">
                            Read More
                            <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 bg-ijobg">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-opacity-10 bg-white p-6 rounded-lg flex items-center">
                    <div class="mr-6">

                        <img src="{{ asset('img/bumi.png') }}" class="w-24 h-20">

                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-white mb-2">Need Any Support For Program Accreditation?</h3>
                        <p class="text-gray-200 mb-4">We provide professional assistance to help your program meet
                            accreditation standards.</p>
                        <a href="https://www.instagram.com/apip.pipp/" target="_blank"
                            class="inline-block bg-white text-primary font-medium py-2 px-4 rounded-md hover:bg-gray-100">Contact
                            Us Now</a>
                    </div>
                </div>

                <div class="bg-opacity-10 bg-white p-6 rounded-lg flex items-center">
                    <div class="mr-6">
                        <img src="img\uang.png" class="w-20 h-20">
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-white mb-2">Are You Ready To Enhance Your Study Program
                            Quality?</h3>
                        <p class="text-gray-200 mb-4">Get a free consultation on how to improve your study program's
                            quality.</p>
                        <a href="https://www.instagram.com/apip.pipp/" target="_blank"
                            class="inline-block bg-white text-primary font-medium py-2 px-4 rounded-md hover:bg-gray-100">Get
                            Started</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('data-target');
                const targetEl = document.getElementById(targetId);

                if (targetEl) {
                    targetEl.scrollIntoView({
                        behavior: 'smooth'
                    });

                    // Hapus hash dari URL jika ada
                    history.replaceState(null, null, ' ');
                }
            });
        });
    });
</script>
