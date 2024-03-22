<template>
    <Transition name="modal-overlay">
        <div
            @click="showModal = false"
            v-show="showModal"
            id="confirmation-modal"
            tabindex="-1"
            class="absolute w-screen h-screen top-0 left-0 inset-0 z-50 overflow-y-auto overflow-x-hidden flex items-center justify-center bg-gray-800 bg-opacity-75"
        >
            <Transition name="modal-body">
                <div
                    v-if="showModal"
                    class="flex items-center h-[80%] px-4 w-[50%]"
                >
                    <div
                        class="bg-white rounded-lg shadow-lg w-full h-full p-4 flex flex-col"
                    >
                        <div class="flex justify-between w-full items-center">
                            <p class="2xl:text-2xl text-xl font-medium">Novo Cadastro</p>
                            <button
                                class="2xl:w-8 2xl:h-8 bg-transparent border-none text-primary 2xl:text-4xl hover:scale-125 transition-all flex justify-center items-center"
                                @click="closeModal()"
                            >
                                <i class="bx bx-x"></i>
                            </button>
                        </div>

                        <div class="w-full h-px bg-primary my-4"></div>

                        <div class="h-full overflow-y-auto scrollbar-thin">
                            <form
                                @submit.prevent="saveForm()"
                                class="w-full h-full"
                            >
                                <div class="form-row flex mb-5">
                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Nome da empresa</span>
                                        <input
                                            v-model="form.name"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-xl"
                                            type="text"
                                            name="name"
                                            id="name"
                                            placeholder="Nome fantasia da empresa"
                                        >
                                        <div v-if="form.errors.name" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.name }}</div>
                                    </div>

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">CNPJ</span>
                                        <input
                                            v-model="form.cnpj"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-xl"
                                            type="text"
                                            name="cnpj"
                                            id="cnpj"
                                            v-maska
                                            data-maska="##.###.###/0001-##"
                                            placeholder="00.000.000/0001-00"
                                        >
                                        <div v-if="form.errors.cnpj" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.cnpj }}</div>
                                    </div>

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Email da empresa</span>
                                        <input
                                            v-model="form.email"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-xl"
                                            type="email"
                                            name="email"
                                            id="email"
                                            placeholder="Ex: email@email.com"
                                        >
                                        <div v-if="form.errors.email" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.email }}</div>
                                    </div>
                                </div>

                                <div class="form-row flex mb-5">
                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Telefone da empresa</span>
                                        <input
                                            v-model="form.phone"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-xl"
                                            type="text"
                                            name="phone"
                                            id="phone"
                                            v-maska
                                            data-maska="(##)####-####"
                                            placeholder="(00)0000-0000"
                                        >
                                        <div v-if="form.errors.phone" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.phone }}</div>
                                    </div>

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Nome do responsável</span>
                                        <input
                                            v-model="form.responsible"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-xl"
                                            type="text"
                                            name="responsible"
                                            id="responsible"
                                            placeholder="Nome do responsável pela empresa"
                                        >
                                        <div v-if="form.errors.responsible" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.responsible }}</div>
                                    </div>

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Celular do responsável</span>
                                        <input
                                            v-model="form.responsible_phone"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-xl"
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

                                <div class="form-row flex mb-5">
                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Segmento de atuação</span>
                                        <input
                                            v-model="form.segment"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-xl"
                                            type="text"
                                            name="segment"
                                            id="segment"
                                            placeholder="Ex: Atacado"
                                        >
                                        <div v-if="form.errors.segment" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.segment }}</div>
                                    </div>

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Tipo de Cadastro</span>
                                        <select
                                            v-model="form.type"
                                            name="type"
                                            id="type"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-xl"
                                        >
                                            <option selected disabled value="">Selecione...</option>
                                            <option
                                                v-for="type in companyTypes"
                                                :key="type.id"
                                                :value="type"
                                            >
                                                {{ type }}
                                            </option>
                                        </select>
                                        <div v-if="form.errors.phone" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.type }}</div>
                                    </div>

                                    <div class="form-field flex flex-col 2lx:mr-6 mr-4">
                                        <span class="font-medium 2xlg:text-lg text-base ml-1 mb-1">Status</span>
                                        <select
                                            v-model="form.status"
                                            name="status"
                                            id="status"
                                            class="border-gray-300 w-[280px] 2xl:text-base text-sm rounded-xl"
                                        >
                                            <option selected disabled value="">Selecione...</option>
                                            <option
                                                v-for="status in statuses"
                                                :key="status.id"
                                                :value="status"
                                            >
                                                {{ status }}
                                            </option>
                                        </select>
                                        <div v-if="form.errors.phone" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.status }}</div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="flex justify-between w-full items-center pt-4">
                            <a
                                :href="route('crm.index')"
                                class="2xl:h-10 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base bg-gray-400 hover:scale-105 transition-all"
                            >
                                Cancelar
                            </a>
                            <button
                                type="submit"
                                class="2xl:h-10 p-2 rounded-xl text-secondary font-medium text-sm 2xl:text-base ml-3 bg-primary hover:scale-105 transition-all"
                            >
                                Salvar
                            </button>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script>
import { useForm } from '@inertiajs/vue3';
import { vMaska } from "maska";

export default {
    directives: { maska: vMaska },

    props: {
        settings: {
            itemId: null,
            route: null,
        },

        showModal: {
            type: Boolean,
            default: false,
        },
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
            type: null,
            status: null,
        });

        return { form }
    },

    data() {
        return {
            companyTypes: [
                'Cliente',
                'Fornecedor',
                'Distribuidor',
            ],

            statuses: [
                'Contato',
                'Negociação',
                'Assinatura Pendente',
                'Standby',
                'Sem Interesse',
            ],
        }
    },

    methods: {
        closeModal() {
            this.$emit('close-modal');
        },
    },
};
</script>

<style scoped>
    .modal-overlay-enter-active,
    .modal-overlay-leave-active {
        transition: opacity 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .modal-overlay-enter-from,
    .modal-overlay-leave-to {
        opacity: 0;
    }

    .modal-body-enter-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02) 0.15s;
    }

    .modal-body-leave-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .modal-body-enter-from {
        opacity: 0;
        transform: scale(0.8);
    }

    .modal-body-leave-to {
        transform: scale(0.8);
    }
</style>
