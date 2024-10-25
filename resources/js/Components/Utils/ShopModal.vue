<template>
    <Transition name="modal-overlay">
        <div
            v-show="showModal"
            id="role-modal"
            tabindex="-1"
            class="absolute w-screen h-screen top-0 left-0 inset-0 z-50 overflow-y-auto overflow-x-hidden flex items-center justify-center bg-gray-800 bg-opacity-75"
        >
            <Transition name="modal-body">
                <div
                    v-if="showModal"
                    class="flex items-center px-4 w-[40%] mobile-std:w-full"
                >
                    <div
                        class="bg-white rounded-lg shadow-lg w-full h-full flex flex-col"
                    >
                        <div class="flex justify-between w-full items-center px-4 py-2">
                            <p class="mobile-std:text-lg text-xl font-medium">{{ modalTitle }}</p>
                            <button
                                class="w-8 h-8 bg-transparent border-none text-primary hover:scale-125 transition-all flex justify-center items-center"
                                @click="closeModal()"
                            >
                                <i class="text-3xl bx bx-x"></i>
                            </button>
                        </div>

                        <div class="flex flex-col p-4">
                            <div class="form-field flex flex-col mb-4">
                                <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Nome</span>
                                <input
                                    v-model="form.name"
                                    class="border-gray-300 2xl:text-base text-sm rounded-xl"
                                    type="text"
                                    name="shop-name"
                                    id="shop-name"
                                    placeholder="Digite o nome da loja"
                                >
                                <div v-if="form.errors.name" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.name }}</div>
                            </div>

                            <div class="form-field flex flex-col">
                                <span class="font-medium 2xlg:text-lg text-base ml-1 mb-2">Localização</span>
                                <input
                                    v-model="form.location"
                                    class="border-gray-300 2xl:text-base text-sm rounded-xl"
                                    type="text"
                                    name="shop-location"
                                    id="shop-location"
                                    placeholder="Localização da loja"
                                >
                                <div v-if="form.errors.location" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.location }}</div>
                            </div>
                        </div>

                        <div class="flex justify-between w-full items-center p-4">
                            <button
                                type="button"
                                class="flex justify-center h-10 w-24 px-2 py-2 bg-gray-400 text-white font-medium rounded-lg hover:scale-110 transition-all"
                                @click="closeModal()"
                            >
                                Cancelar
                            </button>
                            <button
                                type="button"
                                @click="saveForm()"
                                class="flex justify-center items-center h-10 w-24 px-4 py-2 bg-primary text-secondary font-medium rounded-lg hover:scale-110 transition-all"
                                :disabled="! form.name || isLoading"
                                :class="{
                                    'bg-primary text-secondary hover:scale-105 transition-all' : form.name,
                                    'bg-gray-300 text-white' : ! form.name,
                                }"
                            >
                                <span v-if="!isLoading">Salvar</span>
                                <i v-if="isLoading" class="bx bx-loader-alt animate-spin text-xl"></i>
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

export default {
    props: {
        showModal: {
            type: Boolean,
            default: false,
        },

        shop: {},
    },

    setup() {
        const form = useForm({
            id: null,
            company_id: null,
            name: null,
            location: null,
        });

        return { form }
    },

    data() {
        return {
            isLoading: false,
        }
    },

    computed: {
        shopExists() {
            return this.form.id
                ? true
                : false;
        },

        modalTitle() {
            return this.shopExists
                ? 'Editar Loja'
                : 'Nova Loja';
        },
    },

    methods: {
        closeModal() {
            this.$emit('close-modal')
            this.form.id = null;
            this.form.company_id = null;
            this.form.name = null;
            this.form.location = null;
        },

        saveForm() {
            return this.shopExists ? this.updateshop() : this.createshop();
        },

        createshop() {
            this.form.clearErrors();
            this.isLoading = true;
            this.form.company_id = this.$page.props.company.data.id;

            return this.form.post(route('shops.store'), {
                onError: () => {
                    this.isLoading = false;
                }
            });
        },

        updateshop() {
            this.form.clearErrors();
            this.isLoading = true;

            return this.form.put(route('shops.update', this.shop.id), {
                onError: () => {
                    this.isLoading = false;
                }
            });
        },
    },

    watch: {
        shop: {
            handler(newShop) {
                if (newShop) {
                    this.form.id = newShop.id;
                    this.form.company_id = newShop.company_id;
                    this.form.name = newShop.name;
                    this.form.location = newShop.location;
                } else {
                    this.form.id = null;
                    this.form.company_id = null;
                    this.form.name = null;
                    this.form.location = null;
                }
            },

            immediate: true,
        }
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
