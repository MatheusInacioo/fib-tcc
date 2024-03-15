<template>
    <BaseLayout>
        <div class="flex justify-between items-center">
            <p class="font-medium text-2xl">{{ pageTitle }}</p>
        </div>

        <div class="h-px w-full bg-orange-500 my-4"></div>

        <form @submit.prevent="saveForm()">
            <div class="form-row flex">
                <div class="form-field flex flex-col">

                </div>
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
            this.form.post(route('customers.store'));
        },

        updateCustomer() {
            this.form.post(route('customers.update', this.customer.id));
        },
    }
}
</script>
