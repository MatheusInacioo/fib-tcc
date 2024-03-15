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
                <div class="form-field flex flex-col mr-6 md:mr-4">
                    <span class="font-medium text-lg md:text-base ml-1 mb-2">Nome da empresa</span>
                    <input
                        v-model="form.name"
                        class="border-gray-300 w-340 md:w-72 md:text-sm rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome fantasia da empresa"
                    >
                    <div v-if="form.errors.name" class="form-error font-medium text-red-500 text-base">{{ form.errors.name }}</div>
                </div>

                <div class="form-field flex flex-col mr-6 md:mr-4">
                    <span class="font-medium text-lg md:text-base ml-1 mb-2">CNPJ</span>
                    <input
                        v-model="form.cnpj"
                        class="border-gray-300 w-340 md:w-72 md:text-sm rounded-xl"
                        type="text"
                        name="cnpj"
                        id="cnpj"
                        v-maska
                        data-maska="##.###.###/0001-##"
                        placeholder="00.000.000/0001-00"
                    >
                    <div v-if="form.errors.cnpj" class="form-error font-medium text-red-500 text-base">{{ form.errors.cnpj }}</div>
                </div>

                <div class="form-field flex flex-col mr-6 md:mr-4">
                    <span class="font-medium text-lg md:text-base ml-1 mb-2">Email da empresa</span>
                    <input
                        v-model="form.email"
                        class="border-gray-300 w-340 md:w-72 md:text-sm rounded-xl"
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Ex: email@email.com"
                    >
                    <div v-if="form.errors.email" class="form-error font-medium text-red-500 text-base">{{ form.errors.email }}</div>
                </div>

                <div class="form-field flex flex-col mr-6 md:mr-4">
                    <span class="font-medium text-lg md:text-base ml-1 mb-2">Endereço</span>
                    <input
                        v-model="form.address"
                        class="border-gray-300 w-340 md:w-72 md:text-sm rounded-xl"
                        type="text"
                        name="address"
                        id="address"
                        placeholder="Endereço físico da empresa"
                    >
                    <div v-if="form.errors.address" class="form-error font-medium text-red-500 text-base">{{ form.errors.address }}</div>
                </div>
            </div>

            <div class="form-row flex mb-5">
                <div class="form-field flex flex-col mr-6 md:mr-4">
                    <span class="font-medium text-lg md:text-base ml-1 mb-2">Telefone da empresa</span>
                    <input
                        v-model="form.phone"
                        class="border-gray-300 w-340 md:w-72 md:text-sm rounded-xl"
                        type="text"
                        name="phone"
                        id="phone"
                        v-maska
                        data-maska="(##)####-####"
                        placeholder="(00)0000-0000"
                    >
                    <div v-if="form.errors.phone" class="form-error font-medium text-red-500 text-base">{{ form.errors.phone }}</div>
                </div>

                <div class="form-field flex flex-col mr-6 md:mr-4">
                    <span class="font-medium text-lg md:text-base ml-1 mb-2">Nome do responsável</span>
                    <input
                        v-model="form.responsible"
                        class="border-gray-300 w-340 md:w-72 md:text-sm rounded-xl"
                        type="text"
                        name="responsible"
                        id="responsible"
                        placeholder="Nome do responsável pela empresa"
                    >
                    <div v-if="form.errors.responsible" class="form-error font-medium text-red-500 text-base">{{ form.errors.responsible }}</div>
                </div>

                <div class="form-field flex flex-col mr-6 md:mr-4">
                    <span class="font-medium text-lg md:text-base ml-1 mb-2">Celular do responsável</span>
                    <input
                        v-model="form.responsible_phone"
                        class="border-gray-300 w-340 md:w-72 md:text-sm rounded-xl"
                        type="text"
                        name="responsible-phone"
                        id="responsible-phone"
                        v-maska
                        data-maska="(##)#####-####"
                        placeholder="(00)00000-0000"
                    >
                    <div v-if="form.errors.responsible_phone" class="form-error font-medium text-red-500 text-base">{{ form.errors.responsible_phone }}</div>
                </div>

                <div class="form-field flex flex-col mr-6 md:mr-4">
                    <span class="font-medium text-lg md:text-base ml-1 mb-2">Segmento de atuação</span>
                    <input
                        v-model="form.segment"
                        class="border-gray-300 w-340 md:w-72 md:text-sm rounded-xl"
                        type="text"
                        name="segment"
                        id="segment"
                        placeholder="Ex: Atacado"
                    >
                    <div v-if="form.errors.segment" class="form-error font-medium text-red-500 text-base">{{ form.errors.segment }}</div>
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
import { vMaska } from "maska"

export default {
    directives: { maska: vMaska },

    components: {
        BaseLayout,
    },

    props: {
        customer: {},
    },

    setup() {
        const form = useForm({
            name: null,
            cnpj: null,
            email: null,
            address: null,
            phone: null,
            responsible: null,
            responsible_phone: null,
            segment: null,

        });

        return { form }
    },

    computed: {
        pageTitle() {
            return this.customer ? 'Editar Cliente' : 'Novo Cliente';
        },

        customerExists() {
            return this.customer ? true : false;
        }
    },

    methods: {
        saveForm() {
            return this.customerExists ? this.updateCustomer() : this.createCustomer();
        },

        createCustomer() {
            return this.form.post(route('customers.store'));
        },

        updateCustomer() {
            return this.form.put(route('customers.update', this.customer.data.id));
        },

        buildForm(data) {
            this.form.name = data.name;
            this.form.cnpj = data.cnpj;
            this.form.email = data.email;
            this.form.address = data.address;
            this.form.phone = data.phone;
            this.form.responsible = data.responsible;
            this.form.responsible_phone = data.responsible_phone;
            this.form.segment = data.segment;
        },
    },

    created() {
        if(this.customerExists) {
            this.buildForm(this.customer.data);
        }
    },
}
</script>
