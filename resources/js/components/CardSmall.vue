<template>
    <div class="card-small" @click="toggleCard">
        <div class="front" :class="backgroundColor">
            <div class="front-content">
                <p><a :href="'update/delete/id' + word.id"><span
                    class="badge badge-danger  float-right align-top"><i class="fa fa-times"></i></span></a></p>
                <p class="word" :class="word.pic ? '' : 'no-image'">{{ word.word }}</p>
                <div class="pron" v-html="word.pron"></div>
                <input class="sound" type="hidden" :value="word.sound">
                <div class="image" v-if="word.pic"><img :src="word.pic" width="90" height="90"></div>
<!--                <div class="ll-sets-words__sound ">-->
<!--                    <audio :src="word.sound"></audio>-->
<!--                    <span class="ll-icon" style="width: 32px; height: 32px; color: rgb(126, 145, 159);">-->
<!--            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">-->
<!--              <path fill="currentColor"-->
<!--                    d="M15.788 13.007a3 3 0 110 5.985c.571 3.312 2.064 5.675 3.815 5.675 2.244 0 4.064-3.88 4.064-8.667 0-4.786-1.82-8.667-4.064-8.667-1.751 0-3.244 2.363-3.815 5.674zM19 26c-3.314 0-12-4.144-12-10S15.686 6 19 6s6 4.477 6 10-2.686 10-6 10z"-->
<!--                    fill-rule="evenodd"></path>-->
<!--            </svg>-->
<!--          </span>-->
<!--                </div>-->
                <div class="phrase " v-html="word.phrase"></div>
            </div>
            <div class="bottom">
                <div class="buttons">
                    <a href="#">
                        <button type="button" class="btn btn-warning  m-1" @click.stop.prevent="study(word.id)">
                            Изучать
                        </button>
                    </a>
                    <a href="#">
                        <button type="button" class="btn btn-success  m-1 ml-2"
                                @click.stop.prevent="learned(word.id)">Изучено
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="back">
            <div class="back-content">
                <div class="tranlation">{{ word.translation }}</div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    props: {
        word: {
            type: Object,
            required: true,
        },
    },
    computed: {
        backgroundColor() {
            return {
                yellow: this.word.status === 'learn',
                green: this.word.status === 'done',
            }
        },
    },
    data() {
        return {
            showBack: false,
            className: ""
        };
    },
    methods: {
        toggleCard() {
            const front = event.target.closest('.card-small').querySelector('.front')
            const back = event.target.closest('.card-small').querySelector('.back');
            front.classList.toggle('rotate');
            back.classList.toggle('rotate2');
        },
        async study(id) {
            this.word.status = 'learn'
            await axios.get('/update/learn/' + id)
        },
        async learned(id) {
            try {
                this.word.status = 'done'
                await axios.get('/update/done/' + id)
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>
