<template>
    <BaseLayout>
        <div
            v-if="crm == 0"
            class="h-full w-full flex flex-col items-center justify-center"
        >
            <i class="bx bx-x-circle text-red-500 text-8xl mb-5"></i>
            <p class="font-semibold text-2xl mb-5">Nenhum registro encontrado</p>
            <a
                :href="route('crm.create')"
                class="flex justify-center items-center w-40 p-2 h-10 bg-primary rounded-xl text-white text-lg font-semibold shadow-xl hover:scale-105 transition-all"
            >
                <i class="bx bx-plus font-semibold mr-2 text-secondary"></i>
                <p class="font-medium text-secondary">Cadastrar</p>
            </a>
        </div>

        <div
            v-else
            class="h-full w-full flex flex-col"
        >
            <div class="flex justify-between items-center">
                <p class="font-medium 2xl:text-2xl text-xl">CRM Dashboard</p>
                <a
                    :href="route('crm.create')"
                    class="flex justify-center items-center w-40 p-2 h-10 mobile-std:w-14 bg-primary rounded-xl text-white text-lg font-semibold shadow-xl hover:scale-105 transition-all"
                >
                    <i class="bx bx-plus font-semibold mr-2 text-secondary mobile-std:mr-0"></i>
                    <p class="mobile-std:hidden font-medium text-secondary">Cadastrar</p>
                </a>
            </div>

            <div class="min-h-px w-full bg-primary my-4 mobile-std:my-2"></div>

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

        <NotificationModal
            :show-modal="showNotificationModal"
            :message="message"
            @close-modal="showNotificationModal = false"
        />
    </BaseLayout>
</template>

<script>
import BaseLayout from '@/Components/Layout/BaseLayout.vue';
import Databoard from '@/Components/Utils/Databoard.vue';
import CrmModal from './CrmModal.vue';
import NotificationModal from '@/Components/Utils/NotificationModal.vue';

export default {
    components: {
        BaseLayout,
        Databoard,
        CrmModal,
        NotificationModal,
    },

    props: {
        crm: {},
    },

    data() {
        return {
            message: {},
            showCrmModal: false,
            showNotificationModal: false,
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

    created() {
        setTimeout(() => {
            var flashMessage = this.$page.props.flash;

            if(flashMessage.success) {
                this.showNotificationModal = true;

                this.message = {
                    type: 'success',
                    content: flashMessage.success,
                }
            } else if (flashMessage.error) {
                this.showNotificationModal = true;

                this.message = {
                    type: 'error',
                    content: flashMessage.error,
                }
            }
        }, 200);
    },
}
</script>
