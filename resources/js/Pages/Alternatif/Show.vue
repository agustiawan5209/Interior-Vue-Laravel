<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue'
import { Head, useForm, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, defineProps } from 'vue';
import Swal from 'sweetalert2';
import Modal from '@/Components/Modal.vue';
import InputError from '@/Components/InputError.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
const props = defineProps({
    alternatif: {
        type: Object,
        default: () => ({})
    }
})
console.log(props.alternatif)
const Addform = useForm({
    kode: null,
    name: null,
    subAlternatif: [],
});
function submit() {
    Addform.post(route('Alternatif.store'), {
        onSuccess: () => {
            ModalShow.value = false;
            Addform.reset();
            CountAlternatif.value = 1;
            Swal.fire("Berhasil");
        },
        onError: (error) => {
            Swal.fire(error);
        }
    })
}

const search = ref(null);
const ModalShow = ref(false);
const CountAlternatif = ref(1);
function plusSubAlternatif() {
    CountAlternatif.value++
}
function back() {
    window.history.back()
 }
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Alternatif" />
        <template #header>
            <h2 class="font-semibold text-sm md:text-xl leading-tight"> Detail {{ alternatif.name }}</h2>

        </template>

        <div class="content main">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border lg:px-10 lg:py-4">
                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                    <ul class="w-full divide-y divide-gray-100">
                        <li class="grid grid-cols-4 px-4 py-3">
                            <PrimaryButton type="button" @click="back">Kembali</PrimaryButton>
                        </li>
                        <li class="grid grid-cols-4 px-4 py-3">
                            <h3 class="border-r-gray-800 border-r font-semibold">Kode alternatif</h3>
                            <p class="px-2 text-lg">{{ alternatif.kode }}</p>
                        </li>
                        <li class="grid grid-cols-4 px-4 py-3">
                            <h3 class="border-r-gray-800 border-r font-semibold">Nama alternatif</h3>
                            <p class="px-2 text-lg">{{ alternatif.nama }}</p>
                        </li>
                    </ul>
                    <hr class="divider"/>
                    <h6 class="px-6 py-2 font-light">Sub alternatif</h6>
                    <hr class="divider"/>
                    <ul class="w-full list-item divide-y-2">
                        <li class="grid grid-cols-4 px-4 py-3" v-for="item in alternatif.subalternatif">
                            <h3 class="border-r-gray-800 border-r font-semibold">{{ item.kriteria.name }}</h3>
                            <p class="px-2 text-lg">{{ item.sub_kriteria }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
