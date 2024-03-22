<template>
    <div class="databoard-holder flex flex-col max-h-full min-w-[420px] border border-gray-200 rounded-xl shadow-lg mr-5 mb-4">
        <div class="databoard-header h-1/6 p-4 flex justify-between items-center rounded-t-lg bg-primary">
            <p class="text-2xl font-medium text-secondary">{{ title }}</p>
            <i class="bx bx-show text-3xl text-secondary"></i>
        </div>
        <div class="databoard-body flex-nowrap h-full p-4 flex flex-col bg-gray-100 rounded-b-lg overflow-y-auto scrollbar-thin">
            <div class="max-h-full">
                <Boardcard/>
            </div>
        </div>
    </div>
</template>

<script>
    import Boardcard from '@/Components/Utils/Boardcard.vue';

    export default {
        components: {
            Boardcard,
        },

        props: {
            title: '',
            data: {},
        }
    }
</script>
