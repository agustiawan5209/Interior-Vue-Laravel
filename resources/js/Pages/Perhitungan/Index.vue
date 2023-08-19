<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';

const props = defineProps({
    kriteria: {
        type: Object,
        default: () => ({})
    },
    matrixkriteria: {
        type: Object,
        default: () => ({})
    },
    bobotkriteria: {
        type: Object,
        default: () => ({})
    },
    BobotPrioritasKriteria: {
        type: Object,
        default: () => ({})
    },
    matrixBobotKriteria: {
        type: Object,
        default: () => ({})
    },
    MatrixKonsistensiKriteria: {
        type: Object,
        default: () => ({})
    },
    KonsistensiKriteria: {
        type: Object,
        default: () => ({})
    },
    Consistensi_index: {
        type: Object,
        default: () => ({})
    },
    Consistensi_Ratio: {
        type: Object,
        default: () => ({})
    },
    Ratio_index: {
        type: Object,
        default: () => ({})
    },
    Konsistensi_kriteria: {
        type: Object,
        default: () => ({})
    },

    // Alterntif
    alternatif: {
        type: Object,
        default: () => ({})
    },
    alternatif_Matrix: {
        type: Object,
        default: () => ({})
    },
    AlternatifBobot: {
        type: Object,
        default: () => ({})
    },
    matrixBobotAlternatif: {
        type: Object,
        default: () => ({})
    },
    BobotPrioritasAlternatif: {
        type: Object,
        default: () => ({})
    },
    hasil_AHP: {
        type: Object,
        default: () => ({})
    },

})

function parseJSON(value) {
    if (value !== null) {
        var hasil = JSON.parse(value);
        return JSON.parse(value)
    } else {
        return value;
    }
}
function ar(ar = Array){
return ar
}
function parseArray(value, array) {
    if (value !== null) {
        var hasil = JSON.parse(value);
        return hasil
    } else {
        return value;
    }
}
const LoadPage = ref(false);
const generateForm = useForm({});
function generate() {
    generateForm.post(route('Perhitungan.generateKriteriaMatrix'), {
        onBefore: () => {
            LoadPage.value = true;
        },
        onFinish: () => {
            LoadPage.value = false;
        },
        preserveState: true,
        preserveScroll:true,
    })
}

const IndexRatio = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.46, 1.49, 1.51, 1.48, 1.56, 1.57, 1.59];
</script>
<template>
    <AuthenticatedLayout>

        <Head title="Perhitungan" />
        <template #header>
            <h2 class="font-semibold text-sm md:text-xl leading-tight">Perhitungan Akhir AHP <i>(Analytical Hierarchy
                    Process)</i></h2>
                    <p class="text-gray-100 text-sm">Pada Halaman Ini Akan menampilkan hasil dari perhitungan AHP <i>(Analytical Hierarchy
                        Process)</i> untuk kriteria dan alternatif sehingga dapat ditentukan bahwa bobot alternatif/interior mana yang terbaik.</p>
        </template>

        <div class="loading-page top-0 fixed w-full h-full z-100 bg-gray-500 opacity-60 flex items-center justify-center"
            v-if="LoadPage">
            <div class="lds-roller ">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>

        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border lg:px-10 lg:py-4">
            <div class="overflow-x-auto flex flex-col gap-4">
                <div class="w-full">
                    <table class="w-full text-sm text-left text-gray-400 table-auto border border-separate">
                        <caption class="w-full text-center text-lg py-2 text-gray-800 font-bold">
                            Mengukur Konsistensi Kriteria
                        </caption>
                        <tr>
                            <td>
                                <PrimaryButton class="button" @click="generate">JalanKan Perhitungan</PrimaryButton>

                            </td>
                        </tr>
                    </table>
                </div>
                <div class="w-full">
                    <table class="w-full text-sm text-left text-gray-400 table-auto border border-separate">
                        <caption class="border text-justify">
                            <h3
                                class="bg-second-primary w-full text-center text-white text-base md:text-lg py-2 font-bold border-b">
                                Matriks Perbandingan Kriteria
                            </h3>
                            <p class="text-gray-500 px-2 md:px-4 text-xs md:text-sm">Pertama-tama menyusun hirarki
                                dimana diawali dengan tujuan, kriteria dan
                                alternatif-alternatif lokasi pada tingkat paling bawah. Selanjutnya menetapkan
                                perbandingan berpasangan antara kriteria-kriteria dalam bentuk matrik. Nilai
                                diagonal matrik untuk perbandingan suatu elemen dengan elemen itu sendiri diisi
                                dengan bilangan (1) sedangkan isi nilai perbandingan antara (1) sampai dengan (9)
                                kebalikannya, kemudian dijumlahkan perkolom. Data matrik tersebut seperti terlihat
                                pada tabel berikut.</p>
                        </caption>
                        <thead class="text-xs  uppercase border-b text-gray-900">
                            <tr>
                                <th scope="col" class="p-4">
                                    Kode
                                </th>
                                <th scope="col" class="px-4 py-3" v-for="item in kriteria" :key="item.id">{{
                                    item.kode }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs border-b text-gray-900" v-if="matrixkriteria !== null">
                            <tr v-for="(row, idx1) in parseJSON(matrixkriteria.data)">
                                <td> {{ kriteria[idx1].kode }} </td>

                                <td v-for="(col, idx3) in row">
                                    {{ col }}
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah</td>
                                <td v-for="row in parseJSON(bobotkriteria.data)">
                                    {{ row }}
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

                <!--  -->
                <div class="w-full">
                    <table class="w-full text-sm text-left text-gray-400 table-auto border border-separate">
                        <caption class="border text-justify">
                            <h3
                                class="bg-second-primary w-full text-center text-base md:text-lg py-2 text-white font-bold border-b">
                                Matriks Bobot Prioritas Kriteria
                            </h3>
                            <p class="text-gray-500  px-2 md:px-4 text-xs md:text-sm">
                                Setelah terbentuk matrik perbandingan maka dilihat bobot prioritas untuk
                                perbandingan kriteria. Dengan cara membagi isi matriks perbandingan dengan jumlah
                                kolom yang bersesuaian, kemudian menjumlahkan perbaris setelah itu hasil penjumlahan
                                dibagi dengan banyaknya kriteria sehingga ditemukan bobot prioritas seperti terlihat
                                pada berikut.
                            </p>
                        </caption>
                        <thead class="text-xs  uppercase border-b text-gray-900">
                            <tr>
                                <th scope="col" class="p-4">
                                    Kode
                                </th>
                                <th scope="col" class="px-4 py-3" v-for="item in kriteria" :key="item.id">{{
                                    item.kode }}</th>
                                <th>Bobot Prioritas</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs border-b text-gray-900" v-if="matrixBobotKriteria !== null">
                            <tr v-for="(row, idx1) in parseJSON(matrixBobotKriteria.data)">
                                <td> {{ kriteria[idx1].kode }} </td>

                                <td v-for="(col, idx3) in row">
                                    {{ col }}
                                </td>
                                <td>
                                    {{ parseJSON(BobotPrioritasKriteria.data)[idx1] }}
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <!--  -->
                <div class="w-full">
                    <table class="w-full text-sm text-left text-gray-400 table-auto border border-separate">
                        <caption class="border text-justify">
                            <h3
                                class="bg-second-primary w-full text-center text-base md:text-lg py-2 text-white font-bold border-b">
                                Matriks Konsistensi Kriteria
                            </h3>
                            <p class="text-gray-500 px-2 md:px-4 text-xs md:text-sm">
                                Untuk mengetahui konsisten matriks perbandingan dilakukan perkalian seluruh isi
                                kolom matriks A perbandingan dengan bobot prioritas kriteria A, isi kolom B matriks
                                perbandingan dengan bobot prioritas kriteria B dan seterusnya. Kemudian dijumlahkan
                                setiap barisnya dan dibagi penjumlahan baris dengan bobot prioritas bersesuaian
                                seperti terlihat pada tabel berikut.
                            </p>
                        </caption>
                        <thead class="text-xs  uppercase border-b text-gray-900">
                            <tr>
                                <th scope="col" class="p-4">
                                    Kode
                                </th>
                                <th scope="col" class="px-4 py-3" v-for="item in kriteria" :key="item.id">{{
                                    item.kode }}</th>
                                <th>CM</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs border-b text-gray-900" v-if="MatrixKonsistensiKriteria !== null">
                            <tr v-for="(row, idx1) in parseJSON(MatrixKonsistensiKriteria.data)">
                                <td> {{ kriteria[idx1].kode }} </td>

                                <td v-for="(col, idx3) in row">
                                    {{ col }}
                                </td>
                                <td> {{ parseJSON(KonsistensiKriteria.data)[idx1] }} </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <!--  -->
                <div class="w-full">
                    <table class="w-full text-sm text-left text-gray-400 table-auto border border-separate">
                        <caption class="border text-justify">
                            <h3
                                class="bg-second-primary w-full text-center text-base md:text-lg py-2 text-white font-bold border-b">
                                tabel ratio index berdasarkan ordo matriks.
                            </h3>
                            <p class="text-gray-500 px-2 md:px-4 text-xs md:text-sm">
                                Untuk mengetahui konsisten matriks perbandingan dilakukan perkalian seluruh isi
                                kolom matriks A perbandingan dengan bobot prioritas kriteria A, isi kolom B matriks
                                perbandingan dengan bobot prioritas kriteria B dan seterusnya. Kemudian dijumlahkan
                                setiap barisnya dan dibagi penjumlahan baris dengan bobot prioritas bersesuaian
                                seperti terlihat pada tabel berikut.
                            </p>
                        </caption>
                        <thead class="text-xs  uppercase border-b text-gray-900">
                            <tr>
                                <th scope="col" class="p-4">
                                    Ordo Matrix
                                </th>
                                <th v-for="(om, idx) in IndexRatio">{{ idx + 1 }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs border-b text-gray-900"
                            v-if="Consistensi_index !== null && Consistensi_Ratio !== null">
                            <tr>
                                <th>Ratio Index</th>
                                <th v-for="(om,ind) in IndexRatio" :class="om == Ratio_index.data ? 'text-red-500' : ''">
                                    {{ om }}</th>

                            </tr>
                            <tr>
                                <td colspan="3">Consistensi Index</td>
                                <td colspan="5">{{ Consistensi_index.data }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Ratio Index</td>
                                <td colspan="5">{{ Ratio_index.data }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Consistensi Ratio</td>
                                <td colspan="5">{{ Consistensi_Ratio.data }} - {{ Konsistensi_kriteria.data }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <!-- Perhitungan ALternatif -->
                <div class="w-full">
                    <table class="w-full text-sm text-left text-gray-400 table-auto border border-separate">
                        <caption class="w-full text-center text-lg py-2 text-gray-800 font-bold">
                            <h3>Matriks Perbandingan Alternatif</h3>
                            <p class="text-justify text-sm text-gray-600 font-normal">
                                Selanjutnya setelah menemukan bobot prioritas kriteria, menetapkan nilai skala
                                perbandingan lokasi berdasarkan masing-masing kriteria. Nilai skala sesuai dengan
                                kebijakan perusahaan. Langkah selanjutnya membuat matriks perbandingan alternatif
                                lokasi berdasarkan kriteria. Setelah terbentuk matriks perbandingan lokasi
                                berdasarkan kriteria maka dicari bobot prioritas untuk perbandingan lokasi terhadap
                                masing,masing kriteria. Buat kriteria selanjutnya dengan cara yang sama.
                            </p>
                        </caption>
                        <tr>
                            <td>
                                <PrimaryButton class="button" @click="generate">JalanKan Perhitungan</PrimaryButton>
                            </td>
                        </tr>
                    </table>
                </div>
                <!-- Alternatif Matrix -->
                <div class="w-full">
                    <table class="w-full text-sm text-left text-gray-400 table-auto border border-separate"
                        v-for="(col, index) in alternatif_Matrix" :key="col.id" :index="index">
                        <caption class="border text-justify">
                            <h3
                                class="bg-second-primary w-full text-center text-white text-base md:text-lg py-2 font-bold border-b">
                                Matriks Perbandingan Alternatif Berdasarkan {{ col.kriteria.kode }}
                            </h3>
                        </caption>
                        <thead class="text-xs  uppercase border-b text-gray-900">
                            <tr>
                                <th scope="col" class="p-4">
                                    Kode
                                </th>
                                <th scope="col" class="px-4 py-3" v-for="item in alternatif" :key="item.id">{{
                                    item.kode }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs border-b text-gray-900" v-if="alternatif_Matrix !== null">
                            <tr v-for="(row, idx1) in parseJSON(col.data)">
                                <td> {{ alternatif[idx1].kode }} </td>

                                <td v-for="(item, idx3) in row">
                                    {{ item }}
                                </td>
                            </tr>
                            <tr>
                                <td>Hasil Kolom</td>
                                <td v-for="(bobot) in parseJSON(AlternatifBobot[index].data)">
                                    {{ bobot }}
                                </td>
                            </tr>
                        </tbody>

                    </table>
                    <!-- Alternatif bobot Prioritas -->
                    <table class="w-full text-sm text-left text-gray-400 table-auto border border-separate"
                        v-for="(col, index) in matrixBobotAlternatif" :key="col.id" :index="index">
                        <caption class="border text-justify">
                            <h3
                                class="bg-second-primary w-full text-center text-white text-base md:text-lg py-2 font-bold border-b">
                                Matriks Prioritas Alternatif Berdasarkan {{ col.kriteria.kode }}
                            </h3>
                        </caption>
                        <thead class="text-xs  uppercase border-b text-gray-900">
                            <tr>
                                <th scope="col" class="p-4">
                                    Kode
                                </th>
                                <th scope="col" class="px-4 py-3" v-for="item in alternatif" :key="item.id">{{
                                    item.kode }}</th>
                                <th>Bobot Prioritas</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs border-b text-gray-900" v-if="matrixBobotAlternatif !== null">
                            <tr v-for="(row, idx1) in parseJSON(col.data)" :index="idx1">
                                <td> {{ alternatif[idx1].kode }} </td>

                                <td v-for="(item, idx3) in row">
                                    {{ item }}
                                </td>
                                <td >
                                   {{parseJSON(BobotPrioritasAlternatif[index].data)[idx1]}}
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>

                <!-- Hasil Akhir -->
                 <!--  -->
                 <div class="w-full">
                    <table class="w-full text-sm text-left text-gray-400 table-auto border border-separate">
                        <caption class="border text-justify">
                            <h3
                                class="bg-second-primary w-full text-center text-base md:text-lg py-2 text-white font-bold border-b">
                                KEIGEN KRITERIA DAN ALTERNATIF
                            </h3>
                            <p class="text-gray-500 px-2 md:px-4 text-xs md:text-sm">
                                Setelah menemukan bobot dari masing-masing kriteria terhadap lokasi yang sudah ditentukan oleh pihak perusahaan, langkah selanjutnya adalah mengalikan bobot dari masing,masing kriteria dengan bobot dari masing-masing lokasi, kemudian hasil perkalian tersebut dijumlahkan perbaris. Sehingga didapatkan total prioritas global seperti pada tabel berikut.

                            </p>
                        </caption>
                        <thead class="text-xs  uppercase border-b text-gray-900">
                            <tr>
                                <th class="p-1 text-center" rowspan="2">Alternatif</th>
                                <th class="p-1 text-center" :colspan="kriteria.length">Kriteria</th>
                                <th class="p-1 text-center" rowspan="3">Nilai</th>
                                <th class="p-1 text-center" rowspan="4">Ranking</th>
                                <th class="p-1 text-center" rowspan="4">Detail</th>
                            </tr>
                            <tr>
                                <th v-for="item in kriteria">{{item.kode}}</th>
                            </tr>
                            <tr>
                                <th>Vector Keygen</th>
                                <th v-for="(item,idx2) in parseJSON(BobotPrioritasKriteria.data)" v-if="BobotPrioritasKriteria !== null">
                                    {{ item }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-xs border-b text-gray-900">
                            <!-- Vector Keygen -->

                            <tr v-for="(item,idx) in hasil_AHP">
                                <td>{{ item.kode }}</td>
                                <td v-for="col in parseJSON(item.data)">
                                    {{ col }}
                                </td>
                                <td>{{item.ranking}}</td>
                                <td>{{idx+1}}</td>
                                <td>
                                    <Link :href="route('Alternatif.show', {slug: item.kode})">
                                        <PrimaryButton type="button" class="bg-blue-400 hover:bg-blue-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>

                                        </PrimaryButton>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
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

/* loading Page*/

.lds-roller {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
}

.lds-roller div {
    animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    transform-origin: 40px 40px;
}

.lds-roller div:after {
    content: " ";
    display: block;
    position: absolute;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #dfdede;
    margin: -4px 0 0 -4px;
}

.lds-roller div:nth-child(1) {
    animation-delay: -0.036s;
}

.lds-roller div:nth-child(1):after {
    top: 63px;
    left: 63px;
}

.lds-roller div:nth-child(2) {
    animation-delay: -0.072s;
}

.lds-roller div:nth-child(2):after {
    top: 68px;
    left: 56px;
}

.lds-roller div:nth-child(3) {
    animation-delay: -0.108s;
}

.lds-roller div:nth-child(3):after {
    top: 71px;
    left: 48px;
}

.lds-roller div:nth-child(4) {
    animation-delay: -0.144s;
}

.lds-roller div:nth-child(4):after {
    top: 72px;
    left: 40px;
}

.lds-roller div:nth-child(5) {
    animation-delay: -0.18s;
}

.lds-roller div:nth-child(5):after {
    top: 71px;
    left: 32px;
}

.lds-roller div:nth-child(6) {
    animation-delay: -0.216s;
}

.lds-roller div:nth-child(6):after {
    top: 68px;
    left: 24px;
}

.lds-roller div:nth-child(7) {
    animation-delay: -0.252s;
}

.lds-roller div:nth-child(7):after {
    top: 63px;
    left: 17px;
}

.lds-roller div:nth-child(8) {
    animation-delay: -0.288s;
}

.lds-roller div:nth-child(8):after {
    top: 56px;
    left: 12px;
}

@keyframes lds-roller {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
