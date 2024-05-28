<template>
    <BaseLayout>
        <div class="flex justify-between items-center">
            <p class="font-medium text-xl 2xl:text-2xl">{{ pageTitle }}</p>
        </div>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

        <form
            @submit.prevent="saveForm()"
            class="w-full h-full"
        >
            <div class="flex mobile-std:justify-between">
                <a
                    v-if="transactionExists"
                    :href="route('transactions.index')"
                    class="w-24 2xl:h-10 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base text-center bg-primary hover:scale-105 transition-all"
                >
                    Voltar
                </a>
                <a
                    v-if="! transactionExists"
                    :href="route('transactions.index')"
                    class="w-24 2xl:h-10 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base text-center bg-gray-400 hover:scale-105 transition-all"
                >
                    Cancelar
                </a>
                <button
                    v-if="! transactionExists"
                    type="submit"
                    class="w-24 2xl:h-10 p-2 rounded-xl text-secondary font-medium text-sm 2xl:text-base ml-3 bg-primary hover:scale-105 transition-all"
                >
                    Salvar
                </button>
            </div>
        </form>
    </BaseLayout>
</template>

<script>
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import { useForm } from '@inertiajs/vue3';

export default {
    components: {
        BaseLayout,
    },

    props: {
        transaction: {},
    },

    setup() {
        const form = useForm({
            name: null,
            email: null,
            password: null,
        });

        return { form }
    },

    computed: {
        pageTitle() {
            return this.transactionExists
                ? 'Detalhes da Transação'
                : 'Nova Transação';
        },

        transactionExists() {
            return this.transaction ? true : false;
        }
    },

    methods: {
        saveForm() {
            return this.form.post(route('transactions.store'));
        },

        buildForm(data) {
            this.form.name = data.name;
            this.form.email = data.email;
        },
    },

    created() {
        if(this.transactionExists) {
            this.buildForm(this.transaction.data);
        }
    },
}
</script>
