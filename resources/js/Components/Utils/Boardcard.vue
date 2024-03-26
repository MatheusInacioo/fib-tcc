<template>
    <div
        class="boardcard flex justify-between min-h-28 bg-white rounded-lg shadow-lg hover:scale-105 transition-all mb-4 p-2"
    >
        <div class="flex flex-col justify-between">
            <div
                @click="editItem()"
                class="font-roboto font-semibold text-base cursor-pointer"
            >
                {{ item.name }}
        </div>
            <p
                v-if="item.responsible_phone && !item.phone"
                class="text-sm text-gray-500 font-medium"
            >
                {{ item.responsible_phone }}
            </p>
            <p
                v-if="item.phone && !item.responsible_phone"
                class="text-sm text-gray-500 font-medium"
            >
                {{ item.phone }}
            </p>
            <p
                v-if="item.phone && item.responsible_phone"
                class="text-sm text-gray-500 font-medium"
            >
                {{ item.responsible_phone }}
            </p>
            <div class="flex">
                <p class="mr-2 p-1 max-w-24 text-xs font-semibold bg-blue-200 rounded-md text-blue-500 uppercase">{{ item.type }}</p>
                <p class="mr-2 p-1 max-w-24 text-xs font-semibold bg-green-200 rounded-md text-success uppercase">{{ item.segment }}</p>
                <p class="mr-2 p-1 max-w-20 text-xs font-semibold bg-red-200 rounded-md text-danger uppercase">TIPO</p>
            </div>
        </div>
        <div class="flex justify-center items-center">
            <button
                type="button"
                class="hover:scale-125 transition-all"
                @click="deleteItem(item.id)"
            >
                <i class="bx bxs-trash text-xl 2xl:text-2xl text-danger"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            item: {},
        },

        data() {
            return {
                selectedItem: null,
            }
        },

        methods: {
            deleteItem() {
                this.$emit('deleteItem');
            },

            editItem() {
                this.$emit('editItem');
            },
        },
    }
</script>
