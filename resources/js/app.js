require('./bootstrap');

import Autocomplete from 'v-autocomplete'

import 'v-autocomplete/dist/v-autocomplete.css'
import {createApp} from 'vue'
import autoComplete from "@tarekraafat/autocomplete.js";

const app = createApp({
    data() {
        return {
            message: 'Привет, Vue!'
        }
    }
})
app.use(Autocomplete);
// Определяем новый глобальный компонент с именем button-counter
app.component('button-counter', {
    data() {
        return {
            count: 0
        }
    },
    template: `
    <button @click="count++">
      Счётчик кликов — {{ count }}
    </button>`
})
app.mount('#app');
async function getWords() {
    try {
        const response = await axios.get('/getWords');
        return response.data;
    } catch (error) {
        console.error(error);
    }
}
const autoCompleteJS = new autoComplete({
    selector: "#autoComplete",
    placeHolder: "Введите слово...",
    data: {
        src: (query) => {
            return getWords()},
        cache: true,
        keys: ['value'],
    },
    resultsList: {
        element: (list, data) => {
            if (!data.results.length) {
                // Create "No Results" message element
                const message = document.createElement("div");
                // Add class to the created element
                message.setAttribute("class", "no_result");
                // Add message text content
                message.innerHTML = `<span>Found No Results for "${data.query}"</span>`;
                // Append message element to the results list
                list.prepend(message);
            }
        },
        noResults: true,
    },
    resultItem: {
        highlight: true,
        id: (event) => {
            console.log(resultItem),
                console.log(event)
        },
    },
    events: {
        input: {
            selection: (event) => {
                const selection = event.detail.selection.value;
                console.log(selection);
                autoCompleteJS.input.value = selection.value;
            },
        },
    }
});
document.querySelector("#autoComplete").addEventListener("close", function (event) {
    window.location.replace("/" + event.detail.selection.value.key);
});
