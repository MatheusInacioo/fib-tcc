<template>
   <div class="topbar flex justify-end items-center w-full h-16 bg-white 2xl:mb-4 mb-2 px-5 rounded-xl shadow-lg border border-gray-200">
        <div class="user-dropdown flex w-auto h-10 items-center transition-all hover:scale-110">
            <p class="text-base 2xl:text-lg font-medium mr-2">{{ $page.props.auth.user.name }}</p>
            <i class="bx bx-user-circle 2xl:text-4xl text-3xl"></i>
        </div>
    </div>
</template>

<script>
    export default {

    }
</script>
