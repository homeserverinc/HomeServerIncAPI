<template>
    <div>
        <div class="panel panel-default" v-if="!this.finished">
            <div class="form-group">
                <div class="panel-heading"> 
                    <transition mode="in-out"
                        v-on:before-enter="beforeEnter"
                        v-on:enter="enter"
                        v-on:leave="leave"
                        v-bind:css="false">
                        <h3 v-if="this.showTitle">{{ this.currentQuestion.question }}</h3>
                    </transition>
                </div>
                <div class="panel-body" v-if="showAnswers">
                    <span v-for="(answer, index) in this.currentQuestion.answers" :key="answer.id">
                        <answer-component 
                            :data="answer"
                            :showAnswer="true"
                            :animation-delay="(index * 150)"
                            @answerUpdated="doOnAnswerUpdated">
                        </answer-component>
                    </span>
                </div>                
            </div>
            <div class="panel-footer">
                <button class="btn btn-primary" v-show="this.results.length > 0" @click.prevent="previousQuestion()">Previous</button>
                <button class="btn btn-primary" v-show="this.showAnswers" @click.prevent="nextQuestion()">Next</button>
            </div>
        </div>
        <input type="hidden" class="form-control" rows="8" name="json_questions" v-model="json_result">
        <answered-questions :questions="this.results" v-if="this.finished" @onResetComponent="resetComponent"></answered-questions>
    </div>
</template>

<script>
import answerComponent from './AnswerComponent.vue';
import answeredQuestions from './AnsweredQuestionsComponent.vue';
import Velocity from 'velocity-animate';
import { json } from 'body-parser';
import { clearInterval } from 'timers';
export default {    
    components: {   
        answerComponent,
        answeredQuestions
    },
    props: [
        'serviceId'
    ],
    data() {
        return {
            json_result: '',
            results: [],
            nextQuestionId: false,
            showTitle: false,
            showAnswers: false,
            finished: false,
            _currentQuestion: {},
            get currentQuestion() {
                return this._currentQuestion;
            },
            set currentQuestion(value) {
                this._currentQuestion = value;
            }
        }
    },
    watch: { 
        serviceId: function() {
            this.getFirstQuestion();
        }
    },
    mounted() {
        this.getFirstQuestion();
    },
    methods: {
        getFirstQuestion() {
            if (!this.serviceId > 0) {
                this.clearComponent();
                return;
            }
            var self = this;
            axios.get('/service/'+self.serviceId)
                 .then(async (response) => {
                    self.currentQuestion = response.data.data.question;
                    console.log(self.currentQuestion.question);
            });
            this.showTitle = true;
            this.showAnswers = true;
        },
        clearComponent() {
            this.results = [];
            this.currentQuestion = {};
            this.finished = false;
            this.json_result = '';
        },
        resetComponent() {
            this.clearComponent();
            this.getFirstQuestion();
        },
        doOnAnswerUpdated(value) {
            this.currentQuestion.answers.forEach((answer) => {   
                if (answer.id == value.id) {
                    answer = value;
                    this.nextQuestionId = value.next_question_id;
                }
            });            
        },
        nextQuestion() {
            this.showTitle = false;
            this.setQuestionAnswered();
            if (this.nextQuestionId === null) {
                this.showAnswers = false;
                this.json_result = JSON.stringify(this.results);
                this.finished = true;
            } else {
                this.getNextQuestion(this.nextQuestionId);
            }
        },
        setQuestionAnswered() {
            let q = this.currentQuestion;

            for (let i = q.answers.length - 1; i >= 0; i--) {
                if ((q.answers[i].selected == undefined) || (!q.answers[i].selected)) {
                    q.answers.splice(i, 1);
                }      
            }
            this.results.push(q);
        },
        previousQuestion() {
            this.showTitle = false;
            if (!this.showAnswers) {
                this.showAnswers = true;
            }      
            this.getPreviousQuestion();
        },
        getPreviousQuestion() {
            let old_q = this.results[this.results.length-1];
            let self = this;
            axios.get('/question/'+old_q.id)
                .then(async (response) => {
                    self.currentQuestion = response.data.data;

                    old_q.answers.forEach((old_a) => {
                        self.currentQuestion.answers.forEach((a) => {
                            /* answer was selected */
                            a.selected = (a.id == old_a.id);
                        });
                    });
                    this.results.pop();
                    self.showTitle = true;
                });
        },
        getNextQuestion(id) {
            var self = this;
            axios.get('/question/'+id)
                .then(async (response) => {
                    self.currentQuestion = response.data.data;
                    self.showTitle = true;
            });
        },
        beforeEnter: function (el) {
            el.style.opacity = 0
        },
        enter: function (el, done) {
            Velocity(el, { opacity: 1}, { duration: 600 }, { complete: done })
        },
        leave: function (el, done) {
            Velocity(el, { opacity: 0}, { duration: 600 }, { complete: done })
        }
    }
}
</script>
