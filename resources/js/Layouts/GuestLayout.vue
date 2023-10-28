<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import '../../asset/css/creative-design.css';

import { Link, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;
</script>

<template>
    <teleport to='body'>
        <!-- Page Navbar -->
        <nav id="scrollspy" class="navbar page-navbar navbar-light navbar-expand-md fixed-top" data-spy="affix"
            data-offset-top="20">
            <div class="container">
                <a class="navbar-brand" href="#"><strong class="text-primary">Design</strong> <span
                        class="text-dark">Interior</span></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <Link class="nav-link" href="/">Home</Link>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About Us</a>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" :href="route('Home.kriteria')">Input Kriteria</Link>
                        </li>

                        <li class="nav-item ml-md-4" v-if="user.name == null">
                            <Link class="nav-link btn btn-primary" href="login">Login</Link>
                        </li>
                        <li class="nav-item ml-md-4" v-if="user.name == null">
                            <Link class="nav-link btn btn-primary" href="register">Register</Link>
                        </li>

                        <li class="nav-item ml-md-4" v-else>
                            <Link class="nav-link btn btn-primary" :href="route('logout')" method="post" as="button">Logout</Link>
                        </li>

                    </ul>
                </div>
            </div>
        </nav><!-- End of Page Navbar -->

        <slot/>
    </teleport>
</template>
