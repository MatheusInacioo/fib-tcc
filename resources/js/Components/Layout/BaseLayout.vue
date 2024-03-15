<template>
    <div class="h-screen w-screen flex font-poppins">
        <Sidebar/>
        <div class="main-screen flex flex-col h-full w-full p-4 bg-gray-100">
            <Topbar/>
            <div class=" flex flex-col w-full h-full bg-white rounded-xl shadow-lg p-4 border border-gray-200">
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
