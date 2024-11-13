import './bootstrap';

import { createApp } from 'vue';
import CKEditor from '@ckeditor/ckeditor5-vue';
import IncrementCounter from './components/IncrementCounter.vue';
import MultipleSelect from './components/MultipleSelect.vue';
import TextArea from './components/TextArea.vue';

createApp({})
  .component('IncrementCounter', IncrementCounter)
  .component('MultipleSelect', MultipleSelect)
  .component('TextArea', TextArea)
  .mount('#app')
