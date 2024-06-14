<template>
    <Transition name="modal-overlay">
        <div
            v-show="showModal"
            id="notification-modal"
            tabindex="-1"
            class="absolute w-screen h-screen top-0 left-0 inset-0 z-50 overflow-y-auto overflow-x-hidden flex items-center justify-center bg-gray-800 bg-opacity-75"
        >
            <Transition name="modal-body">
                <div
                    v-if="showModal"
                    class="flex items-center justify-center px-4 text-center w-[500px]"
                >
                    <div
                        class="bg-white rounded-lg shadow-lg w-full p-4 md:p-5 flex flex-col"
                    >
                        <div class="text-center flex flex-col justify-between">
                            <i
                                class="text-8xl mb-4"
                                :class="{
                                    'bx bx-check-circle text-success' : message.type == 'success',
                                    'bx bx-x-circle text-danger' : message.type == 'error'
                                }"
                            ></i>
                            <h3 class="mb-4 text-lg font-normal text-black">
                                {{ message.content }}
                            </h3>
                            <div class="flex justify-center w-full">
                                <button
                                    type="button"
                                    class="w-20 px-2 py-2 text-white rounded-lg hover:scale-110 transition-all"
                                    :class="{
                                        'bg-success' : message.type == 'success',
                                        'bg-danger' : message.type == 'error',
                                    }"
                                    @click="closeModal()"
                                >
                                    <p class="text-base font-semibold">OK</p>
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
        showModal: {
            type: Boolean,
            default: false,
        },

        message: {
            type: Object,
            default: () => ({}),
        },
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
