<template>
    <BaseLayout>
        <Head title="Financeiro" />
        <span class="text-2xl font-medium">Financeiro</span>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

        <div class="flex web:justify-between rounded-xl shadow-xl 2xl:p-4 p-2 web:max-h-[400px] mobile-std:min-h-[500px] w-full border border-gray-200 mobile-std:mb-4">
            <canvas class="web:max-h-[85%]" id="invoicingChart"></canvas>
        </div>
    </BaseLayout>
</template>

<script>
import { Head } from '@inertiajs/vue3';
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
    }
}
</script>