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
    Alternatif: {
        type: Object,
        default: () => ({})
    }
})

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
            CountAlternatif.value =1;
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
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Alternatif" />
        <template #header>
            <h2 class="font-semibold text-sm md:text-xl leading-tight">Alternatif</h2>

        </template>
        <div class="content main">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border lg:px-10 lg:py-4">
                <div class="border border-gray-300 rounded-lg ">
                    <div class="relative shadow-md">
                        <div
                            class="flex flex-col items-center justify-start p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">

                            <div class="w-max lg:text-right">
                                <Link :href="route('Alternatif.create')">
                                    <PrimaryButton type="button" >Tambah</PrimaryButton>
                                </Link>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto ">
                        <table class="w-full text-sm text-left text-gray-400">
                            <thead class="text-xs  uppercase border-b text-gray-900">
                                <tr>
                                    <th scope="col" class="p-4">
                                        No.
                                    </th>
                                    <th scope="col" class="px-4 py-3">Kode</th>
                                    <th scope="col" class="px-4 py-3">Nama</th>
                                    <th scope="col" class="px-4 py-3">image</th>
                                </tr>
                            </thead>
                            <tbody v-if="Alternatif.data.length > 0">
                                <tr v-for="(item, index) in Alternatif.data" :key="item.id" :index="index"
                                    class="border border-gray-600 hover:bg-gray-200">
                                    <td class="w-4 px-4 py-3 text-center text-gray-900">
                                        {{ (Alternatif.current_page - 1) * Alternatif.per_page + index + 1 }}
                                    </td>
                                    <td class="px-4 py-2 font-medium whitespace-nowrap text-gray-600">
                                        {{ item.kode }}
                                    </td>
                                    <td class="px-4 py-2 font-medium whitespace-nowrap text-gray-600">
                                        <div class="flex items-center">
                                            {{ item.nama }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-2 font-medium whitespace-nowrap text-gray-600">
                                        <img v-if="item.detail !== null" :src="item.detail.image_path" :alt="item.nama" class="w-32 rounded-xl object-cover" >
                                    </td>
                                    <td class="px-4 py-2 font-medium whitespace-nowrap text-gray-600">
                                        <div class="flex items-center justify-center gap-4">
                                            <Link :href="route('Alternatif.destroy', {id: item.id})" method="delete" as="button" class="text-white bg-red-500 px-2 py-2 rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                  </svg>

                                            </Link>
                                            <Link :href="route('Alternatif.show', {slug: item.kode})" method="get" as="button" class="text-white bg-blue-500 px-2 py-2 rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                  </svg>

                                            </Link>
                                            <Link :href="route('Alternatif.edit', {slug: item.kode})" method="get" as="button" class="text-white bg-green-500 px-2 py-2 rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                  </svg>


                                            </Link>
                                         </div>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="10" class="text-center font-semibold py-4">
                                        Maaf Data Kosong
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav class="flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0"
                        aria-label="Table navigation">
                        <Pagination :links="Alternatif.links" />
                    </nav>
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
    font-size: 0.9rem;
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
