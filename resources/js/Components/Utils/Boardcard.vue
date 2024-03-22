<template>
    <div
        class="boardcard flex justify-between min-h-28 bg-white rounded-lg shadow-lg hover:scale-105 transition-all mb-4 p-2"
    >
        <div class="flex flex-col justify-between">
            <a
                href="#"
                class="font-roboto font-semibold text-base"
            >
                #1 Nome
            </a>
            <p class="text-sm text-gray-500 font-medium">(99)99999-9999</p>
            <div class="flex">
                <p class="mr-2 p-1 max-w-20 text-xs font-semibold bg-blue-200 rounded-md text-blue-500">CLIENTE</p>
                <p class="mr-2 p-1 max-w-20 text-xs font-semibold bg-green-200 rounded-md text-success">ATACADO</p>
                <p class="mr-2 p-1 max-w-20 text-xs font-semibold bg-red-200 rounded-md text-danger">TIPO</p>
            </div>
        </div>
        <div class="flex justify-center items-center">
            <button
                type="button"
                class="hover:scale-125 transition-all"
            >
                <i class="bx bxs-trash text-xl 2xl:text-2xl text-danger"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {

    }
</script>
