<template>
    <div class="rounded-xl shadow-lg border border-gray-200">
        <div class="flex w-full items-center justify-between px-4 py-2">
            <div class="flex items-center mobile-std:hidden">
                <button
                    type="button"
                    @click="goBack()"
                >
                    <i class="bx bx-left-arrow-alt text-3xl hover:scale-110 transition-all mr-2"></i>
                </button>
                <p class="font-medium 2xl:text-2xl text-xl mr-4">{{ settings.title }}</p>

                <div class="flex items-center 2xl:w-80 w-64 ml-4 my-4 bg-white rounded-lg border border-gray-200 hover:border-gray-500 transition-all">
                    <input
                        type="text"
                        v-model="searchQuery"
                        placeholder="Buscar Registros..."
                        class="w-full border-none focus:outline-none rounded-l-lg"
                    >
                    <i class="bx bx-search text-lg 2xl:text-xl mx-2"></i>
                </div>
            </div>

            <div class="web:hidden mobile-lg:hidden flex flex-col w-full">
                <div class="flex w-full items-center justify-between mb-4">
                    <div class="flex items-center">
                        <button
                            type="button"
                            @click="goBack()"
                        >
                            <i class="bx bx-left-arrow-alt text-2xl hover:scale-110 transition-all mr-2"></i>
                        </button>

                        <span class="font-medium 2xl:text-2xl text-xl">{{ settings.title }}</span>
                    </div>

                    <div class="flex">
                        <a
                            v-if="userHasPermission('export', settings.subject)"
                            :href="route(settings.routes.create)"
                            class="flex justify-center items-center w-14 h-10 bg-primary rounded-xl text-white p-2 text-base font-semibold shadow-xl hover:scale-105 transition-all mr-2"
                        >
                            <i class="bx bxs-download text-xl font-semibold text-secondary"></i>
                        </a>

                        <a
                            v-if="userHasPermission('create', settings.subject)"
                            :href="route(settings.routes.create)"
                            class="flex justify-center items-center w-14 h-10 bg-primary rounded-xl text-white p-2 text-base font-semibold shadow-xl hover:scale-105 transition-all"
                        >
                            <i class="bx bx-plus text-xl font-semibold text-secondary"></i>
                        </a>
                    </div>
                </div>

                <div class="flex items-center w-full bg-white rounded-lg border border-gray-200 hover:border-gray-500 transition-all">
                    <input
                        type="text"
                        v-model="searchQuery"
                        placeholder="Buscar Registros..."
                        class="w-full border-none focus:outline-none rounded-l-lg"
                    >
                    <i class="bx bx-search text-lg 2xl:text-xl mx-2"></i>
                </div>
            </div>

            <div class="flex">
                <a
                    v-if="userHasPermission('export', settings.subject)"
                    :href="route(settings.routes.create)"
                    class="flex justify-center items-center w-auto 2xl:h-10 bg-primary rounded-xl text-white p-2 text-base 2xl:text-lg font-semibold shadow-xl hover:scale-105 transition-all mobile-std:hidden mr-2"
                >
                    <i class="bx bxs-download font-semibold mr-2 text-secondary"></i>
                    <p class="font-medium text-secondary">Exportar</p>
                </a>

                <a
                    v-if="userHasPermission('create', settings.subject)"
                    :href="route(settings.routes.create)"
                    class="flex justify-center items-center w-auto 2xl:h-10 bg-primary rounded-xl text-white p-2 text-base 2xl:text-lg font-semibold shadow-xl hover:scale-105 transition-all mobile-std:hidden"
                >
                    <i class="bx bx-plus font-semibold mr-2 text-secondary"></i>
                    <p class="font-medium text-secondary">{{ settings.button_title }}</p>
                </a>
            </div>
        </div>

        <div class="flex max-h-[450px] 2xl:max-h-full overflow-y-auto w-full">
            <table class="min-w-full divide-y h-full divide-gray-200 border border-gray-200">
                <thead class="bg-gray-200 w-full">
                    <tr>
                        <th
                            v-for="(column, index) in settings.columns"
                            :key="index"
                            @click="sort(index)"
                            :class="{ 'sortable cursor-pointer' : column.sortable, 'text-center' : index > 0 }"
                            class="px-6 py-3 text-left text-sm 2xl:text-base font-bold text-gray-500 uppercase tracking-wider"
                        >
                            <span
                                :class="{
                                    'hidden' : column.name == 'actions' && ! userHasPermission('edit', settings.subject) || userHasPermission('delete', settings.subjetct)
                                }"
                            >
                                {{ column.label }}
                            </span>
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
                            v-for="(column, i) in settings.columns"
                            :key="i"
                            class="px-6 py-1 text-sm 2xl:text-base 2xl:py-3"
                            :class="{ 'text-center' : i > 0 }"
                        >
                            {{ item[column.name]}}
                            <div
                                v-if="column.name == 'actions'"
                                class="flex justify-center"
                            >
                                <a
                                    v-if="settings.subject == 'transactions'"
                                    :href="route(settings.routes.view, item.id)"
                                    class="hover:scale-125 transition-all"
                                >
                                    <i class="bx bx-show text-lg mr-2 2xl:mr-3 2xl:text-xl text-gray-400"></i>
                                </a>
                                <a
                                    v-if="settings.subject != 'transactions' && userHasPermission('edit', settings.subject)"
                                    :href="route(settings.routes.edit, item.id)"
                                    class="hover:scale-125 transition-all"
                                >
                                    <i class="bx bxs-edit text-lg mr-2 2xl:mr-3 2xl:text-xl text-gray-400"></i>
                                </a>
                                <button
                                    v-if="userHasPermission('delete', settings.subject)"
                                    type="button"
                                    @click="deleteItem(item.id)"
                                    class="hover:scale-125 transition-all"
                                >
                                    <i class="bx bxs-trash text-lg 2xl:text-xl text-danger"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            class="w-full py-4 flex justify-between items-center"
        >
            <p class="mobile-std:hidden font-medium text-base ml-6">Página {{ currentPage }} de {{ totalPages }}</p>
            <p class="web:hidden mobile-lg:hidden font-medium text-sm 2xl:text-base ml-6">{{ currentPage }} de {{ totalPages }}</p>
            <div
                v-if="data.length > itemsPerPage"
                class="flex px-4"
            >
                <div class="border rounded-lg flex divide-x ">
                    <button
                        @click="firstPage"
                        :disabled="currentPage === 1"
                        class=" flex items-center hover:scale-110 hover:bg-gray-200 transition-all text-black backdrop:font-bold"
                    >
                        <i class="bx bx-chevrons-left text-2xl mobile-std:text-xl"></i>
                    </button>
                    <button
                        @click="previousPage"
                        :disabled="currentPage === 1"
                        class=" flex items-center hover:scale-110 hover:bg-gray-200 transition-all text-black backdrop:font-bold"
                    >
                        <i class="bx bx-chevron-left text-2xl mobile-std:text-xl"></i>
                    </button>
                    <template v-if="totalPages <= 5">
                        <button
                            v-for="page in totalPages"
                            :key="page"
                            class="w-6 flex items-center justify-center hover:scale-110 hover:bg-gray-200 transition-all text-black backdrop:font-bold"
                            @click="goToPage(page)"
                        >
                            {{ page }}
                        </button>
                    </template>
                    <template v-else>
                        <template v-if="currentPage < 4">
                            <button
                                v-for="page in 5"
                                :key="page"
                                class="w-6 flex items-center justify-center hover:scale-110 hover:bg-gray-200 transition-all text-black backdrop:font-bold"
                                @click="goToPage(page)"
                            >
                                {{ page }}
                            </button>
                        </template>
                        <template v-else-if="currentPage > totalPages - 3">
                            <button
                                v-for="page in 5"
                                :key="page"
                                class="w-6 flex items-center justify-center hover:scale-110 hover:bg-gray-200 transition-all text-black backdrop:font-bold"
                                @click="goToPage(totalPages - 5 + page)"
                            >
                                {{ totalPages - 5 + page }}
                            </button>
                        </template>
                        <template v-else>
                            <button
                                v-for="page in 5"
                                :key="page"
                                class="w-6 flex items-center justify-center hover:scale-110 hover:bg-gray-200 transition-all text-black backdrop:font-bold"
                                @click="goToPage(currentPage - 3 + page)"
                            >
                                {{ currentPage - 3 + page }}
                            </button>
                        </template>
                    </template>
                    <button
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                        class=" flex items-center hover:scale-110 hover:bg-gray-200 transition-all text-black font-bold"
                    >
                        <i class="bx bx-chevron-right text-2xl mobile-std:text-xl"></i>
                    </button>
                    <button
                        @click="lastPage"
                        :disabled="currentPage === totalPages"
                        class=" flex items-center hover:scale-110 hover:bg-gray-200 transition-all text-black font-bold"
                    >
                        <i class="bx bx-chevrons-right text-2xl mobile-std:text-xl"></i>
                    </button>
                </div>
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
        settings: {},

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
                const column = this.settings.columns[this.sortColumn];

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
                return this.settings.columns.some(column => {
                    if (column.searchable) {
                        const value = item[column.name];

                        return String(value).toLowerCase().includes(query);
                    }

                    return false;
                });
            });
        },
    },

    methods: {
        sort(index) {
            const column = this.settings.columns[index];

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

        firstPage() {
            if (this.currentPage > 1) {
                this.currentPage = 1;
            }
        },

        previousPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },

        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },

        lastPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage = this.totalPages;
            }
        },

        goToPage(page) {
            this.currentPage = page;
        },

        deleteItem(itemId) {
            this.toggleModal();
            this.selectedItem = itemId;
        },

        async confirmDelete() {
            try {
                await axios.post(this.route(this.settings.routes.delete, this.selectedItem));

                this.selectedItem = null;
                this.toggleModal();

                window.location.reload();
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
