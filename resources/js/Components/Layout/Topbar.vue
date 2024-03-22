<template>
    <div class="topbar flex justify-end items-center h-16 bg-white 2xl:mb-4 mb-2 px-5 rounded-xl shadow-lg border border-gray-200">
         <div class="max-w-[500px] dropdown-holder flex flex-col">
             <div
                 @click="toggleDropdown = !toggleDropdown"
                 class="user-dropdown flex h-10 items-center transition-all hover:scale-110"
             >
                <i
                    :class="{
                        'bx bx-chevron-down' : !toggleDropdown,
                        'bx bx-chevron-up' : toggleDropdown,
                    }"
                    class="mr-1 text-2xl"
                ></i>
                <p class="text-base 2xl:text-lg font-medium mr-2">{{ userName }}</p>
                <i class="bx bx-user-circle 2xl:text-4xl text-3xl"></i>
             </div>

             <transition name="dropdown">
                 <div
                     v-if="toggleDropdown"
                     class="absolute top-[75px] right-[30px] flex flex-col min-w-[200px] max-w-[500px] z-10 bg-white border border-gray-200 shadow-lg rounded-b-xl"
                 >
                    <div class="flex p-4 border-b border-b-gray-300 bg-orange-500">
                        <div class="flex hover:scale-110 transition-all cursor-pointer">
                            <i class="bx bxs-user-circle 2xl:text-4xl text-white text-3xl mr-2"></i>
                            <div class="flex flex-col">
                                <p class="text-xs 2xl:text-base text-white font-semibold mr-2">{{ userName }}</p>
                                <small class="text-white">Admin</small>
                            </div>
                        </div>
                    </div>
                     <div
                         v-for="button in buttons"
                         :key="button.id"
                         class="group px-2"
                     >
                         <a
                             :href="route(button.route)"
                             :class="{ 'hover:rounded-b-lg' : button.title == 'Sair' }"
                             class="flex items-center hover:bg-gray-200 transition-all hover:scale-110 px-4 py-2"
                         >
                             <i :class="button.icon + ' mr-3 text-base 2xl:text-xl text-gray-800'"></i>
                             <p class="text-sm 2xl:text-base font-medium text-gray-800"> {{ button.title }} </p>
                         </a>
                     </div>
                 </div>
             </transition>
         </div>
     </div>
 </template>

 <script>
 export default {
    data() {
        return {
           userName: this.$page.props.auth.user.name,
           toggleDropdown: false,
           buttons: [
               {
                   title: 'Usuários',
                   icon: 'bx bx-group',
                   route: 'users.index',
               },
               {
                   title: 'Configurações',
                   icon: 'bx bx-cog',
                   route: 'dashboard.index',
               },
               {
                   title: 'Sair',
                   icon: 'bx bx-log-out',
                   route: 'login.destroy',
               },
           ],
        }
    },
 };
 </script>

 <style scoped>
    .dropdown-enter-active,
    .dropdown-leave-active {
        transition: all 0.3s cubic-bezier(0.52, 0.02, 0.19, 1.02);
    }

    .dropdown-enter-from,
    .dropdown-leave-to {
        opacity: 0;
        transform: translateY(-20px);
    }

    .dropdown-enter-to,
    .dropdown-leave-from {
        opacity: 1;
        transform: translateY(0);
    }
 </style>
