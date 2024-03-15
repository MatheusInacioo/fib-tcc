<template>
   <div class="topbar flex justify-end items-center w-full h-16 bg-white mb-4 px-5 rounded-xl shadow-lg border border-gray-200">
        <div class="user-dropdown flex w-auto h-10 items-center transition-all hover:scale-110">
            <p class="text-lg font-medium mr-2">{{ $page.props.auth.user.name }}</p>
            <i class="bx bx-user-circle text-4xl"></i>
        </div>
    </div>
</template>

<script>
    export default {

    }
</script>
