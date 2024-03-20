<template>
    <div :class="`datacard-holder flex max-h-full min-w-[420px] border border-l-8 border-l-${settings.color}-500 shadow-lg mr-5 p-2`">
        <div class="flex flex-col w-full "></div>
        <div class="w-1/4 flex items-center justify-center">
            <i class="bx bxs-error text-8xl text-yellow-500"></i>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        settings: {
            type: Array,
            default: () => []
        },
    },
}
</script>
