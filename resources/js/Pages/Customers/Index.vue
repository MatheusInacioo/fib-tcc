<template>
    <BaseLayout>
        <div class="flex justify-between items-center">
            <p class="font-medium text-2xl">Clientes</p>
            <a
                :href="route('customers.create')"
                class="flex justify-center items-center w-40 h-10 bg-orange-500 rounded-xl text-white text-lg font-poppins font-semibold shadow-xl hover:scale-105 transition-all"
            >
                <i class="bx bx-plus font-semibold mr-2"></i>
                <p class="font-medium">Novo Cliente</p>
            </a>
        </div>
        
        <div class="h-px w-full bg-orange-500 my-4"></div>
    </BaseLayout>
</template>

<script>
    import BaseLayout from '@/Components/Layout/BaseLayout.vue';

    export default {
        components: {
            BaseLayout,
        },

        props: {
            customers: [],
        },

        data() {
            return {

            }
        },
    }
</script>
