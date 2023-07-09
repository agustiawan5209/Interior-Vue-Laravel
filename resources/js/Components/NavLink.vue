<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'inline-flex justify-start items-center gap-2 pl-4 py-2 border-l-8 border-indigo-400 text-sm font-medium leading-5 text-gray-600 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
        : 'inline-flex justify-start items-center gap-2 pl-4 py-2 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-600 hover:text-gray-800 hover:border-gray-600 focus:outline-none focus:text-gray-800 focus:border-gray-300 transition duration-150 ease-in-out'
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
