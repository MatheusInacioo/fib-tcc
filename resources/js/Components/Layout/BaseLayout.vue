<template>
    <div class="h-screen w-screen flex font-roboto">
        <Sidebar/>
        <div class="main-screen flex flex-col h-full w-full p-4 bg-gray-200">
            <Topbar/>
            <div class=" flex flex-col w-full h-full bg-white rounded-xl shadow-lg p-4">
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
