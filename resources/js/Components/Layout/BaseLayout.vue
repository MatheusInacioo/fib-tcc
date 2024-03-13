<template>
    <div class="h-screen w-screen flex">
        <Sidebar/>
        <div class="main-screen flex flex-col h-full w-full p-6 bg-gray-100 shadow-2xl">
            <div class="topbar flex justify-end items-center w-full h-16 bg-white mb-4 px-5 rounded-xl shadow-xl">
                <div class="user-dropdown flex w-auto h-10 items-center transition-all hover:scale-110">
                    <p class="text-lg font-bold mr-2">{{ $page.props.auth.user.name }}</p>
                    <i class="bx bx-user-circle text-4xl"></i>
                </div>
            </div>
            <slot></slot>
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
