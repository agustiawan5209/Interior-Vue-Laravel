<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { ref, defineProps } from 'vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';


const props = defineProps(['alternatif', 'kriteria'])
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
</script>

<template>
    <GuestLayout>

        <Head title="Kriteria" />


        <!-- section -->
        <section>
            <!-- Container -->
            <div class="container">
                <!-- row -->
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-6">
                        <div class="img-wrapper">
                            <div class="after"></div>
                            <img src="assets/imgs/img-1.jpg" class="w-100" alt="About Us">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h6 class="title mb-3">Lorem ipsum dolor sit amet, consectetur.</h6>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quae autem rem impedit molestiae hic
                            ducimus, consequuntur ullam dolorem quaerat beatae labore explicabo, sint laboriosam aperiam
                            nihil inventore facilis. Quasi, facilis.</p>
                        <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur, amet!
                        </p>
                        <button class="btn btn-outline-primary btn-sm">Learn More</button>
                    </div>
                </div>
                <!-- End of Row -->
            </div>
            <!-- End of Container -->
        </section><!-- End of Section -->
        <div class="container border rounded pb-2 border-primary">

            <div class="w-full px-4 flex justify-between py-2 items-center">
                <!-- Text -->
                <div class="block" data-aos="flip-up">
                    <h3
                        class="text-2xl md:text-3xl font-semibold leading-10 sm:leading-none tracking-wide text-base-100 border-b-2 capitalize ">
                        Alternatif Lokasi
                    </h3>
                </div>
                <div>
                    <button type="button" @click="ShowFilter = !ShowFilter"
                        class="transition-all btn btn-primary row justify-items-center align-items-center">
                        <span class="leading-5 tracking-wide break-words mr-2">Filter</span>

                    </button>
                </div>
            </div>
            <form :class="ShowFilter ? 'flex w-full  px-3 md:px-8 py-4 md:py-12 ' : 'hidden h-0'" id="filterform"
                class=" "
                @submit.prevent="submit">
                <div class="row px-3 py-2 ">

                    <div class="col-12 input-group-append mt-1" v-for="(item, index) in kriteria" :key="item.id"
                        :index="index">
                        <label :for="item.kode" class="input-group-text">{{
                            item.name
                        }}</label>
                        <select v-model="FilterForm.subkriteria[index]" :name="item.kode" :id="item.kode"
                            class="form-control w-100">
                            <option v-for="(opt, idx) in item.sub_kriteria" :key="opt.id"
                                :value="item.kode + ',' + opt.nama">
                                {{ opt.nama }}
                            </option>
                        </select>
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
                <div class="col-sm-10 col-md-4 m-auto" v-for="item in alternatif">
                    <div class="testmonial-wrapper">
                        <img v-if="item.alternatif.detail !== null"  :src="item.alternatif.detail.image_path" :alt="item.alternatif.nama">
                        <Link :href="route('Home.detail')" class="title text-black mb-3"><h5>{{ item.alternatif.nama }}</h5></Link>
                        <p v-if="item.alternatif.detail !== null" class="text-black">{{ item.alternatif.detail.deskripsi }}</p>
                    </div>
                </div>
            </div>
            <div class="row" v-else>
               <h1>Kosong</h1>
            </div>

        </div>

    </GuestLayout>
</template>
