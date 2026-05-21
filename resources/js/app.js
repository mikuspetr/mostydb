import './bootstrap';

import { createApp } from 'vue';
//import CKEditor from '@ckeditor/ckeditor5-vue';
import IncrementCounter from './components/IncrementCounter.vue';
import VueMultiselect from 'vue-multiselect';
//import TextArea from './components/TextArea.vue'; // vyvolává chybu multiple ckEditors
import RecordGroupForm from './components/RecordGroupForm.vue'

createApp({})
  .component('IncrementCounter', IncrementCounter)
  .component('multiselect', VueMultiselect)
  .component('record-group-form', RecordGroupForm)
  .mount('#app')
