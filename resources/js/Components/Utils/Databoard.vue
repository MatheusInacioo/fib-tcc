<template>
    <div class="databoard-holder flex flex-col max-h-full min-w-[420px] border border-gray-200 rounded-xl shadow-lg mr-5 mb-4 mobile-std:min-w-[350px]">
        <div class="databoard-header h-1/6 p-4 flex justify-between items-center rounded-t-lg bg-primary">
            <p class="text-2xl font-medium text-secondary">{{ title }}</p>
            <i
                class="text-3xl text-secondary bx"
                :class="{
                    'bxs-message-dots' : title == 'Contato',
                    'bxs-briefcase-alt' : title == 'Negociação',
                    'bxs-edit-alt' : title == 'Assinatura Pendente',
                    'bxs-stopwatch' : title == 'Standby',
                    'bx-block' : title == 'Sem Interesse',
                }"
            ></i>
        </div>
        <div class="databoard-body flex-nowrap h-full p-4 flex flex-col bg-gray-100 rounded-b-lg overflow-y-auto scrollbar-thin">
            <div
                v-if="filteredItems.length > 0"
                class="max-h-full"
            >
                <Boardcard
                    v-for="item in filteredItems"
                    :key="item.id"
                    :item="item"
                    @edit-item="editItem(item)"
                    @delete-item="deleteItem(item.id)"
                />
            </div>

            <div
                v-else
                class="flex justify-center items-center w-full h-full"
            >
                <span class="text-xl font-medium">Nenhum registro encontrado...</span>
            </div>
        </div>

        <ConfirmationModal
            :show-modal="showConfirmationModal"
            @confirm-delete="confirmDelete()"
            @close-modal="toggleConfirmationModal()"
        />
    </div>
</template>

<script>
    import Boardcard from '@/Components/Utils/Boardcard.vue';
    import ConfirmationModal from '@/Components/Utils/ConfirmationModal.vue';

    export default {
        components: {
            Boardcard,
            ConfirmationModal,
        },

        props: {
            title: '',
            crm: {},
        },

        data() {
            return {
                showConfirmationModal: false,
                selectedItem: {},
            }
        },

        computed: {
            filteredItems() {
                return this.crm.filter(item => item.status === this.title);
            },
        },

        methods: {
            toggleConfirmationModal() {
                this.showConfirmationModal = ! this.showConfirmationModal;
            },

            editItem(item) {
                this.selectedItem = item;

                this.toggleCrmModal();
            },

            deleteItem(itemId) {
                this.toggleConfirmationModal();
                this.selectedItem = itemId;
            },

            async confirmDelete() {
                try {
                    await axios.post(this.route('crm.destroy', this.selectedItem));

                    this.selectedItem = null;
                    this.toggleConfirmationModal();

                    window.location.reload();
                } catch (error) {
                    console.error(error);
                }
            },
        },
    }
</script>
