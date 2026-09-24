import './bootstrap';

import { createApp } from 'vue';
//import CKEditor from '@ckeditor/ckeditor5-vue';
import EbookStore from './components/EbookStore.vue';
import IncrementCounter from './components/IncrementCounter.vue';
import MultipleSelect from './components/MultipleSelect.vue';
//import TextArea from './components/TextArea.vue'; // vyvolává chybu multiple ckEditors

createApp({})
  .component('EbookStore', EbookStore)
  .component('IncrementCounter', IncrementCounter)
  .component('MultipleSelect', MultipleSelect)

  .mount('#app')
