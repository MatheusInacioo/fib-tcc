<template>
    <BaseLayout>
        <div
            v-if="! crmData"
            class="h-full w-full flex flex-col items-center justify-center"
        >
            <i class="bx bx-error-circle text-red-500 text-8xl mb-5"></i>
            <p class="font-semibold text-2xl mb-5">Nenhum registro encontrado</p>
            <a
                :href="route('crm.create')"
                class="flex justify-center items-center w-40 h-10 bg-primary rounded-xl text-white text-lg font-poppins font-semibold shadow-xl hover:scale-105 transition-all"
            >
                <i class="bx bx-plus font-semibold mr-2"></i>
                <p class="font-medium">Cadastrar</p>
            </a>
        </div>

        <div
            v-else
            class="h-full w-full flex flex-col"
        >
            <div class="flex justify-between items-center mb-8">
                <p class="font-medium 2xl:text-2xl text-xl">CRM Dashboard</p>
                <a
                    :href="route('crm.create')"
                    class="flex justify-center items-center w-40 h-10 bg-primary rounded-xl text-white text-lg font-poppins font-semibold shadow-xl hover:scale-105 transition-all"
                >
                    <i class="bx bx-plus font-semibold mr-2"></i>
                    <p class="font-medium">Cadastrar</p>
                </a>
            </div>

            <div class="flex h-full w-full overflow-x-auto scrollbar-thin">
                <Databoard
                    v-for="board in boards"
                    :title="board"
                    :data="crmData"
                />
            </div>
        </div>

        <NotificationModal
            :show-modal="showModal"
            :message="message"
            @close-modal="toggleModal()"
        />
    </BaseLayout>
</template>

<script>
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import Databoard from '@/Components/Utils/Databoard.vue';
import NotificationModal from '@/Components/Utils/NotificationModal.vue';

export default {
    components: {
        BaseLayout,
        Databoard,
        NotificationModal,
    },

    props: {
        crmData: {},
    },

    data() {
        return {
            message: '',
            showModal: false,
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
        toggleModal() {
            this.showModal = ! this.showModal;
        },
    },
}
</script>
