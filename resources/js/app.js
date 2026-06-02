import './bootstrap';

import { createApp } from 'vue';
//import CKEditor from '@ckeditor/ckeditor5-vue';
import IncrementCounter from './components/IncrementCounter.vue';
import VueMultiselect from 'vue-multiselect';
import MSelect from './components/forms/inputs/MSelect.vue';
import TextArea from './components/forms/inputs/TextArea.vue'; // vyvolává chybu multiple ckEditors
import RecordGroupForm from './components/forms/RecordGroupForm.vue'
import IpForm from './components/forms/IpForm.vue'
import Editor from '@tinymce/tinymce-vue';

createApp({})
  .component('IncrementCounter', IncrementCounter)
  .component('multiselect', VueMultiselect)
  .component('MSelect', MSelect)
  .component('record-group-form', RecordGroupForm)
  .component('ip-form', IpForm)
  .component('Editor', Editor)
  .component('TextArea', TextArea)
  .mount('#app')
