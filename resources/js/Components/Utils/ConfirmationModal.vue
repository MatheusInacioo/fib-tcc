<template>
    <Transition name="modal-overlay">
        <div
            v-show="showModal"
            id="confirmation-modal"
            tabindex="-1"
            class="absolute w-screen h-screen top-0 left-0 inset-0 z-50 overflow-y-auto overflow-x-hidden flex items-center justify-center bg-gray-800 bg-opacity-75"
        >
            <Transition name="modal-body">
                <div
                    v-if="showModal"
                    class="flex items-center justify-center h-[400px] px-4 text-center w-[500px]"
                >
                    <div
                        class="bg-white rounded-lg shadow-lg w-full h-80 p-4 md:p-5 flex flex-col"
                    >
                        <div class="text-center h-full flex flex-col justify-between">
                            <i class="bx bx-error text-yellow-500 text-8xl"></i>
                            <h3 v-if="! customMessage" class="mb-5 text-lg font-normal text-black">
                                Deseja realmente excluir esse item? <br />
                                Esta ação é irreversível.
                            </h3>
                            <h3
                                v-if="customMessage"
                                v-html="customMessage.content"
                                class="mb-5 text-lg font-normal text-black"
                            ></h3>
                            <div class="flex justify-between w-full">
                                <button
                                    type="button"
                                    class="flex justify-center w-24 px-2 py-2 bg-gray-400 text-white font-medium rounded-lg hover:scale-110 transition-all"
                                    @click="closeModal()"
                                >
                                    Cancelar
                                </button>
                                <button
                                    v-if="! customMessage"
                                    @click="confirmDelete()"
                                    class="flex justify-center w-24 px-4 py-2 bg-primary text-secondary font-medium rounded-lg hover:scale-110 transition-all"
                                >
                                    Excluir
                                </button>
                                <button
                                    v-if="customMessage && customMessage.subject == 'close-contract'"
                                    @click="closeContract()"
                                    class="flex justify-center w-24 px-4 py-2 bg-primary text-secondary font-medium rounded-lg hover:scale-110 transition-all"
                                >
                                    Confirmar
                                </button>
                                <button
                                    v-if="customMessage && customMessage.subject == 'export-data'"
                                    @click="confirmExport()"
                                    class="flex justify-center w-24 px-4 py-2 bg-primary text-secondary font-medium rounded-lg hover:scale-110 transition-all"
                                >
                                    Exportar
                                </button>
                                <button
                                    v-if="customMessage && customMessage.subject == 'exit-system'"
                                    @click="exitSystem()"
                                    class="flex justify-center w-24 px-4 py-2 bg-primary text-secondary font-medium rounded-lg hover:scale-110 transition-all"
                                >
                                    Sair
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>
        </div>
    </Transition>
</template>

<script>
export default {
    props: {
        settings: {
            itemId: null,
            route: null,
        },

        showModal: {
            type: Boolean,
            default: false,
        },

        customMessage: {
            type: String,
            default: '',
        },
    },

    methods: {
        confirmDelete() {
            this.$emit('confirm-delete');
        },

        closeModal() {
            this.$emit('close-modal');
        },

        closeContract() {
            this.$emit('close-contract');
        },

        confirmExport() {
            this.$emit('confirm-export');
        },

        exitSystem() {
            this.$emit('exit-system');
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
