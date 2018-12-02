import LeadQuestionsFormComponent from './components/LeadQuestionsFormComponent.vue';
//import Velocity from 'velocity-animate';

const questionForm = new Vue({
    el: '#lead-service-questions',
    components:{
        'lead-questions-form': LeadQuestionsFormComponent,
    },
    data() {
        return {
            serviceId: null
        }
    }
});