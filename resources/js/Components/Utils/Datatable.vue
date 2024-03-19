<template>
    <div class="rounded-xl shadow-lg border border-gray-200 ">
        <div class="flex items-center justify-between px-4 py-2">
            <div class="flex items-center">
                <p class="font-medium 2xl:text-2xl text-xl mr-4">{{ info.title }}</p>

                <div class="flex items-center border-b border-orange-500 2xl:w-80 w-64 ml-4 my-4">
                    <input
                        type="text"
                        v-model="searchQuery"
                        placeholder="Buscar..."
                        class="w-full border-none focus:outline-none"
                    >
                    <i class="bx bx-search text-lg 2xl:text-xl"></i>
                </div>
            </div>

            <a
                :href="route(info.button.route)"
                class="flex justify-center items-center 2xl:w-40 2xl:h-10 bg-orange-500 rounded-xl text-white p-2 text-base 2xl:text-lg font-poppins font-semibold shadow-xl hover:scale-105 transition-all"
            >
                <i :class="info.button.icon + ' font-semibold mr-2'"></i>
                <p class="font-medium">{{ info.button.title }}</p>
            </a>
        </div>

        <div class="h-px bg-orange-500 mb-4 mx-4"></div>

        <div class="flex max-h-[450px] 2xl:max-h-full overflow-y-auto w-full">
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th
                            v-for="(column, index) in columns"
                            :key="index"
                            @click="sort(index)"
                            :class="{ 'sortable' : column.sortable, 'text-center' : index > 0 }"
                            class="px-6 py-3 text-left text-sm 2xl:text-base font-bold text-gray-500 uppercase tracking-wider"
                        >
                            {{ column.label }}
                            <span v-if="column.sortable">
                                <span
                                    v-if="sortColumn === index && sortOrder === 'asc'"
                                    class="ml-1"
                                >
                                    <i class="bx bx-up-arrow-alt"></i>
                                </span>
                                <span
                                    v-else-if="sortColumn === index && sortOrder === 'desc'"
                                    class="ml-1"
                                >
                                    <i class="bx bx-down-arrow-alt"></i>
                                </span>
                            </span>
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    <tr
                        v-for="(item, index) in paginatedData"
                        :key="index"
                        class="hover:bg-gray-100 transition-all"
                    >
                        <td
                            v-for="(column, i) in columns"
                            :key="i"
                            class="px-6 py-1 text-xs 2xl:text-base 2xl:py-3"
                            :class="{ 'text-center' : i > 0 }"
                        >
                            {{ item[column.name]}}
                            <div
                                v-if="column.name == 'actions'"
                                class="flex justify-center"
                            >
                                <a
                                    :href="route('customers.edit', item.id)"
                                    class="hover:scale-110 transition-all"
                                >
                                    <i class="bx bxs-edit text-lg mr-2 2xl:mr-3 2xl:text-xl text-gray-400"></i>
                                </a>
                                <button
                                    type="button"
                                    @click="deleteItem(item.id)"
                                    class="hover:scale-110 transition-all"
                                >
                                    <i class="bx bxs-trash text-lg 2xl:text-xl text-red-500"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            class="w-full my-4 flex justify-between items-center"
        >
            <p class="font-medium text-sm 2xl:text-base ml-6">Página {{ currentPage }} de {{ totalPages }}</p>
            <div
                v-if="data.length > itemsPerPage"
                class="flex"
            >
                <button
                    @click="previousPage"
                    :disabled="currentPage === 1"
                    class=" flex items-center hover:scale-110 transition-all text-black backdrop:font-bold py-2 px-4"
                >
                    <i class="bx bx-chevron-left"></i>
                    <p class="font-medium text-sm 2xl:text-base">Anterior</p>
                </button>
                <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    class=" flex items-center hover:scale-110 transition-all text-black font-bold py-2 px-4"
                >
                    <p class="font-medium text-sm 2xl:text-base">Próxima</p>
                    <i class="bx bx-chevron-right"></i>
                </button>
            </div>
        </div>

        <ConfirmationModal
            :show-modal="showModal"
            @confirm-delete="confirmDelete()"
            @close-modal="toggleModal()"
        />
    </div>
</template>

<script>
import ConfirmationModal from '@/Components/Utils/ConfirmationModal.vue';

export default {
    components: {
        ConfirmationModal,
    },

    props: {
        info: {},

        columns: {
            type: Array,
            default: () => []
        },

        data: {
            type: Array,
            default: () => []
        },

        itemsPerPage: {
            type: Number,
            default: 10
        },
    },

    data() {
        return {
            showModal: false,
            selectedItem: null,
            currentPage: 1,
            sortColumn: null,
            sortOrder: null,
            searchQuery: ''
        };
    },

    computed: {
        paginatedData() {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;

            return this.filteredData.slice(startIndex, endIndex);
        },

        totalPages() {
            return Math.ceil(this.filteredData.length / this.itemsPerPage);
        },

        sortedData() {
            if (this.sortColumn !== null) {
                const column = this.columns[this.sortColumn];

                return this.data.slice().sort((a, b) => {
                    let comparison = 0;

                    if (a[column.name] > b[column.name]) {
                        comparison = 1;
                    } else if (a[column.name] < b[column.name]) {
                        comparison = -1;
                    }

                    return this.sortOrder === 'desc' ? comparison * -1 : comparison;
                });
            } else {
                return this.data.slice().sort((a, b) => a.id - b.id);
            }
        },

        filteredData() {
            const query = this.searchQuery.toLowerCase().trim();

            if (!query) {
                return this.sortedData;
            }

            return this.sortedData.filter(item => {
                return this.columns.some(column => {
                    if (column.searchable) {
                        const value = item[column.name];

                        return String(value).toLowerCase().includes(query);
                    }

                    return false;
                });
            });
        }
    },

    methods: {
        sort(index) {
            const column = this.columns[index];

            if (column.sortable) {
                if (this.sortColumn === index) {
                    if (this.sortOrder === 'asc') {
                        this.sortOrder = 'desc';
                    } else if (this.sortOrder === 'desc') {
                        this.sortColumn = null;
                        this.sortOrder = null;
                    }
                } else {
                    this.sortColumn = index;
                    this.sortOrder = 'asc';
                }
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },

        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

        setDeletionRoute() {
            var tableTitle = this.info.title;

            switch(tableTitle) {
                case "Clientes":
                    return 'customers.destroy'
                case "Fornecedores":
                    return 'suppliers.destroy'
                default:
                    null;
            }
        },

        deleteItem(itemId) {
            this.toggleModal();
            this.selectedItem = itemId;
        },

        async confirmDelete() {
            try {
                var deletionRoute = this.setDeletionRoute();

                await axios.post(this.route(deletionRoute, this.selectedItem));

                this.selectedItem = null;
                this.toggleModal();
            } catch (error) {
                console.error(error);
            }
        },

        toggleModal() {
            this.showModal = ! this.showModal;
        },
    },
};
</script>
