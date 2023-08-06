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
    subKriteria: {
        type: Object,
        default: () => ({})
    },
    Kriteria: {
        type: Object,
        default: () => ({})
    }
})
const Addform = useForm({
    kode: null,
    name: null,
    subAlternatif: [],
    image:null,
    deskripsi: null,
    material:null,
    furnitur: null,
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
</script>

<template>
    <AuthenticatedLayout>

        <Head title="Alternatif" />
        <template #header>
            <h2 class="font-semibold text-sm md:text-xl leading-tight"> Form Alternatif</h2>

        </template>
        <div class="content main">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border lg:px-10 lg:py-4">
                <div class="relative p-4 bg-second-primary rounded-lg shadow sm:p-5">

                    <!-- Content body -->
                    <form action="#" @submit.prevent="submit">
                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                            <!-- <div>
                                <label for="Kode"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode</label>
                                <input type="text" name="Kode" id="Kode" v-model="Addform.kode"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                    placeholder="Type Kode" required="">
                                <InputError :message="Addform.errors.kode" />
                            </div> -->
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Alternatif</label>
                                <input type="text" name="name" id="name" v-model="Addform.name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                    placeholder="name" required="">
                                <InputError :message="Addform.errors.name" />
                            </div>
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gambar Alternatif</label>
                                <input type="file" name="file" id="file" @input="Addform.image = $event.target.files[0]"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                    placeholder="image" required="">
                                <InputError :message="Addform.errors.image" />
                            </div>

                            <div>
                                <label for="material"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Material</label>
                                <textarea name="desk" id="desk" v-model="Addform.material"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                    placeholder="material" required=""></textarea>
                                <InputError :message="Addform.errors.material" />
                            </div>
                            <div>
                                <label for="material"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Furnitur</label>
                                <textarea name="desk" id="desk" v-model="Addform.furnitur"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                    placeholder="furnitur" required=""></textarea>
                                <InputError :message="Addform.errors.furnitur" />
                            </div>
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dekripsi</label>
                                <textarea name="desk" id="desk" v-model="Addform.deskripsi"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 "
                                    placeholder="deskripsi" required=""></textarea>
                                <InputError :message="Addform.errors.deskripsi" />
                            </div>
                        </div>
                        <div class="grid grid-cols-3 mb-5 gap-4">
                            <div class="col-span-1" v-for="(item, ind) in Kriteria" :key="item.id">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ item.name }}</label>
                                <div class="flex flex-col">
                                    <select  :name="item.name" :id="item.name" v-model="Addform.subAlternatif[ind]"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 ">
                                        <option v-for="(opt,idx) in item.sub_kriteria" :key="opt.id" :value="[item.kode,opt.nama]" >
                                            {{ opt.nama }}
                                        </option>
                                    </select>
                                </div>
                                <InputError :message="Addform.errors.subAlternatif" />
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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
            </div>
        </div>

    </AuthenticatedLayout>
</template>
