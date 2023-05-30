<template>
    <div class="modal" tabindex="-1" role="dialog" v-if="isOpen" :style="dynamicStyles">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p v-html="body"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <button @click="openModal">Открыть модальное окно</button>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        },
        body: {
            type: String,
            required: true
        },
    },
    data() {
        return {
            isOpen: false,
            dynamicStyles: {
                display: 'block'
            }
        };
    },
    methods: {
        openModal(id) {
            this.dynamicStyles.display = 'block';
            this.isOpen = true;
        },
        closeModal(id) {
            this.dynamicStyles.display = 'none';
            this.isOpen = false;
        }
    }
};
</script>
