<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref, computed } from "vue";
</script>

<template>
  <div class="min-h-screen bg-gray-100">
  <nav class="bg-red-500 border-gray-200 px-1 sm:px-2 py-1 dark:bg-gray-900">
    <div class="container flex flex-wrap justify-between items-center mx-auto">
      <a href="/" class="flex items-center">
        <span
          class="
            self-center
            text-lg text-white
            font-semibold
            whitespace-nowrap
            dark:text-white
          "
          >Todo APP</span
        >
      </a>
      <div class="md:block md:w-auto" id="navbar-default">
        <ul
          class="
            flex flex-col
            p-1
            mt-2
            md:flex-row
            md:space-x-8
            md:mt-0
            md:text-sm
            md:font-medium
            md:border-0
            dark:bg-gray-800
            md:dark:bg-gray-900
            dark:border-gray-700
          "
        >
          <template v-if="$page.props.auth.user">
            <li>
              <Link
                :href="route('profile.edit')"
                class="py-2 pr-4 pl-3 text-white md:p-0 dark:text-white"
                >Perfil</Link
              >
            </li>
            <li>
              <Link
                :href="route('logout')"
                method="post"
                as="button" 
                type="button"
                class="py-2 pr-4 pl-3 text-white md:p-0 dark:text-white"
                >Logout ({{ $page.props.auth.user.name  }})</Link
              >
            </li>
          </template>
          <template v-else>
            <li>
              <Link
                :href="route('login')"
                class="py-2 pr-4 pl-3 text-white md:p-0 dark:text-white"
                >Login</Link
              >
            </li>
            <li>
              <Link
                
                :href="route('register')"
                class="py-2 pr-4 pl-3 text-white md:p-0 dark:text-white"
                >Registre</Link
              >
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-2 mx-auto">
    <slot></slot>
  </div>
  </div>
</template>
