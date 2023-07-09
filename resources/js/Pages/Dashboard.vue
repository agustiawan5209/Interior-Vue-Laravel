<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-sm md:text-xl leading-tight">Dashboard</h2>
        </template>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

            <section class="bg-center bg-no-repeat bg-[url('/assets/imgs/1849.jpg')] bg-gray-700 bg-blend-multiply">
                <div class="px-4 mx-auto max-w-screen-xl text-center py-12 lg:py-32">
                    <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
                        Sistem Pendukung Keputusan</h1>
                    <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">Pemilihan Design Interior
                        Rumah Minimalis</p>
                    <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                        <Link :href="route('Kriteria.index')"
                            class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                            Input Kriteria
                            <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </Link>
                        <a :href="route('Perhitungan.index')"
                            class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                            Hasil
                        </a>
                    </div>
                </div>
            </section>

        </div>
    </AuthenticatedLayout>
</template>
