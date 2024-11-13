
<template>
    <div>
        <p>ckáčko</p>

        <ckeditor
            v-model="editorData"
            :editor="editor"
            :config="editorConfig"
        />

    </div>
</template>

<script>
import { ClassicEditor, Bold, Essentials, Italic, Mention, Paragraph, Undo } from 'ckeditor5';
//import { SlashCommand } from 'ckeditor5-premium-features';

import 'ckeditor5/ckeditor5.css';
//import 'ckeditor5-premium-features/ckeditor5-premium-features.css';

export default {
    name: 'app',
    data() {
        return {
            editor: ClassicEditor,
            editorData: '<p>Hello from CKEditor 5 in Vue!</p>',
            editorConfig: {
                plugins: [ Bold, Essentials, Italic, Mention, Paragraph, SlashCommand, Undo ],
                toolbar: [ 'undo', 'redo', '|', 'bold', 'italic' ],
                //licenseKey: '<YOUR_LICENSE_KEY>',
                // Other configuration options...
            }
        };
    }
};

</script>
