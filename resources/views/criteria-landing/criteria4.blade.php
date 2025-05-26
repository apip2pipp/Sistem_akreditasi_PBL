{{-- resources/views/criteria/criteria1.blade.php --}}
@extends('layouts.app')

@section('title', 'Criteria 1 - Visi, Misi, Tujuan dan Strategi')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="container mx-auto px-4">

        {{-- Header Section --}}
        <div class="bg-gradient-to-r from-ijobg to-ijologin rounded-t-3xl p-8 text-white relative overflow-hidden">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Assessment Criteria Form</h1>
                </div>
                <div class="bg-ijobg text-white rounded-full w-16 h-16 flex items-center justify-center text-2xl font-bold">
                    4
                </div>
            </div>
        </div>

        {{-- Content Section --}}
        <div class="bg-white rounded-b-3xl shadow-lg p-8">
            {{-- Criteria Description --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Visi, Misi, Tujuan dan Strategi</h2>
                <p class="text-gray-600 mb-6">Berikut data file yang dapat anda unduh/buka</p>
            </div>

            {{-- Document Table --}}
            <div class="overflow-x-auto mb-8">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-ijobg text-white">
                            <th class="px-6 py-4 text-left font-semibold border border-gray-500">No</th>
                            <th class="px-6 py-4 text-left font-semibold border border-gray-500">Title of Document</th>
                            <th class="px-6 py-4 text-left font-semibold border border-gray-500">Link</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 border border-gray-200 text-center">1</td>
                            <td class="px-6 py-4 border border-gray-200">Dokumen Visi Misi Universitas</td>
                            <td class="px-6 py-4 border border-gray-200">
                                <a href="#" class="text-blue-600 hover:text-blue-800 hover:underline transition-colors duration-150">
                                    Download Document
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 border border-gray-200 text-center">2</td>
                            <td class="px-6 py-4 border border-gray-200">Rencana Strategis (Renstra) Institusi</td>
                            <td class="px-6 py-4 border border-gray-200">
                                <a href="#" class="text-blue-600 hover:text-blue-800 hover:underline transition-colors duration-150">
                                    Download Document
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 border border-gray-200 text-center">3</td>
                            <td class="px-6 py-4 border border-gray-200">Dokumen Penetapan Visi Misi oleh Senat</td>
                            <td class="px-6 py-4 border border-gray-200">
                                <a href="#" class="text-blue-600 hover:text-blue-800 hover:underline transition-colors duration-150">
                                    Download Document
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 border border-gray-200 text-center">4</td>
                            <td class="px-6 py-4 border border-gray-200">Laporan Evaluasi Pencapaian Renstra</td>
                            <td class="px-6 py-4 border border-gray-200">
                                <a href="#" class="text-blue-600 hover:text-blue-800 hover:underline transition-colors duration-150">
                                    Download Document
                                </a>
                            </td>
                        </tr>
                        <tr class="border-b hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 border border-gray-200 text-center">5</td>
                            <td class="px-6 py-4 border border-gray-200">Dokumen Sosialisasi Visi Misi kepada Stakeholder</td>
                            <td class="px-6 py-4 border border-gray-200">
                                <a href="#" class="text-blue-600 hover:text-blue-800 hover:underline transition-colors duration-150">
                                    Download Document
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('criteria.3') }}"
                   class="bg-ijobg hover:bg-ijologin text-white font-semibold py-3 px-6 rounded-lg flex items-center transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                   Previous Criteria
                </a>

                <a href="{{ route('criteria.5') }}"
                   class="bg-ijobg hover:bg-ijologin text-white font-semibold py-3 px-6 rounded-lg flex items-center transition-colors duration-200">
                    Next Criteria
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
