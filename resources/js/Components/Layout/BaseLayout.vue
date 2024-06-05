<template>
    <div class="h-screen w-screen flex font-roboto">
        <Sidebar/>
        <div class="main-screen flex flex-col h-full w-full 2xl:p-4 2xl:pb-2 p-3 bg-gray-100 overflow-hidden">
            <Topbar/>
            <div class="flex flex-col w-full h-full bg-white rounded-xl shadow-lg 2xl:p-4 p-2 border border-gray-200 overflow-y-auto scrollbar-thin">
                <slot></slot>
            </div>
            <span class="text-gray-500 mt-2 text-sm">{{'© ' + $page.props.auth.year + ' | Desenvolvido por - Estoque' }}</span>
        </div>
    </div>
</template>

<script>
    import Sidebar from '@/Components/Layout/Sidebar.vue';
    import Topbar from '@/Components/Layout/Topbar.vue';

    export default {
        components: {
            Sidebar,
            Topbar,
        },
    }
</script>
