<template>
    <BaseLayout>
        <Head title="Faturamento" />
        <span class="text-2xl font-medium">Faturamento</span>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>


    </BaseLayout>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import BaseLayout from '@/Components/Layout/BaseLayout.vue';

export default {
    components: {
        BaseLayout,
        Head,
    },

    props: {},

    data() {
        return {

        }
    },

    methods: {

    },
}
</script>
