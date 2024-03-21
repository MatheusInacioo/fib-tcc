<template>
    <BaseLayout>
        <p class="font-medium 2xl:text-2xl text-xl mr-4 mb-4">Dashboard</p>
        <div class="flex h-full overflow-y-auto">
            <div class="flex h-1/3">
                <Datacard
                    v-for="index in 3"
                    :key="index"
                    :card-id="index"
                />
            </div>
        </div>
    </BaseLayout>
</template>

<script>
    import BaseLayout from '@/Components/Layout/BaseLayout.vue';
    import Datacard from '@/Components/Utils/Datacard.vue';

    export default {
        components: {
            BaseLayout,
            Datacard,
        },

        props: {

        },
    }
</script>
