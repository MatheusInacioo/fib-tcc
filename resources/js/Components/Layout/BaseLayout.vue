<template>
    <div class="h-screen w-screen flex font-poppins">
        <Sidebar/>
        <div class="main-screen flex flex-col h-full w-full 2xl:p-4 p-3 bg-gray-100 overflow-hidden">
            <Topbar/>
            <div class="flex flex-col w-full h-full bg-white rounded-xl shadow-lg 2xl:p-4 p-2 border border-gray-200">
                <slot></slot>
            </div>
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
