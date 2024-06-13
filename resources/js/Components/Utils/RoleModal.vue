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
                    class="flex items-center px-4 w-[20%] mobile-std:w-full"
                >
                    <div
                        class="bg-white rounded-lg shadow-lg w-full h-full flex flex-col"
                    >
                        <div class="flex justify-between w-full items-center p-4">
                            <p class="mobile-std:text-lg text-xl font-medium">Novo Cargo</p>
                            <button
                                class="2xl:w-8 2xl:h-8 bg-transparent border-none text-primary 2xl:text-4xl hover:scale-125 transition-all flex justify-center items-center"
                                @click="closeModal()"
                            >
                                <i class="mobile-std:text-xl text-3xl bx bx-x"></i>
                            </button>
                        </div>

                        <div class="px-4">
                            <div class="form-field flex flex-col">
                                <input
                                    v-model="form.role_name"
                                    class="border-gray-300 2xl:text-base text-sm rounded-xl"
                                    type="text"
                                    name="role-name"
                                    id="role-name"
                                    placeholder="Digite o nome do cargo"
                                >
                                <div v-if="form.errors.role_name" class="form-error font-medium text-red-500 text-sm 2xl:text-base">{{ form.errors.role_name }}</div>
                            </div>
                        </div>

                        <div class="flex justify-between w-full items-center p-4">
                            <button
                                type="button"
                                class="2xl:h-10 w-24 p-2 rounded-xl text-white font-medium text-sm 2xl:text-base bg-gray-400 hover:scale-105 transition-all"
                                @click="closeModal()"
                            >
                                Cancelar
                            </button>
                            <button
                                @click="createRole()"
                                class="2xl:h-10 w-24 p-2 rounded-xl font-medium text-sm 2xl:text-base ml-3"
                                :disabled="! form.role_name"
                                :class="{
                                    'bg-primary text-secondary hover:scale-105 transition-all' : form.role_name,
                                    'bg-gray-300 text-white' : ! form.role_name,
                                }"
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

export default {
    props: {
        showModal: {
            type: Boolean,
            default: false,
        },
    },

    setup() {
        const form = useForm({
            role_name: null,
        });

        return { form }
    },

    methods: {
        closeModal() {
            this.$emit('close-modal');
        },

        async createRole() {
            try {
                await this.form.post(route('permissions.create-role'));

                this.closeModal();
            } catch (error) {
                console.error(error);
            }
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
