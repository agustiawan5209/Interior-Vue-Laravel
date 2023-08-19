<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue'
import Pagination from '@/Components/Pagination.vue'
import { Head, useForm, Link,router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, defineProps, onMounted, onUpdated } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';
const props = defineProps({
    kriteria: {
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
})

const Addform = useForm({
    kode: null,
    name: null,
    subkriteria: [],
});
function submit() {
    Addform.post(route('Kriteria.store'), {
        onSuccess: () => {
            ModalShow.value = false;
            Addform.reset();
            CountKriteria.value = 1;
            Swal.fire("Berhasil");
        },
        onError: (error) => {
            Swal.fire(error);
        },

    })
}

const search = ref(null);
const ModalShow = ref(false);
const CountKriteria = ref(1);
function plusSubKriteria() {
    CountKriteria.value++
}

const BobotNIlai = ref([])

onMounted(async () => {
    axios({
        method: 'get',
        url: route('BobotKriteria.matrixKriteria'),
        responseType: 'json',
    }).then((res) => {
        BobotNIlai.value.push(res.data);
    }).catch(err => console.log(err.response))
})
const UpdateKriteriaForm = useForm({
    kriteria1: null,
    nilai_banding: null,
    kriteria2: null,
})

function submitUpdate(){
    UpdateKriteriaForm.put(route('BobotKriteria.update'), {
        preserveScroll:true,
        preserveState:true,
        onSuccess:()=>{
            router.visit(route('BobotKriteria.index'))
        }
    })
}
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Kriteria" />
        <template #header>
            <h2 class="font-semibold text-sm md:text-xl leading-tight">Nilai Bobot</h2>
            <p class="text-gray-100 text-sm">Halaman ini berfungsi untuk membandingkan hasil dari setiap bobot Kriteria yang digunakan sebagai bobot yang akan digunakan untuk memilih alternatif/interior terbaik berdasarkan kriteria yang ada.</p>
        </template>

        <div class="content main">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border lg:px-10 lg:py-4">
                <!-- Content -->
                <div class="border border-gray-300 rounded-lg ">
                    <div class="relative shadow-md">
                        <div
                            class="flex bg-info flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                            <div class="w-full">
                                <form class="grid grid-cols-1" @submit.prevent="submitUpdate">
                                    <div>
                                        <label for="kriteria1"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kriteria
                                            1</label>
                                        <select id="kriteria1" v-model="UpdateKriteriaForm.kriteria1"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  px-4">
                                            <option v-for="item in kriteria" :key="item.kode" :value="item.kode">{{
                                                item.kode }}</option>
                                        </select>
                                        <InputError :message="UpdateKriteriaForm.errors.kriteria1" />
                                    </div>
                                    <div>
                                        <label for="prefensi"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nilai
                                            Prefensi</label>
                                        <select id="prefensi" v-model="UpdateKriteriaForm.nilai_banding"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  px-4">
                                            <option v-for="item in prefensi" :key="item.id" :value="item.kode">{{
                                                item.kode }}-{{ item.nama }}</option>
                                        </select>
                                        <InputError :message="UpdateKriteriaForm.errors.nilai_banding" />

                                    </div>
                                    <div>
                                        <label for="kriteria2"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kriteria
                                            2</label>
                                        <select id="kriteria2" v-model="UpdateKriteriaForm.kriteria2"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  px-4">
                                            <option v-for="item in kriteria" :key="item.kode" :value="item.kode">{{
                                                item.kode }}</option>

                                        </select>
                                        <InputError :message="UpdateKriteriaForm.errors.kriteria2" />

                                    </div>
                                    <div class=" flex items-end">
                                        <PrimaryButton type="submit">Cari</PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto flex ">
                        <table class="w-full text-sm text-left text-gray-400 table-auto border border-separate">

                            <thead class="text-xs  uppercase border-b text-gray-900 bg-info">

                                <tr>
                                    <th scope="col" class="p-4">
                                        Kode
                                    </th>
                                    <th scope="col" class="px-4 py-3" v-for="item in kriteria" :key="item.id">{{
                                        item.kode }}</th>
                                </tr>
                            </thead>

                            <tbody class="text-xs  uppercase border-b text-gray-900"
                                v-for="(place, idx1) in BobotNIlai">

                                <tr class="border-b-2 border-gray-800" v-for="(row, idx2) in place">
                                    <td> {{ kriteria[idx2].kode }} </td>
                                    <td v-for="(col, idx3) in row">{{ col }}</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<style>
td ,th{
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
    border:1px solid #d1d0d0;
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
</style>
