<template>
    <div class="databoard-holder flex flex-col max-h-full min-w-[420px] border border-gray-200 rounded-xl shadow-lg mr-5 mb-4">
        <div class="databoard-header h-1/6 p-4 flex justify-between items-center border-b border-b-gray-300">
            <p class="text-2xl font-medium">Título</p>
            <i class="bx bx-show text-3xl"></i>
        </div>
        <div class="databoard-body flex-nowrap h-full p-4 flex flex-col bg-gray-100 rounded-b-lg overflow-y-auto">
            <div class="max-h-full">
                <div class="min-h-28 bg-white rounded-lg shadow-lg hover:scale-105 transition-all mb-4"></div>
                <div class="min-h-28 bg-white rounded-lg shadow-lg hover:scale-105 transition-all mb-4"></div>
                <div class="min-h-28 bg-white rounded-lg shadow-lg hover:scale-105 transition-all mb-4"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>
