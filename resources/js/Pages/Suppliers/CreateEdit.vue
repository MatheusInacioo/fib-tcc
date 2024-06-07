<template>
    <BaseLayout>
        <Head :title="pageTitle"/>
        <div class="flex items-center">
            <button
                type="button"
                @click="goBack()"
            >
                <i class="bx bx-left-arrow-alt text-3xl hover:scale-110 transition-all mr-2"></i>
            </button>
            <span class="text-2xl mobile-std:text-xl font-medium">{{ pageTitle }}</span>
        </div>

        <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

        <form
            @submit.prevent="saveForm()"
            class="w-full h-full"
        >
            <div class="form-row flex mb-5 mobile-std:flex-col mobile-std:mb-1">
                <div class="form-field flex flex-col 2lx:mr-6 mr-4 mobile-std:mb-4 mobile-std:mr-0">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Nome da empresa</span>
                    <input
                        v-model="form.name"
                        class="border-gray-300 2xl:w-[370px] mobile-lg:w-[200px] mobile-std:w-full 2xl:text-base text-sm rounded-xl"
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nome fantasia da empresa"
                    >
                    <div v-if="form.errors.name" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.name }}</div>
                </div>

                <div class="form-field flex flex-col 2lx:mr-6 mr-4 mobile-std:mb-4 mobile-std:mr-0">
                    <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">CNPJ</span>
                    <input
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
                <button
                    type="button"
                    @click="goBack()"
                    class="w-24 2xl:h-10 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base text-center bg-gray-400 hover:scale-105 transition-all"
                >
                    Cancelar
                </button>
                <button
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
import { useForm, Head } from '@inertiajs/vue3';
import { vMaska } from "maska"

export default {
    directives: { maska: vMaska },

    components: {
        Head,
        BaseLayout,
    },

    props: {
        supplier: {},
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

    data() {
        return {
            segments: [
                'Atacado',
                'Varejo',
                'Transportes',
                'Distribuidora',
                'Alimentação',
            ],
        }
    },

    computed: {
        pageTitle() {
            return this.supplier ? 'Editar Fornecedor' : 'Novo Fornecedor';
        },

        supplierExists() {
            return this.supplier ? true : false;
        }
    },

    methods: {
        saveForm() {
            return this.supplierExists ? this.updateSupplier() : this.createSupplier();
        },

        createSupplier() {
            return this.form.post(route('suppliers.store'));
        },

        updateSupplier() {
            return this.form.put(route('suppliers.update', this.supplier.data.id));
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

        goBack() {
            window.history.back();
        }
    },

    created() {
        if(this.supplierExists) {
            this.buildForm(this.supplier.data);
        }
    },
}
</script>
