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
    kriteria: {
        type: Object,
        default: () => ({})
    }
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
            CountKriteria.value =1;
            Swal.fire("Berhasil");
        },
        onError: (error) => {
            Swal.fire(error);
        }
    })
}

const search = ref(null);
const ModalShow = ref(false);
const CountKriteria = ref(1);
function plusSubKriteria() {
    CountKriteria.value++
}
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Kriteria" />
        <template #header>
            <h2 class="font-semibold text-sm md:text-xl leading-tight">Kriteria</h2>
            <p class="m-xl-5">Kriteria ini merupakan aspek visual dan keindahan dari interior yang dipilih. Misalnya, desain, warna, gaya, dan tata letak yang menarik. </p>
        </template>

        <div class="content main">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border">
                <div class="border border-gray-300 rounded-lg ">
                    <div class="relative shadow-md">
                        <div
                            class="flex flex-col items-center justify-start p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                            <div class="w-max lg:text-right">
                                <PrimaryButton type="button" @click="ModalShow = true">Tambah</PrimaryButton>
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
                                </tr>
                            </thead>
                            <tbody v-if="kriteria.data.length > 0">
                                <tr v-for="(item, index) in kriteria.data" :key="item.id" :index="index"
                                    class="border border-gray-600 hover:bg-gray-200">
                                    <td class="w-4 px-4 py-3 text-center text-gray-700">
                                        {{ (kriteria.current_page - 1) * kriteria.per_page + index + 1 }}

                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        <span
                                            class=" text-base font-medium px-2 py-0.5 rounded whitespace-nowrap bg-primary-900 text-gray-800">
                                            {{ item.kode }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center font-medium whitespace-nowrap text-gray-600">
                                        <div class="flex items-center">
                                            {{ item.name }}
                                        </div>
                                    </td>
                                    <td >
                                     <div class="flex items-center justify-center gap-4">
                                        <Link :href="route('Kriteria.destroy', {id: item.id})" method="delete" as="button" class="text-white bg-danger px-2 py-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                              </svg>

                                        </Link>
                                        <Link :href="route('Kriteria.show', {slug: item.kode})" method="get" as="button" class="text-white bg-info px-2 py-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
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
                        <Pagination :links="kriteria.links" />
                    </nav>
                </div>
            </div>
        </div>

        <Modal :show="ModalShow">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 ">
                        Tambah Kriteria
                    </h3>
                    <button type="button" @click="ModalShow = false"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center "
                        data-modal-toggle="defaultModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="#" @submit.prevent="submit">
                    <div class="grid gap-4 mb-4 grid-cols-1">
                        <div>
                            <label for="Kode"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Kode</label>
                            <input type="text" name="Kode" id="Kode" v-model="Addform.kode"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="Type Kode" required="">
                            <InputError :message="Addform.errors.kode" />
                        </div>
                        <div>
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 ">name</label>
                            <input type="text" name="name" id="name" v-model="Addform.name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                placeholder="name" required="">
                            <InputError :message="Addform.errors.name" />
                        </div>
                        <div class="flex items-center w-full gap-4">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Sub Kriteria</label>
                            <div class="flex flex-col">
                                <input type="text" v-for="(item,index) in CountKriteria" :key="item" :index="index" name="name" id="name" v-model="Addform.subkriteria[index]"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                    placeholder="name" required="">
                            </div>
                            <InputError :message="Addform.errors.name" />
                            <PrimaryButton type='button' class="bg-green-700 hover:bg-green-600" @click="CountKriteria++"><kbd class="bg-transparent">+</kbd></PrimaryButton>
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">
                        <svg class="mr-1 -ml-1 w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Tambah
                    </button>
                </form>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
