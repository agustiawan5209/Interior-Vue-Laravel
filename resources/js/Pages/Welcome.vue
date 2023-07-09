<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue'

</script>

<template>
    <Head title="Welcome" />
    <GuestLayout>


        <!-- Page Header -->
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/imgs/1849.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h3 style="text-shadow: 4px 2px 1px black;">SISTEM PENDUKUNG KEPUTUSAN</h3>
                        <h5 style="color: #FFD700; text-shadow:4px 2px 1px black;">Pemilihan Design Interior Rumah Minimalis
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Section -->
        <section id="about">
            <!-- Container -->
            <div class="container">
                <!-- About wrapper -->
                <div class="about-wrapper">
                    <div class="after">
                        <h1>Profile</h1>
                    </div>
                    <div class="content">
                        <h5 class="title mb-3">Ahmad Fauzy</h5>
                        <!-- row -->
                        <div class="row">
                            <div class="col">
                                <p><b>SISTEM PENDUKUNG KEPUTUSAN PEMILIHAN DESIGN INTERIOR RUMAH MINIMALIS </b></p>
                                <p>Desain interior akan selalu berkaitan dengan citra yang ingin di ciptakan oleh organisasi
                                    atau individu-individu yang memiliki fungsi ruang untuk menampung aktifitas pengguna
                                    yang mencitrakan keberadaan suasana ruang yang menjadi identitas organisasi, korporasi
                                    maupun diri pemiliknya, kemudian dipersepsi oleh manusia yang mengamatinya menjadi nilai
                                    yang mempengaruhi pembentukan image karakter suatu ruang . </p>
                                <p>Persepsi yang ditimbulkan masing2 individu dalam mengidentifikasi karakter suatu ruang
                                    kadang berbeda satu sama lain yang disebabkan orientasi nilai budaya dan latar belakang
                                    yang berbeda</p>
                            </div>
                            <div class="col">
                                <p>Sistem pendukung keputusan (SPK) merupakan sistem yang mampu memberikan kemampuan
                                    pemecahan masalah dengan kondisi semi terstruktur dan tak terstruktur</p>
                                <p>SPK adalah suatu bentuk Computer Base Information System (CBIS) yang interaktif,
                                    fleksibel, dan secara khusus dikembangkan untuk mendukung penyelesaian masalah dari
                                    manajemen yang tidak terstruktur untuk memperbaiki pembuatan keputusan.</p>
                                <p>SPK biasanya dibangun untuk mendukung solusi atas suatu masalah atau untuk mengevaluasi
                                    suatu peluang. SPK tidak dimaksudkan untuk mengotomatisasikan pengambilan keputusan,
                                    tetapi memberikan perangkat interaktif yang memungkinkan pengambil keputusan untuk
                                    melakukan berbagai analisis menggunakan model-model yang tersedia</p>
                            </div>
                        </div><!-- End of Row -->

                    </div>
                </div><!-- End of About Wrapper -->
            </div> <!-- End of Container-->
        </section><!--End of Section -->



</GuestLayout>
</template>

<style>

</style>
