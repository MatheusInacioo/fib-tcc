<template>
    <div class="databoard-holder flex flex-col max-h-full min-w-[420px] border border-gray-200 rounded-xl shadow-lg mr-5 mb-4">
        <div class="databoard-header h-1/6 p-4 flex justify-between items-center rounded-t-lg bg-primary">
            <p class="text-2xl font-medium text-secondary">{{ title }}</p>
            <i class="bx bx-show text-3xl text-secondary"></i>
        </div>
        <div class="databoard-body flex-nowrap h-full p-4 flex flex-col bg-gray-100 rounded-b-lg overflow-y-auto scrollbar-thin">
            <div class="max-h-full">
                <Boardcard
                    v-for="item in filteredItems"
                    :key="item.id"
                    :item="item"
                    @edit-item="editItem(item)"
                    @delete-item="deleteItem(item.id)"
                />
            </div>
        </div>

        <ConfirmationModal
            :show-modal="showConfirmationModal"
            @confirm-delete="confirmDelete()"
            @close-modal="toggleConfirmationModal()"
        />

        <CrmModal
            :show-modal="showCrmModal"
            :item="selectedItem"
            @close-modal="toggleCrmModal()"
        />
    </div>
</template>

<script>
    import Boardcard from '@/Components/Utils/Boardcard.vue';
    import ConfirmationModal from '@/Components/Utils/ConfirmationModal.vue';
    import CrmModal from '@/Pages/Crm/CrmModal.vue'

    export default {
        components: {
            Boardcard,
            ConfirmationModal,
            CrmModal,
        },

        props: {
            title: '',
            crm: {},
        },

        data() {
            return {
                showConfirmationModal: false,
                showCrmModal: false,
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

            toggleCrmModal() {
                this.showCrmModal = ! this.showCrmModal;
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
