<template>
    <div
        id="notification-modal"
        tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
    >
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-lg">
                <div class="p-4 md:p-5 text-center">
                    <i class="bx bx-error text-yellow-500 text-6xl"></i>
                    <h3 class="mb-5 text-lg font-normal text-black">
                        Deseja realmente excluir esse item? <br> Esta ação é irreversível.
                    </h3>
                    <a
                        data-modal-hide="notification-modal"
                        :href="route(deleteRoute, 3)"
                        class="text-white bg-orange-500 hover:scale-110 transition-all"
                    >
                        Excluir
                    </a>
                    <button
                        data-modal-hide="notification-modal"
                        type="button"
                        class="text-white bg-gray-400 hover:scale-110 transition-all"
                    >
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            deleteRoute: '',
        }
    }
</script>
