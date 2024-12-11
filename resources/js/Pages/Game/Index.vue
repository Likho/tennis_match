<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3"
                >
                    <div class="flex lg:col-start-2 lg:justify-center">
                        <svg class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]"
                             viewBox="0 0 62 65"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill="currentColor" d="M18 15a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 2a2 2 0 0 0-2 2a2 2 0 0 0 2 2a2 2 0 0 0 2-2a2 2 0 0 0-2-2M6.05 14.54s1.41-1.42 1.42-4.24c-.36-2.19.5-4.76 2.47-6.72C12.87.65 17.14.17 19.5 2.5c2.33 2.36 1.85 6.63-1.08 9.56c-1.96 1.97-4.53 2.83-6.72 2.47c-2.82.01-4.24 1.42-4.24 1.42l-4.24 4.24l-1.41-1.41zM18.07 3.93C16.5 2.37 13.5 2.84 11.35 5c-2.14 2.14-2.62 5.15-1.06 6.71c1.57 1.56 4.57 1.08 6.71-1.06c2.16-2.15 2.63-5.15 1.07-6.72"/></svg>
                    </div>
                </header>


                <main class="mt-6">
                    <div class="grid grid-cols-5 gap-3">
                        <div class="col-span-4">
                            <div class="relative overflow-x-auto">
                                <div class="col-span-4">
                                    <div v-show="gameStartSuccess" id="toast-success" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                            </svg>
                                            <span class="sr-only">Check icon</span>
                                        </div>
                                        <div class="ms-3 text-sm font-normal">{{ successMessage }}</div>
                                    </div>

                                    <div v-show="gameStartFail" id="toast-danger" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                                        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                                            </svg>
                                            <span class="sr-only">Error icon</span>
                                        </div>
                                        <div class="ms-3 text-sm font-normal">{{  failMessage }}</div>
                                    </div>
                                </div>
                                <div class="col-span-1">
                                    <button v-show="startGame" data-modal-target="select-modal" @click="startNewGame($event)" data-modal-toggle="select-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 float-right" type="button">
                                        Start New Game
                                    </button>
                                </div>

                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            ID
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            STATUS
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            PLAYER 1
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            PLAYER 2
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            ACTIONS
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="!games.length" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-6 py-4 col-span-4">
                                                <span class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">No games currently, Create new game!!</span>
                                            </td>

                                        </tr>
                                        <tr v-for="game in games" :key="game.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ game.id }}
                                            </th>
                                            <td class="px-6 py-4">
                                                <span v-if="game.status === 'in_progress'" class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">IN PROGRESS</span>
                                                <span v-if="game.status === 'is_complete'" class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">IS COMPLETE</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ game.player_one.name }} <br>
                                                Last recorded Score : {{ game.player_one_points}}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ game.player_two.name }} <br>
                                                Last recorded Score : {{ game.player_two_points}}
                                            </td>
                                            <td class="px-6 py-4">
                                                <button v-if="game.status === 'in_progress'" @click="active = game.id" class="font-medium text-blue-600 dark:text-blue-500 hover:underline" :outlined="active !== '0'">Player Score Points</button>
                                                    <Accordion v-if="game.status === 'in_progress'" v-model:value="active">
                                                        <AccordionPanel :value="game.id">
                                                            <AccordionContent>
                                                                <div class="pr-4 pl-4 pt-6 pb-3">
                                                                    <form @submit.prevent="assignPoints">
                                                                        <input type="hidden" id="gameId" :value="game.id" />
                                                                        <label for="small" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select a player</label>
                                                                        <select v-model="form.player_id" id="small" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                            <option :value="game.player_one.id" selected>{{ game.player_one.name }}</option>
                                                                            <option :value="game.player_two.id">{{ game.player_two.name }}</option>
                                                                        </select>

                                                                        <label for="small" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Points</label>
                                                                        <select v-model="form.points" id="small" class="block w-full p-2 mb-6 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                            <option :value="0" selected>0</option>
                                                                            <option :value="1">1</option>
                                                                            <option :value="2">2</option>
                                                                            <option :value="3">3</option>
                                                                        </select>

                                                                        <button type="submit" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                                            Assign Points
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </AccordionContent>
                                                        </AccordionPanel>
                                                    </Accordion>
    <!--                                            </a>-->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="col-span-1">
                            <div class="relative overflow-x-auto">
                                <h1 class="font-bold">
                                    Select 2 Players below to start a Game
                                </h1>
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="p-4">

                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Player Name
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="player in players" :key="player.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <td class="w-4 p-4">
                                            <div class="flex items-center">

                                                <input
                                                    id="checkbox-table-search-1" type="checkbox" :value=player.id  @click="checkHandler($event)" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                            </div>
                                        </td>
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ player.name }}
                                        </th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </main>


                <footer
                    class="py-16 text-center text-sm text-black dark:text-white/70"
                >
                </footer>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';

import {reactive, ref} from 'vue';

import Accordion from 'primevue/accordion';
import AccordionPanel from 'primevue/accordionpanel';
import AccordionContent from 'primevue/accordioncontent';

const active = ref('0');
const startGame = ref(false);
const gameStartSuccess = ref(false);
const gameStartFail = ref(false);
const successMessage = ref('');
const failMessage = ref('');
const props = defineProps({
    games: {
        type: Array,
        default: () => [],
    },
    players: {
        type: Array,
        default: () => [],
    },
    checked: {
        type: Array,
        default: () => [],
    },
});


const checkHandler = (e) => {
    if (e.target.checked) {
        props.checked.push(e.target.value)
    } else {
        const index = props.checked.indexOf(e.target.value);
        if (index > -1) { // only splice array when item is found
            props.checked.splice(index, 1); // 2nd parameter means remove one item only
        }
    }

    if (props.checked.length === 2) {
        startGame.value = true;
    } else  {
        startGame.value = false;
    }
}

const startNewGame = (e) => {
    e.preventDefault();
    axios.post('/games/start', {
        player_one_id: props.checked[0],
        player_two_id: props.checked[1],
    }).then(function (response) {
        gameStartSuccess.value = true;
        successMessage.value = response.data.success;
    })
    .catch(function (error) {
        gameStartSuccess.value = false;
        gameStartFail.value = true;
        failMessage.value = error.data.error;

    });

    setTimeout(function () {
        location.reload();
    }, 3000);
}


const form = reactive({
    player_id: null,
    points: null,
})
const assignPoints = (e) => {
    e.preventDefault();
    axios.post('/games/score', {
        game_id: document.getElementById('gameId').value,
        player_id: form.player_id,
        points: form.points,
    }).then(function (response) {
        if (typeof response.data.error === 'undefined') {
            gameStartSuccess.value = true;
            successMessage.value = response.data.success;
        } else {
            gameStartFail.value = true;
            failMessage.value = response.data.error;
        }
    })
        .catch(function (error) {
            gameStartFail.value = true;
            failMessage.value = error.data.error;
        });

    setTimeout(function () {
        location.reload();
    }, 4000);

}
</script>
