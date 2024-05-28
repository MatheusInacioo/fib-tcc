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
            <div class="form-row flex mb-5 mobile-std:flex-col mobile-std:mb-1">
                <div class="form-field flex flex-col 2lx:mr-6 mr-4 mobile-std:mr-0">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Tipo de Transação</span>
                    <select
                        :readonly="transactionExists"
                        v-model="form.type"
                        name="type"
                        id="type"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full mobile-std:mb-4 2xl:text-base text-sm rounded-xl"
                    >
                        <option
                            v-for="(type, index) in types"
                            :key="index"
                            :value="index"
                        >
                            {{ type }}
                        </option>
                    </select>
                    <div v-if="form.errors.phone" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.type }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4 mobile-std:mb-4 mobile-std:mr-0">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">CNPJ</span>
                    <input
                        :readonly="transactionExists"
                        v-model="form.cnpj"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="cnpj"
                        id="cnpj"
                        v-maska
                        data-maska="##.###.###/0001-##"
                        placeholder="00.000.000/0001-00"
                    >
                    <div v-if="form.errors.cnpj" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.cnpj }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4 mobile-std:mb-4 mobile-std:mr-0">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Email da empresa</span>
                    <input
                        :readonly="transactionExists"
                        v-model="form.email"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full 2xl:text-base text-sm rounded-xl"
                        type="email"
                        name="email"
                        id="email"
                        placeholder="Ex: email@email.com"
                    >
                    <div v-if="form.errors.email" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.email }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4 mobile-std:mb-4 mobile-std:mr-0">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Endereço</span>
                    <input
                        :readonly="transactionExists"
                        v-model="form.address"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="address"
                        id="address"
                        placeholder="Endereço físico da empresa"
                    >
                    <div v-if="form.errors.address" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.address }}</div>
                </div>
            </div>

            <div class="form-row flex mb-5 mobile-std:flex-col mobile-std:mb-1">
                <div class="form-field flex flex-col 2lx:mr-6 mr-4 mobile-std:mb-4 mobile-std:mr-0">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Telefone da empresa</span>
                    <input
                        :readonly="transactionExists"
                        v-model="form.phone"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="phone"
                        id="phone"
                        v-maska
                        data-maska="(##)####-####"
                        placeholder="(00)0000-0000"
                    >
                    <div v-if="form.errors.phone" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.phone }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4 mobile-std:mb-4 mobile-std:mr-0">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Segmento de atuação</span>
                    <select
                        :readonly="transactionExists"
                        v-model="form.segment"
                        name="segment"
                        id="segment"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full 2xl:text-base text-sm rounded-xl"
                    >
                        <option
                            v-for="segment in segments"
                            :key="segment.id"
                            :value="segment"
                        >
                            {{ segment }}
                        </option>
                    </select>
                    <div v-if="form.errors.segment" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.segment }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4 mobile-std:mb-4 mobile-std:mr-0">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Nome do responsável</span>
                    <input
                        :readonly="transactionExists"
                        v-model="form.responsible"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="responsible"
                        id="responsible"
                        placeholder="Nome do responsável pela empresa"
                    >
                    <div v-if="form.errors.responsible" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.responsible }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4 mobile-std:mb-4 mobile-std:mr-0">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Celular do responsável</span>
                    <input
                        :readonly="transactionExists"
                        v-model="form.responsible_phone"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="responsible-phone"
                        id="responsible-phone"
                        v-maska
                        data-maska="(##)#####-####"
                        placeholder="(00)00000-0000"
                    >
                    <div v-if="form.errors.responsible_phone" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.responsible_phone }}</div>
                </div>
            </div>

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
            type: null,
            name: null,
            email: null,
            password: null,
        });

        return { form }
    },

    data() {
        return {
            types: ['Compra', 'Venda'],
        }
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
