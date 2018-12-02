<template>
    <div>
        <div class="card">
            <div class="card-header">
                Answered Questions
            </div>
            <div class="card-body">
                <div v-for="(question) in this.questions" :key="question.id">
                    <h5 class="card-title">
                        {{question.question}}
                    </h5>
                    <div class="mb-3" v-for="(answer) in question.answers" :key="answer.id">
                        <p class="card-text" v-if="answer.selected">{{ answer.answer }}</p>
                        <p class="card-text" v-if="answer.value">{{ answer.value }}</p>
                    </div>
                </div>
                <a href="#" class="btn btn-danger float-right" @click="doOnResetQuestions">Reset questions</a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'answeredQuestions',
    props: [
        'questions'
    ],
    watch: {
        questions: function() {
        }
    },
    methods: {
        doOnResetQuestions() {
            this.$emit('onResetComponent');
        }
    }
}
</script>
