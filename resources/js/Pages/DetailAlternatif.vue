<script setup>
import { ref, defineProps } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head ,Link} from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps(['alternatifId', 'alternatif']);
</script>
<template>
    <GuestLayout>

        <Head title="Detail" />
        <div class="grid grid-cols-12 gap-4 justify-items-center  py-4 md:py-12 px-3 md:px-10">
            <div class=" col-span-12 md:col-span-5 border w-full">
                <img :src="alternatifId.detail.image_path" alt="gambar alternatifId" class="object-cover w-full h-auto">
            </div>
            <div class=" col-span-12 md:col-span-7 border w-full bg-gray-100 relative">
                <div class="flex flex-col">
                    <div class="w-full py-2 md:py-4 border-b-8 border-white">
                        <h1 class="leading-5 text-base md:text-2xl ml-2 bg-primary w-1/3 px-2 rounded-md text-white">{{
                            alternatifId.nama }} </h1>
                        <ul class="list-item px-2 md:px-7 md:space-y-3 pt-3">
                            <li class="flex flex-row w-full">
                                <dt class=" flex items-center text-left capitalize font-medium text-sm md:text-xl md:w-1/7">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-base-100">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span>Lokasi :</span>
                                </dt>
                                <dl
                                    class="text-justify font-light leading-8 tracking-tight text-sm md:text-lg md:tracking-normal">
                                    {{ alternatifId.lokasi.lokasi }} </dl>
                            </li>
                            <li class="flex flex-row  w-full">
                                <dt class="flex items-center text-left capitalize font-medium text-sm md:text-xl md:w-1/7">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-base-100">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    <span>Alamat :</span>
                                </dt>
                                <dl
                                    class="text-justify font-light leading-8 tracking-tight text-sm md:text-lg md:tracking-normal">
                                    {{ alternatifId.lokasi.alamat }} </dl>
                            </li>
                            <li class="flex flex-col items-start w-full">
                                <dt class="flex items-center text-left capitalize font-medium text-sm md:text-xl md:w-1/6">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-base-100">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5.25 8.25h15m-16.5 7.5h15m-1.8-13.5l-3.9 19.5m-2.1-19.5l-3.9 19.5" />
                                    </svg>
                                    <span>deskripsi :</span>
                                </dt>
                                <dl
                                    class="text-justify ml-4 font-light tracking-tight text-sm md:text-base text-gray-700 md:tracking-normal whitespace-pre-wrap">
                                    {{ alternatifId.lokasi.deskripsi }} Lorem ipsum dolor sit amet, consectetur adipisicing
                                    elit. Fugiat doloremque dicta non consectetur, quidem vitae voluptatibus officiis ex
                                    vero a voluptates aliquam maxime sit laborum atque. Impedit eaque error adipisci!
                                    Nostrum cumque laboriosam nobis corporis ab doloremque optio exercitationem aliquam.
                                    Magnam asperiores autem nulla totam, dolorum perferendis necessitatibus at quisquam
                                    distinctio consequatur placeat nam minima tempora, amet facere ullam voluptate eum odio
                                    voluptates tempore tenetur! Neque nostrum dolore magni, ullam velit natus sed recusandae
                                    quasi quis ad reiciendis illo obcaecati iure, consequatur facilis eaque? Nemo voluptatum
                                    magnam at mollitia commodi, quasi totam libero quas dignissimos a accusantium modi ipsa
                                    nihil. </dl>
                            </li>
                        </ul>
                    </div>

                    <div class="w-full py-2 md:py-4 relative">

                        <h1 class="leading-5 text-base md:text-2xl text-base-100 ml-2 font-semibold">Detail alternatif </h1>
                        <div class="flex flex-1 justify-start px-2 md:px-5">
                            <ul class="list-item w-full">
                                <li class="flex justify-between items-center border-b-2 border-base-100 py-1 md:py-3"
                                    v-for="item in alternatifId.subalternatif">
                                    <dt
                                        class="flex flex-row items-center text-left capitalize leading-3 tracking-tight font-medium text-sm md:text-base md:whitespace-nowrap ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-base-100">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                        <span> {{ item.kriteria.name }}</span>
                                    </dt>
                                    <dl
                                        class="text-justify font-light leading-8 tracking-tight text-sm md:text-base md:tracking-normal">
                                        {{ item.sub_kriteria }} </dl>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alternatif Lain -->

        <h2 class="text-4xl font-extrabold  ml-3">Lokasi Alternatif Lain</h2>
        <div class=" grid grid-cols-12 pb-10 sm:px-5 gap-x-4 gap-y-8 pt-6 border-t-8 border-primary border-b-8">
            <div class="flex flex-col items-start col-span-12 sm:col-span-6 xl:col-span-3 pb-3 shadow-sm shadow-base-100 border-b-8 border-t-8 border-primary rounded-lg relative"
                v-for="(item,idx) in alternatif.data">
                <div class="absolute bg-error w-1/2 mt-2 ml-3 rounded-lg text-left pl-2 text-white tracking-wide" v-if="(idx + 1) < 6">
                    Rekomendasi
                </div>
                <a href="#_" class="flex justify-center w-full">
                    <img class="object-cover w-full h-64 mb-2 overflow-hidden rounded-lg shadow-sm  max-h-auto"
                        :src="item.alternatif.lokasi.full_image_path">
                </a>
                <div class="w-full px-3 space-y-3">
                    <div
                        class="bg-info flex items-center px-3 py-1.5 leading-none rounded-full text-xs font-medium uppercase text-white ">
                        <span>{{ item.alternatif.lokasi.alamat }}</span>
                    </div>
                    <h2 class="text-lg font-bold sm:text-xl md:text-2xl"><a href="#_">{{ item.nama }}</a>
                    </h2>
                    <p class="text-sm text-gray-500">{{ item.alternatif.lokasi.deskripsi }}</p>
                    <Link :href="route('show.detail', { nama: item.nama, slug: item.kode })">
                    <PrimaryButton class="mt-2">Detail</PrimaryButton>
                    </Link>
                </div>
            </div>

        </div>
    </GuestLayout>
</template>
