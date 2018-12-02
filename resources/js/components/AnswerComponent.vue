<template>
    <span>
        <transition mode="in-out"
            v-on:before-enter="beforeEnter"
            v-on:enter="enter"
            v-on:leave="leave"
            v-bind:css="false">
            <div v-if="this.visible"> 
                <ul class="list-group border-light">
                    <li class="list-group-item">
                        <div class="custom-control custom-checkbox" v-if="(answerType == 1)">
                            <input type="checkbox" class="custom-control-input" :id="answer.answer_slug" :value="answer.id" v-model="answer.selected" @change="doOnChange()">
                            <label class="custom-control-label" :for="answer.answer_slug">{{ this.answer.answer }}</label>
                        </div>
                        <div class="custom-control custom-radio" v-if="(answerType == 2)">
                            <input type="radio" class="custom-control-input" :id="answer.answer_slug" v-model="answer.selected" value="true" @change="doOnChange()" :name="this.$parent.currentQuestion.field_name" >
                            <label class="custom-control-label" :for="answer.answer_slug">{{ this.answer.answer }}</label>
                        </div>
                    </li>
                </ul>           
            </div>
        </transition> 
    </span>
</template>

<script>
import Velocity from 'velocity-animate';
export default {
    data() {
        return {
            visible: false,
            duration: 300,
            answer: {},
            customValue: null,
            answerType: false
        }
    },
    props: {
        data: {},
        animationDelay: null,
        showAnswer: false
    },
    mounted() {
        this.visible = this.showAnswer;
        this.answer = this.data;
        this.selected = this.data.selected;
        this.answerType = this.$parent.currentQuestion.question_type_id;
    },
    methods: {
        doOnChange() {
            this.answer.value = this.customValue;
            this.$emit('answerUpdated', this.answer);
        },
        beforeEnter: function (el) {
            el.style.opacity = 0
        },
        enter: function (el, done) {
            Velocity(el, { opacity: 1}, { duration: this.duration + this.animationDelay }, { complete: done })           
        },
        leave: function (el, done) {
            Velocity(el, { opacity: 0}, { duration: this.duration + this.animationDelay }, { complete: done })
        }
    }
}
</script>
