<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref, defineProps } from 'vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';


const props = defineProps(['alternatif', 'kriteria', 'alternatif_lain'])
const ShowFilter = ref(false)
const LoadPage = ref(false)
const FilterForm = useForm({
    subkriteria: [],
})
function submit() {
    FilterForm.get(route('Home.kriteria'), {
        preserveState: true,
        onBefore: () => {
            LoadPage.value = true;
        },
        onSuccess: () => {
            LoadPage.value = false;
        }
    })
}

// console.log(props.alternatif)
// console.log(props.alternatif_lain)
</script>

<template>
    <GuestLayout>

        <Head title="Kriteria" />

        <div class="container border rounded pb-2 border-primary mt-xl-5">

            <div class="w-full px-4 flex justify-between py-2 items-center mt-xl-5">
                <!-- Text -->
                <div class="block" data-aos="flip-up">
                    <h3
                        class="text-2xl md:text-3xl font-semibold leading-10 sm:leading-none tracking-wide text-base-100 border-b-2 capitalize ">
                      Pencarian Interior
                    </h3>
                </div>
                <div>
                    <button type="button" @click="ShowFilter = !ShowFilter"
                        class="transition-all btn btn-primary row justify-items-center align-items-center">
                        <span class="leading-5 tracking-wide break-words mr-2">Filter</span>

                    </button>
                </div>
            </div>
            <form :class="ShowFilter ? 'flex w-full  px-3 md:px-8 py-4 md:py-12 ' : 'hidden h-0'" id="filterform" class=" "
                @submit.prevent="submit">
                <div class="row px-3 py-2 ">

                    <div class="col-12 input-group-append mt-1" v-for="(item, index) in kriteria" :key="item.id"
                        :index="index">
                        <label :for="item.kode" class="input-group-text">{{
                            item.name
                        }}</label>
                        <select v-model="FilterForm.subkriteria[index]" :name="item.kode" :id="item.kode" v-if="item.name != 'ukuran' && item.name != 'Ukuran'"
                            class="form-control w-100">
                            <option v-for="(opt, idx) in item.sub_kriteria" :key="opt.id"
                                :value="opt.nama">
                                {{ opt.nama }}
                            </option>
                        </select>
                        <input type="text" v-model="FilterForm.subkriteria[index]" :name="item.kode" :id="item.kode" class="form-control" v-else>
                    </div>
                </div>
                <div class=" flex flex-row">
                    <button class="btn btn-primary" type="submit">Cari</button>
                    <button type="reset" class="btn btn-danger">reset</button>
                </div>
            </form>
        </div>
        <br><br><br>
        <div class="container mx-auto mt-10">

            <div class="row " v-if="alternatif.length > 0">
                <h4 class="text-sm-center mb-lg-5">Rekomendasi Interior</h4>
                <div class="col-sm-10 col-md-4 m-auto" v-for="item in alternatif">
                    <div class="testmonial-wrapper">
                        <img v-if="item.detail !== null" :src="item.detail.image_path" :alt="item.nama">
                        <Link :href="route('Home.detail', { nama: item.nama })" class="title text-black mb-3">
                        <h5>{{ item.nama }}</h5>
                        </Link>
                        <p v-if="item.detail !== null" class="text-black">{{ item.detail.deskripsi }}</p>

                    </div>
                </div>
            </div>
            <div class="container" v-else>
                <div class="p-6 py-12 dark:bg-violet-400 border mb-lg-5">
                    <div class="container mx-auto">
                        <div class="flex flex-col lg:flex-row items-center justify-between">
                            <h2 class="text-center text-6xl tracki font-bold">Pencarian Kosong

                            </h2>
                        </div>
                    </div>
                </div>
                <h4 class="text-sm-center mb-lg-5">Rekomendasi Interior lain</h4>
                <div class="row">
                    <div class="col-sm-10 col-md-4 m-auto" v-for="item in alternatif_lain">
                        <div class="testmonial-wrapper">
                            <img v-if="item.detail !== null" :src="item.detail.image_path" :alt="item.nama">
                            <Link :href="route('Home.detail', { nama: item.nama })" class="title text-black mb-3">
                            <h5>{{ item.nama }}</h5>
                            </Link>
                            <p v-if="item.detail !== null" class="text-black">{{ item.detail.deskripsi }}</p>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </GuestLayout></template>
