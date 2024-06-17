<template>
    <div
        class="boardcard flex justify-between min-h-28 bg-white rounded-lg shadow-lg hover:scale-105 transition-all mb-4 p-2"
    >
        <div class="flex flex-col justify-between">
            <a
                :href="route('crm.edit', item.id)"
                class="font-roboto font-semibold text-base cursor-pointer"
            >
                {{'#' + item.id + ' ' + item.name }}
            </a>
            <p
                v-if="item.responsible_phone && !item.phone"
                class="text-xs text-gray-500 font-medium"
            >
                {{ item.responsible_phone }}
            </p>
            <p
                v-if="item.phone && !item.responsible_phone"
                class="text-xs text-gray-500 font-medium"
            >
                {{ item.phone }}
            </p>
            <p
                v-if="item.phone && item.responsible_phone"
                class="text-xs text-gray-500 font-medium"
            >
                {{ item.responsible_phone }}
            </p>
            <div class="flex">
                <p class="mr-2 p-1 max-w-24 text-xs font-semibold bg-blue-500 rounded-md text-white uppercase">{{ item.type }}</p>
                <p class="mr-2 p-1 max-w-24 text-xs font-semibold bg-success rounded-md text-white uppercase">{{ item.segment }}</p>
                <p class="mr-2 p-1 max-w-20 text-xs font-semibold bg-danger rounded-md text-white uppercase">{{ item.last_update }}</p>
            </div>
        </div>
        <div class="flex justify-center items-center">
            <button
                v-if="userHasPermission('delete', 'crm')"
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
        },
    }
</script>
