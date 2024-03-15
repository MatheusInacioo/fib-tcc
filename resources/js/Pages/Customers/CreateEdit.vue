<template>
    <BaseLayout>
        <div class="flex justify-between items-center">
            <p class="font-medium text-2xl">{{ pageTitle }}</p>
        </div>

        <div class="h-px w-full bg-orange-500 my-4"></div>

        <form
            @submit.prevent="saveForm()"
            class="w-full h-full"
        >
            <div class="form-row flex mb-5">
                <div class="form-field flex flex-col mr-6">
                    <span class="font-medium text-xl ml-1 mb-2">Nome</span>
                    <input
                        class="w-340 rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do cliente ou empresa"
                    >
                </div>

                <div class="form-field flex flex-col mr-6">
                    <span class="font-medium text-xl ml-1 mb-2">Nome</span>
                    <input
                        class="w-340 rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do cliente ou empresa"
                    >
                </div>

                <div class="form-field flex flex-col mr-6">
                    <span class="font-medium text-xl ml-1 mb-2">Nome</span>
                    <input
                        class="w-340 rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do cliente ou empresa"
                    >
                </div>

                <div class="form-field flex flex-col mr-6">
                    <span class="font-medium text-xl ml-1 mb-2">Nome</span>
                    <input
                        class="w-340 rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do cliente ou empresa"
                    >
                </div>
            </div>

            <div class="form-row flex mb-5">
                <div class="form-field flex flex-col mr-6">
                    <span class="font-medium text-xl ml-1 mb-2">Nome</span>
                    <input
                        class="w-340 rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do cliente ou empresa"
                    >
                </div>

                <div class="form-field flex flex-col mr-6">
                    <span class="font-medium text-xl ml-1 mb-2">Nome</span>
                    <input
                        class="w-340 rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do cliente ou empresa"
                    >
                </div>

                <div class="form-field flex flex-col mr-6">
                    <span class="font-medium text-xl ml-1 mb-2">Nome</span>
                    <input
                        class="w-340 rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do cliente ou empresa"
                    >
                </div>

                <div class="form-field flex flex-col mr-6">
                    <span class="font-medium text-xl ml-1 mb-2">Nome</span>
                    <input
                        class="w-340 rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome do cliente ou empresa"
                    >
                </div>
            </div>

            <div class="flex">
                <a
                    :href="route('customers.index')"
                    class="h-10 p-2 rounded-xl text-white font-medium text-base bg-gray-400 hover:scale-105 transition-all"
                >
                    Cancelar
                </a>
                <button
                    type="submit"
                    class="h-10 p-2 rounded-xl text-white font-medium text-base ml-3 bg-orange-500 hover:scale-105 transition-all"
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
        customer: [],
    },

    setup() {
        const form = useForm({
            email: null,
            password: null,
            remember: null,
        });

        return { form }
    },

    computed: {
        pageTitle() {
            return this.customer ? 'Editar Cliente' : 'Novo Cliente';
        },
    },

    methods: {
        saveForm() {
            return this.customer.id
                ? this.updateCustomer()
                : this.createCustomer()
        },

        createCustomer() {
            return this.form.post(route('customers.store'));
        },

        updateCustomer() {
            return this.form.put(route('customers.update', this.customer.id));
        },
    }
}
</script>
