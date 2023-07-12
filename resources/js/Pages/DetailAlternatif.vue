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
        <div class="grid grid-cols-12 gap-4 justify-items-center  py-4 md:py-12 px-3 md:px-10 mt-5">
            <div class=" col-span-12 md:col-span-5 border w-full">
                <img :src="alternatifId.detail.image_path" alt="gambar alternatifId" style="width:500px;" class="object-cover w-full h-auto">
            </div>
            <div class=" col-span-12 md:col-span-7 border w-full bg-gray-100 relative">
                <div class="flex flex-col">
                    <div class="w-full py-2 md:py-4 border-b-8 border-white">
                        <h1 class="leading-5 text-base md:text-2xl ml-2 bg-primary w-1/3 px-2 rounded-md text-white">{{
                            alternatifId.nama }} </h1>
                        <ul class="list-item px-2 md:px-7 md:space-y-3 pt-3">

                        </ul>
                    </div>

                    <div class="w-full py-2 md:py-4 relative">

                        <h1 class="leading-5 text-base md:text-2xl text-base-100 ml-2 font-semibold">Detail alternatif </h1>
                        <div class="flex flex-1 justify-start px-2 md:px-5">
                            <table class="list-item w-full">
                                <tr class="flex justify-between items-center border-b-2 border-base-100 py-1 md:py-3"
                                    v-for="item in alternatifId.subalternatif">
                                    <td
                                        class="flex flex-row items-center text-left capitalize leading-3 tracking-tight font-medium text-sm md:text-base md:whitespace-nowrap ">
                                        <span> {{ item.kriteria.name }}</span>
                                    </td>
                                    <td
                                        class="text-justify font-light leading-8 tracking-tight text-sm md:text-base md:tracking-normal">
                                        {{ item.sub_kriteria }} </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alternatif Lain -->

    </GuestLayout>
</template>
