<template>
    <BaseLayout>
        <p class="font-medium 2xl:text-3xl text-xl mr-4">Início</p>

        <div class="h-px bg-orange-500 my-4"></div>

        <div class="flex h-full overflow-x-auto">
            <Databoard v-for="board in boards"/>
        </div>
    </BaseLayout>
</template>

<script>
    import BaseLayout from '@/Components/Layout/BaseLayout.vue';
    import Databoard from '@/Components/Utils/Databoard.vue';

    export default {
        components: {
            BaseLayout,
            Databoard,
        },

        data() {
            return {
                boards: [0, 1, 2, 3, 4, 5],
            }
        },
    }
</script>
