<template>
    <BaseLayout>
        <p class="font-medium 2xl:text-3xl text-xl mr-4 mb-4">Dashboard</p>
        <div class="flex h-full overflow-y-auto">
            <div class="flex h-1/3">
                <Datacard
                    v-for="card in cardsSettigs"
                    :key="card.id"
                    :settings="cardsSettigs"
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

        data() {
            return {
                cardsSettings: [
                    {
                        color: 'yellow',
                        icon: 'bx-error',
                    },
                    {
                        color: 'blue',
                        icon: 'bx-package',
                    },
                    {
                        color: 'green',
                        icon: 'bx-dollar',
                    },
                ],
            }
        },
    }
</script>
