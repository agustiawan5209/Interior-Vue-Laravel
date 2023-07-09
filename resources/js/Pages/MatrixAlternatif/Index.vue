<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue'
import Pagination from '@/Components/Pagination.vue'
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, defineProps, onMounted, onUpdated } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';
const props = defineProps({
    Alternatif: {
        type: Object,
        default: () => ({})
    },
    prefensi: {
        type: Object,
        default: () => ({})
    },
    bobot: {
        type: Object,
        default: () => ({})
    },
    kriteria: {
        type: Object,
        default: () => ({})
    },
    kode_kriteria: String,
})

const search = ref(null);
const ModalShow = ref(false);
const CountAlternatif = ref(1);
function plusSubAlternatif() {
    CountAlternatif.value++
}

const BobotNIlai = ref([])
const MatrixVar = ref(false);
onMounted(async () => {
    // if(props.kode_kriteria !== null){
    //     NilaiBobot(props.kode_kriteria)
    // }
})

function NilaiBobot(kode) {
    axios({
        method: 'get',
        url: route('BobotAlternatif.matrixAlternatif', { kode: kode }),
        responseType: 'json',
    }).then((res) => {
        BobotNIlai.value.push(res.data);
        console.log(BobotNIlai.value)
    }).catch(err => console.log(err.response))
}
// Cari Nilai Bobot Alternatif
const InputKodeKriteria = ref(props.kode_kriteria);
const kriteriaForm = useForm({
    kode_kriteria: props.kode_kriteria,
});
function cariBobot() {
    kriteriaForm.get(route('BobotAlternatif.index'), {
        onBefore: () => {
            MatrixVar.value = true;
            UpdateAlternatifForm.kode_kriteria = props.kode_kriteria;
            BobotNIlai.value = [];
        },
        onSuccess: () => {
            NilaiBobot(kriteriaForm.kode_kriteria);
            UpdateAlternatifForm.kode_kriteria = props.kode_kriteria;
        },
        onFinish: () => {
            MatrixVar.value = false;
        },
        preserveState: true,
        preserveScroll: true,

    })
}

// Update Matrix Alternatif
const UpdateAlternatifForm = useForm({
    Alternatif1: null,
    nilai_banding: null,
    Alternatif2: null,
    kode_kriteria: props.kode_kriteria,
})

function submitUpdate() {
    UpdateAlternatifForm.kode_kriteria = kriteriaForm.kode_kriteria;

    UpdateAlternatifForm.put(route('BobotAlternatif.update'), {
        preserveScroll: true,
        onBefore: () => {
            MatrixVar.value = true;
            BobotNIlai.value = [];
        },
        onSuccess: () => {
            NilaiBobot(props.kode_kriteria);
        },
        onFinish: () => {
            MatrixVar.value = false;
        },
    })
}
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Alternatif" />
        <template #header>
            <h2 class="font-semibold text-sm md:text-xl leading-tight">Nilai Bobot</h2>

        </template>

        <div class="content main">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border lg:px-10 lg:py-4">
                <!-- Content -->
                <div class="border border-gray-300 rounded-lg ">
                    <div class="relative shadow-md">
                        <div
                            class="flex bg-info flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                            <div class="w-full flex flex-col">
                                <form action="" @submit.prevent="cariBobot" class="grid grid-cols-3 max-w-sm">
                                    <div class="col-span-5 flex flex-row items-center gap-5">
                                        <label for="kriteria"
                                            class="col-span-1 block mb-2 text-sm font-medium text-gray-900 ">Kriteria
                                        </label>
                                        <div class="col-span-3 flex flex-col items-start w-full">
                                            <select id="kriteria" v-model="kriteriaForm.kode_kriteria"
                                                class="col-span-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  px-4">
                                                <option v-for="item in kriteria" :key="item.kode" :value="item.kode"
                                                    :selected="item.kode == kode_kriteria">{{
                                                        item.kode }}</option>
                                            </select>
                                        </div>
                                        <div class=" flex items-start ">
                                            <PrimaryButton type="submit">Cari</PrimaryButton>
                                        </div>
                                    </div>
                                    <InputError class="col-span-2 col-start-1 row-start-2"
                                        v-if="UpdateAlternatifForm.hasErrors"
                                        :message="UpdateAlternatifForm.errors.kode_kriteria" />
                                </form>
                                <form class="grid grid-cols-1 mt-3 "
                                    @submit.prevent="submitUpdate">

                                    <div class="grid grid-cols-1 ">
                                        <div>
                                            <label for="Alternatif1"
                                                class="block mb-2 text-sm text-gray-900 font-semibold">Alternatif
                                                1</label>
                                            <select id="Alternatif2" v-model="UpdateAlternatifForm.Alternatif1"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  px-4">
                                                <option v-for="item in Alternatif" :key="item.kode" :value="item.kode">
                                                    {{ item.kode }}</option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <label for="Nilai Banding"
                                                class="block mb-2 text-sm text-gray-900 font-semibold">Nilai
                                                Banding</label>
                                            <select id="Alternatif2" v-model="UpdateAlternatifForm.nilai_banding"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  px-4">
                                                <option v-for="item in prefensi" :key="item.kode" :value="item.kode">
                                                    {{ item.kode }}</option>
                                            </select>
                                        </div>
                                        <div class="">
                                            <label for="Alternatif2"
                                                class="block mb-2 text-sm text-gray-900 font-semibold">Alternatif
                                                2</label>
                                            <select id="Alternatif2" v-model="UpdateAlternatifForm.Alternatif2"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  px-4">
                                                <option v-for="item in Alternatif" :key="item.kode" :value="item.kode">
                                                    {{ item.kode }}</option>
                                            </select>
                                        </div>
                                        <div class=" flex items-start ">
                                            <PrimaryButton type="submit">Ganti</PrimaryButton>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 col-span-3 row-start-3"
                                        v-if="UpdateAlternatifForm.hasErrors">
                                        <InputError :message="UpdateAlternatifForm.errors.Alternatif1" />
                                        <InputError :message="UpdateAlternatifForm.errors.nilai_banding" />
                                        <InputError :message="UpdateAlternatifForm.errors.Alternatif2" />
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto flex flex-col ">
                        <transition name="page">
                            <table class="w-full text-sm text-left text-gray-400 table-auto border border-separate "
                                :class="MatrixVar ? 'opacity-50' : ''">

                                <thead class="text-xs  uppercase border-b bg-info text-gray-900">

                                    <tr>
                                        <th scope="col" class="p-4">
                                            Kode
                                        </th>
                                        <th scope="col" class="px-4 py-3" v-for="item in Alternatif" :key="item.id">{{
                                            item.kode }}</th>
                                    </tr>
                                </thead>

                                <tbody class="text-xs  uppercase border-b text-gray-900"
                                    :class="MatrixVar ? 'transition-page' : ''" v-for="(place, idx1) in BobotNIlai">

                                    <tr class="border-b-2 border-gray-800" v-for="(row, idx2) in place">
                                        <td> {{ Alternatif[idx2].kode }} </td>
                                        <td v-for="(col, idx3) in row">{{ col }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </transition>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style>
.transition-page {
    transition: opacity 0.5s ease;
}

.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.page-enter-active,
.page-leave-active {
    transition: all .3s;
}

.page-enter,
.page-leave-active {
    opacity: 0;
}

td,
th {
    padding-left: 1rem
        /* 16px */
    ;
    padding-right: 1rem
        /* 16px */
    ;
    padding-top: 0.75rem
        /* 12px */
    ;
    padding-bottom: 0.75rem
        /* 12px */
    ;
    border: 1px solid #d1d0d0;
    font-size: 1rem;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.ping {
    -webkit-animation: ping 0.8s ease-in-out infinite both;
    animation: ping 0.8s ease-in-out infinite both;
}

/* ----------------------------------------------
 * Generated by Animista on 2023-6-11 4:37:48
 * Licensed under FreeBSD License.
 * See http://animista.net/license for more info.
 * w: http://animista.net, t: @cssanimista
 * ---------------------------------------------- */

/**
 * ----------------------------------------
 * animation ping
 * ----------------------------------------
 */
@-webkit-keyframes ping {
    0% {
        -webkit-transform: scale(0.2);
        transform: scale(0.2);
        opacity: 0.8;
    }

    80% {
        -webkit-transform: scale(1.2);
        transform: scale(1.2);
        opacity: 0;
    }

    100% {
        -webkit-transform: scale(2.2);
        transform: scale(2.2);
        opacity: 0;
    }
}

@keyframes ping {
    0% {
        -webkit-transform: scale(0.2);
        transform: scale(0.2);
        opacity: 0.8;
    }

    80% {
        -webkit-transform: scale(1.2);
        transform: scale(1.2);
        opacity: 0;
    }

    100% {
        -webkit-transform: scale(2.2);
        transform: scale(2.2);
        opacity: 0;
    }
}</style>


