<template>
    <div class="h-screen w-screen flex">
        <Sidebar/>
        <div class="main-screen flex flex-col h-full w-full p-6 bg-gray-200 shadow-2xl">
            <div class="topbar w-full h-16 bg-white rounded-xl shadow-xl"></div>
        </div>
    </div>
</template>

<script>
    import Sidebar from '@/Components/Layout/Sidebar.vue';

    export default {
        components: {
            Sidebar
        },
    }
</script>
