<template>
    <BaseLayout>
        <div
            v-if="crm == 0"
            class="h-full w-full flex flex-col items-center justify-center"
        >
            <i class="bx bx-error-circle text-red-500 text-8xl mb-5"></i>
            <p class="font-semibold text-2xl mb-5">Nenhum registro encontrado</p>
            <button
                @click="toggleCrmModal()"
                class="flex justify-center items-center w-40 h-10 bg-primary rounded-xl text-white text-lg font-poppins font-semibold shadow-xl hover:scale-105 transition-all"
            >
                <i class="bx bx-plus font-semibold mr-2 text-secondary"></i>
                <p class="font-medium text-secondary">Cadastrar</p>
            </button>
        </div>

        <div
            v-else
            class="h-full w-full flex flex-col"
        >
            <div class="flex justify-between items-center mb-8">
                <p class="font-medium 2xl:text-2xl text-xl">CRM Dashboard</p>
                <button
                    @click="toggleCrmModal()"
                    class="flex justify-center items-center w-40 h-10 bg-primary rounded-xl text-white text-lg font-poppins font-semibold shadow-xl hover:scale-105 transition-all"
                >
                    <i class="bx bx-plus font-semibold mr-2 text-secondary"></i>
                    <p class="font-medium text-secondary">Cadastrar</p>
                </button>
            </div>

            <div class="flex h-full w-full overflow-x-auto scrollbar-thin">
                <Databoard
                    v-for="board in boards"
                    :title="board"
                    :crm="crm"
                />
            </div>
        </div>

        <CrmModal
            :show-modal="showCrmModal"
            @close-modal="toggleCrmModal()"
        />
    </BaseLayout>
</template>

<script>
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import Databoard from '@/Components/Utils/Databoard.vue';
import CrmModal from './CrmModal.vue';

export default {
    components: {
        BaseLayout,
        Databoard,
        CrmModal,
    },

    props: {
        crm: {},
    },

    data() {
        return {
            message: '',
            showCrmModal: false,
            boards: [
                'Contato',
                'Negociação',
                'Assinatura Pendente',
                'Standby',
                'Sem Interesse',
            ],
        }
    },

    methods: {
        toggleCrmModal() {
            this.showCrmModal = ! this.showCrmModal;
        },
    },
}
</script>
