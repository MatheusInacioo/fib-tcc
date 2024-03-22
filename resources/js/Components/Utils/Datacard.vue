<template>
    <div
        :id="cardId"
        class="datacard-holder flex max-h-full min-w-[420px] border border-l-8 shadow-lg mr-5 p-2 rounded-lg"
        :class="{
            'border-l-warning' : cardId == 1,
            'border-l-blue-500' : cardId == 2,
            'border-l-success' : cardId == 3
        }"
    >
        <div class="flex flex-col w-full justify-center">
            <p
                :class="{
                    'text-warning' : cardId == 1,
                    'text-blue-500' : cardId == 2,
                    'text-success' : cardId == 3,
                }"
                class="text-2xl font-semibold"
            >
                {{ cardTitle }}
            </p>
            <p>0</p>
        </div>
        <div class="w-1/4 flex items-center justify-center">
            <i
            class="text-8xl"
            :class="{
                'text-warning' : cardId == 1,
                'text-blue-500' : cardId == 2,
                'text-success' : cardId == 3,
                'bx bx-error' : cardId == 1,
                'bx bx-package' : cardId == 2,
                'bx bx-dollar' : cardId == 3,
            }"
        ></i>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        cardId: {},
    },

    computed: {
        cardTitle() {
            switch(this.cardId) {
                case 1:
                    return 'AVISOS';
                case 2:
                    return 'PRODUTOS';
                case 3:
                    return 'FATURAMENTO';
                default:
                    return 'TÍTULO';
            }
        }
    }
}
</script>
