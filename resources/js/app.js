import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import {createApp} from 'vue';
import {ref, computed} from 'vue'
import axios from 'axios';
import CardSmall from './components/CardSmall.vue';
import Modal from './components/Modal.vue';
let words;
axios.get('/getWords')
    .then(function (response) {
        words = response.data
    });
const app = createApp({
    components: {
        CardSmall,
        Modal
    },
    data() {
        return {
            items: [],
            start: 0,
            backgroundClass: "",
            filters: [],
            counter: 32,
            scroll: true,
            showAddButton: false,
            isOpen: true
        };
    },
    setup() {
        let searchTerm = ref('')
        let wordData = []
        const searchWords = computed(() => {
            if (searchTerm.value === '') {
                return []
            }
            let matches = 0
            return words.filter(country => {
                if (country.value.toLowerCase().includes(searchTerm.value.toLowerCase()) && matches < 10) {
                    matches++
                    return country
                }
            })
        });
        let selectCountry =(country) => {
            selectedWord.value = country
            searchTerm.value = ''
            let wordData = axios.get('/word/' + selectedWord.value)
                .then(function (response) {
                    return response.data
                });
        }
        let selectedWord = ref('')

        return {
            searchTerm,
            searchWords,
            selectedWord,
            selectCountry,
            wordData
        }
    },
    async created() {
        this.addCards(this.start);
        this.start += this.counter;
        window.addEventListener('scroll', this.throttle(this.handleScroll, 250));
    },
    watch: {
        selectedWord: {
            async handler(newValue, oldValue) {
                let wordData = await axios.get('/word/' + newValue)
                    .then(function (response) {
                        return response.data
                    });
                this.items.unshift(wordData)
            },
        },
        searchWords: {
            handler(newValue, oldValue) {
                if (this.searchWords.length === 0 && this.searchTerm) {
                    this.showAddButton = true
                } else {
                    this.showAddButton = false
                }
            }
        },
    },
    methods: {
        addWord () {
            console.log(this.searchTerm);
            this.searchWords.push(this.searchTerm);
        },
        filter(event) {
            this.items = []
            this.scroll = true
            if (this.filters.includes(event.target.value)) {
                this.filters = this.filters.filter(function (f) {
                    return f !== event.target.value
                })
            } else {
                this.filters.push(event.target.value);
            }
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
    }
});
app.component('card-small', CardSmall);
app.component('modal', Modal);
app.mount('#app');
