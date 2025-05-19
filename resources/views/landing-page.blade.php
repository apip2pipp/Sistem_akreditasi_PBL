@extends('layouts.app')

@section('content')
@vite('resources/css/app.css')
<!-- Hero Section -->
<section class="relative bg-cover bg-center h-[1250px]" style="background-image: url('{{ asset('img/gedung.png') }}');">
    <div class="absolute inset-0 bg-primary bg-opacity-50"></div>
    <div class="container mx-auto px-4 h-full flex items-center relative z-10">
        <div class="max-w-2xl">
            <div class="relative inline-block mb-20 mt-2">
  <div class="relative px-4 py-2 text-ijofont font-bold bg-ijobg rounded-md">
    THE ACREDITATION
  </div>
</div>
            <h1 class="text-4xl md:text-5xl font-bold text-ijofont mb-6">THIS IS AN ACCREDITATION WEBSITE FOR ACCREDITING CAMPUS, DEPARTMENT OR STUDY PROGRAM</h1>
            <p class="text-ijofont mb-8">You are part of advancing the results for value that we share.</p>
            <a href="#" class="read-more text-ijofont  bg-ijobg ">
                Read More
                <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
        <div class="hidden md:flex absolute right-10 bottom-0 space-x-4">
            <img src="{{ asset('images/university-logo.png') }}" alt="University Logo" class="h-32 w-32 rounded-lg">
            <img src="{{ asset('images/accreditation-logo.png') }}" alt="Accreditation Logo" class="h-32 w-32 rounded-lg">
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Akreditasi -->
            <div class="bg-white p-8 text-center rounded-lg shadow-md">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path d="M12 14l6.16-3.422a12 12 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12 12 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-primary mb-2">AKREDITASI</h3>
                <p class="text-gray-600">Assessment of the feasibility and quality of higher education conducted by authorized institutions.</p>
            </div>

            <!-- Score -->
            <div class="bg-white p-8 text-center rounded-lg shadow-md">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-primary mb-2">SCORE</h3>
                <p class="text-gray-600">Assessment of the feasibility and quality of higher education conducted by authorized institutions.</p>
            </div>

            <!-- User -->
            <div class="bg-white p-8 text-center rounded-lg shadow-md">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-green-100 mb-6">
                    <svg class="h-8 w-8 text-primary" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-primary mb-2">USER</h3>
                <p class="text-gray-600">University accreditation is usually carried out by institution or bodies that have the authority and authority to assess the quality and feasibility of an educational institution.</p>
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
                    <div class="bg-primary text-white p-4 absolute top-10 right-10 z-10">
                        <div class="text-4xl font-bold">27</div>
                        <div class="text-sm">January 1979</div>
                    </div>
                    <img src="{{ asset('images/classroom.jpg') }}" alt="Classroom" class="rounded-lg shadow-lg mb-6">
                    <img src="{{ asset('images/students.jpg') }}" alt="Students" class="rounded-lg shadow-lg">
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2">
                        <img src="{{ asset('images/accreditation-logo-large.png') }}" alt="Accreditation Logo" class="h-24">
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7">
                <h2 class="text-3xl font-bold text-primary mb-4">What is the meaning of Kriteria?</h2>
                <p class="text-gray-600 mb-8">These criteria contain explanations that include setting, implementing, evaluating, controlling, and improvement of Higher Education Standards related to the vision, mission, goals, and strategies for achieving goals (VMTS) of LPPIS.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Vision -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <svg class="h-6 w-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold">Vision</h3>
                        </div>

                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>Menjadi Program Studi Unggulan</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>Sistem Informasi Sieres</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>Baik di Tingkat Nasional</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>Maupun Internasional</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Mission -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <svg class="h-6 w-6 text-primary" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 22H5a3 3 0 01-3-3V3a1 1 0 011-1h14a1 1 0 011 1v12h4v4a3 3 0 01-3 3zm-1-5v2a1 1 0 002 0v-2h-2zm-2-2h-8v2h8v-2zm0-4h-8v2h8V11zm0-4h-8v2h8V7zm-8-4v2h8V3H8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold">Mission</h3>
                        </div>

                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>Implement innovative vocational education</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>Mengembangkan penelitian</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>Melaksanakan pengabdian masyarakat</span>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-primary mr-2"></i>
                                <span>Mewujudkan kerjasama yang saling menguntungkan</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="text-center">
                    <a href="#" class="read-more">
                        Read More
                        <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
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
                    <div class="bg-light-accent p-4 rounded-full">
                        <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 22H5a3 3 0 01-3-3V3a1 1 0 011-1h14a1 1 0 011 1v12h4v4a3 3 0 01-3 3zm-1-5v2a1 1 0 002 0v-2h-2zm-2-2h-8v2h8v-2zm0-4h-8v2h8V11zm0-4h-8v2h8V7zm-8-4v2h8V3H8z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white mb-2">Need Any Support For Program Accreditation?</h3>
                    <p class="text-gray-200 mb-4">We provide professional assistance to help your program meet accreditation standards.</p>
                    <a href="#" class="inline-block bg-white text-primary font-medium py-2 px-4 rounded-md hover:bg-gray-100">Contact Us Now</a>
                </div>
            </div>

            <div class="bg-opacity-10 bg-white p-6 rounded-lg flex items-center">
                <div class="mr-6">
                    <div class="bg-light-accent p-4 rounded-full">
                        <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white mb-2">Are You Ready To Enhance Your Study Program Quality?</h3>
                    <p class="text-gray-200 mb-4">Get a free consultation on how to improve your study program's quality.</p>
                    <a href="#" class="inline-block bg-white text-primary font-medium py-2 px-4 rounded-md hover:bg-gray-100">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
