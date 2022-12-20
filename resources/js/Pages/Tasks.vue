<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import { ref, computed } from "vue";
import App from "@/Layouts/App.vue";

import axios from "axios";

// let list = ref([
//     {id : 1, name : 'Tasca 1', done : false},
//     {id : 2, name : 'Tasca 2', done : false},
//     {id : 3, name : 'Tasca 3', done : false},
//     {id : 4, name : 'Tasca 4', done : true},
// ]);

// let tasks = computed (() => {
//     return list.value.filter(task => !task.done);
// });

// let done = computed (() => {
//     return list.value.filter(task => task.done);
// });

let task = ref("");
let error = ref(false);

let props = defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  tasks: Array,
  done: Array,
});

let tasks = ref(props.tasks);
let done = ref(props.done);

function add() {
  if (task.value.length == 0) {
    error.value = true;
    return;
  }
  let newTask = {
    task: task.value,
    done: false,
  };
  task.value = "";
  error.value = false;
  axios.post(route("tasks.create"), newTask).then((result) => {
    console.log(result);
    tasks.value.push(result.data);
    console.log(tasks);
  });
}

function taskDone(id) {
  //   let j = list.value.findIndex((task) => task.id == i);
  //   list.value[j].done = true;
  axios.delete(route("tasks.destroy", id)).then(function (response) {
    console.log(response);
    tasks.value = response.data.tasks;
    done.value = response.data.done;
  });
}

function taskUnDone(id) {
  //   let j = list.value.findIndex((task) => task.id == i);
  //   list.value[j].done = false;
  axios.get(route("tasks.restore", id)).then(function (response) {
    console.log(response);
    tasks.value = response.data.tasks;
    done.value = response.data.done;
  });
}
</script>

<template>
  <App>
    <div class="grid grid-cols-12 p-2">
      <div class="col-start-5 col-span-4">
        <div
          class="
            text-sm
            font-medium
            text-gray-900
            bg-white
            border border-gray-200
            dark:bg-gray-700 dark:border-gray-600 dark:text-white
          "
        >
          <div
            class="
              block
              py-2
              px-4
              w-full
              text-white
              border-b border-gray-200
              cursor-pointer
            "
          >
            <label
              for="task"
              class="
                mb-2
                text-sm
                font-medium
                text-gray-900
                sr-only
                dark:text-white
              "
              >Afegir
            </label>
            <form action="/" method="post">
              <div class="relative">
                <input
                  type="text"
                  id="task"
                  name="task"
                  class="input"
                  placeholder="Tasca..."
                  required
                  autofocus
                  v-model="task"
                />
                <button
                  type="submit"
                  class="btn btn-blue btn-in"
                  @click.prevent="add"
                >
                  Afegir
                </button>
              </div>
              <div class="task text-red-900" v-if="error">
                La tasca no pot estar en blanc!
              </div>
            </form>
          </div>
 
          <ul>
            
            <li v-for="(task) in tasks" v-bind:key="task.id">
              <div class="task">
                <div class="block pr-5">{{ task.name }}</div>
                <button @click.prevent="taskDone(task.id)" class="btn btn-red">Fet!</button>
              </div>
            </li>
            <li v-if="task != ''">
              <div class="task">
                <div class="block pr-5 text-gray-400">
          {{ task }}  
          </div>
                
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-12 p-2">
      <div class="col-start-5 col-span-4">
        <div
          class="
            text-sm
            font-medium
            text-gray-900
            bg-white
            border border-gray-200
            dark:bg-gray-700 dark:border-gray-600 dark:text-white
          "
        >
          <ul>
            <li v-for="(task) in done" v-bind:key="task.id">
              <div class="task">
                <div class="block line-through pr-5">{{ task.name }}</div>
                <a
                  href="/undone/{{ task.id }}"
                  @click.prevent="taskUnDone(task.id)"
                  class="btn btn-green"
                  >Restaura!</a
                >
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </App>
</template>

<style postcss>
.input {
  @apply block w-full p-3 pl-4 text-sm text-gray-900
         border border-gray-300 rounded-lg bg-gray-50
         focus:ring-blue-500 focus:border-blue-500
         dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
         dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500;
}

.btn {
  @apply absolute
    right-2.5
    focus:ring-4 focus:outline-none focus:ring-red-300
    font-medium
    rounded-lg 
    text-sm
    px-2
    py-1
    text-center;
}

.btn-in {
  @apply bottom-2.5  text-xs px-2 py-1;
}

.btn-green {
  @apply text-white
    bg-green-700
    hover:bg-green-800
    dark:bg-green-600
    dark:hover:bg-green-700
    dark:focus:ring-green-800;
}

.btn-red {
  @apply text-white
    bg-red-700
    hover:bg-red-800
    dark:bg-red-600
    dark:hover:bg-red-700
    dark:focus:ring-red-800;
}

.btn-blue {
  @apply text-white
    bg-blue-700
    hover:bg-blue-800
    dark:bg-blue-600
    dark:hover:bg-blue-700
    dark:focus:ring-blue-800;
}

.task {
  @apply relative
            h-16
            block
            py-4
            px-4
            w-full
            border-b border-gray-200
            cursor-pointer
            hover:bg-gray-100 hover:text-blue-700
            focus:outline-none
            focus:ring-2
            focus:ring-blue-700
            focus:text-blue-700
            dark:border-gray-600
            dark:hover:bg-gray-600
            dark:hover:text-white
            dark:focus:ring-gray-500
            dark:focus:text-white
            flex;
}
</style>
