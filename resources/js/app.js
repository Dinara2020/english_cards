require('./bootstrap');

import {createApp} from 'vue';
import Autocomplete from 'v-autocomplete'
import 'v-autocomplete/dist/v-autocomplete.css'
import autoComplete from "@tarekraafat/autocomplete.js";
import axios from 'axios';
import CardSmall from './components/CardSmall.vue';

const app = createApp({
    components: {
        CardSmall,
        Autocomplete
    },
    data() {
        return {
            items: [],
            start: 0,
            backgroundClass: "",
            filters: [],
            counter: 32,
            scroll: true
        };
    },
    async created() {
        this.addCards(this.start);
        this.start += this.counter;
        window.addEventListener('scroll', this.throttle(this.handleScroll, 250));

    },
    methods: {
        filter(event) {
            this.items = []
            this.scroll = true
            if (this.filters.includes(event.target.value)) {
                this.filters = this.filters.filter(function(f) { return f !== event.target.value})
            } else {
                this.filters.push(event.target.value);
            }
            console.log(this.filters)
            this.start = 0
            this.addCards(this.start);
            this.start += this.counter;
        },
        async getWords(offset) {
            try {
                let arrayAsString = ''
                if (this.filters.length !== 0) {
                    let paramName = '&filter[]=';
                    arrayAsString = paramName + this.filters.join('&' + paramName);
                    console.log('/getData?count=' + offset + arrayAsString);
                }
                const response = await axios.get('/getData?count=' + offset + arrayAsString);
                return response.data;
            } catch (error) {
                console.error(error);
            }
        },
        async addCards(offset) {
            const data = await this.getWords(offset);
            if (data.length < this.counter) {
                this.scroll = false;
            }
            this.items.push(...data);
        },
        handleScroll() {
            const documentRect = document.documentElement.getBoundingClientRect();
            if (documentRect.bottom < document.documentElement.clientHeight + 150 &&
                this.scroll
            ) {
                this.addCards(this.start)
                this.start += this.counter;
            }
        },
        throttle(callee, timeout) {
            let timer = null

            return function perform(...args) {
                if (timer) return

                timer = setTimeout(() => {
                    callee(...args)

                    clearTimeout(timer)
                    timer = null
                }, timeout)
            }
        },
        autoCompleteJS() {
            const autoCompleteJS = new Autocomplete({
                selector: "#autoComplete",
                placeHolder: "Введите слово...",
                data: {
                    src: (query) => {
                        return this.getWords()
                    },
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
        }
    }
});
app.use(Autocomplete);
app.component('card-small', CardSmall);
app.mount('#app');


document.querySelector("#autoComplete").addEventListener("close", function (event) {
    window.location.replace("/" + event.detail.selection.value.key);
});
