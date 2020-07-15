<template>
    <div ref="sectionWrapper" class="blogpost-section-wrapper">
        <div class="component-wrapper" style="position: relative;" v-if="element && element.options">
            <button v-if="!element.options.text.length" 
                class="component-editor-button show-options"
                @click="$emit('showOptions', [$event.target, element])">
                <svg viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9h-4v4h-2v-4H9V9h4V5h2v4h4v2z"/></svg>
            </button>

            <emoji-autocomplete 
                v-if="colon_is_active && element.active && emojiFilter && emojiFilter.length > 0"
                :filter="emojiFilter"
                :pos="emojiPosition"
                @selected="pushEmoji(element.id, $event)"/>

            <vue-editor
                :placeholder="element.options.default" 
                ref="inlineEditor"
                class="inline-editor" 
                :class="{'focused' : element.focused}"
                :editorToolbar="customToolbar"
                :value="element.options.text"
                @input="element.options.text = $event"
                @focus="elementToggleFocus($event, element.id)"
                @blur="elementToggleFocus($event, element.id, false)"
                @text-change="textChanged($event, element.id)"
                @selection-change="selectionChanged(element.id, $event)"
                @keydown.native.up="upClicked"
                @keydown.native.down="downClicked"
                @keyup.native.delete="deleteClicked"
                @keyup.native.189="dashClicked(element.id)"
                @keyup.native.shift.186="colonClicked(element.id)"
                @keyup.native.enter="enterClicked(element.id)"
                @keyup.native.exact="onKeyUp($event, element.id)" />

                <!-- @keyup.native.shift.enter="enterClicked(element.id)" -->
                <!-- v-model="element.options.html" -->
        </div>
    </div>
</template>

<script>
import { VueEditor, Quill } from 'vue2-editor';
import EmojiAutoComplete from './EmojiAutoComplete';

export default {
    props: {
        value: Object
    },
    components : {
        'vue-editor': VueEditor,
        'emoji-autocomplete': EmojiAutoComplete
    },
    mounted(){
        if(this.value)
            this.element = this.value;
    },
    data(){
        return {
            element: {},
            quill: {},
            colon_is_active: false,
            emojiFilter: null,
            emojiPosition: null,
            customToolbar: [
                { 'header': '1' },
                { 'header': '2' },
                'bold', 'italic', 
                // 'underline',
                // { 'list': 'ordered'}, 
                // { 'list': 'bullet' },
                'link'
            ],
        }
    },
    methods: {
        focus() {
            this.$refs.inlineEditor.quill.focus();
        },

        getSelectionHtml: function(selectedContent) {
            var tempContainer = document.createElement('div')
            var tempQuill = new Quill(tempContainer);
            tempQuill.setContents(selectedContent);

            return tempContainer.querySelector('.ql-editor').innerHTML;
        },

        upClicked: function(){
            const { top, bottom, height } = this.quill.getBounds(this.quill.getSelection());
            const onFirstLine = ( bottom - height ) < height;
            
            if(onFirstLine){
                setTimeout(() => {
                    this.$emit('upClicked');
                }, 5);
            }
        },

        downClicked: function(){
            const { bottom, height } = this.quill.getBounds(this.quill.getSelection());
            const editorRect = this.$refs.inlineEditor.$el.getBoundingClientRect();
            const onLastLine = ( editorRect.height - bottom ) < height;
            
            if(onLastLine){
                setTimeout(() => {
                    this.$emit('downClicked');
                }, 5);
            }
        },

        deleteClicked: function(id){
            let el = this.element;
            if((el && el.has_text) || el.options.text.length > 0)
                return;

            this.$emit('deleteClicked');
        },

        enterClicked: function(id){
            const cursor = this.quill.getSelection();

            if(!cursor)
                return;
            
            const last_index_of_p = cursor.index;
                
            let el = this.element;
            // let clean_text = el.options.text.replace(/<(.|\n)*?>/g, '').replace(/&nbsp;/g, ' ');

            const quill = this.$refs.inlineEditor.quill;

            const back_content = quill.getContents(0, last_index_of_p);
            const forward_content = quill.getContents(last_index_of_p, quill.getLength());

            const text_behind = this.getSelectionHtml(back_content);
            const text_forward = this.getSelectionHtml(forward_content).replace("<p><br></p>", "");

            // console.log("Text behind:", text_behind);
            // console.log("Text forward:", text_forward);

            if(text_forward.length > 0)
                return;

            quill.blur();
            quill.root.innerHTML = text_behind;
            this.$emit('enterClicked');
        },

        dashClicked: function(id){
            let el = this.element;

            const old_html = this.quill.root.innerHTML;
            const is_second_dash = old_html[old_html.length - 6] === '-';

            if(!is_second_dash)
                return;

            const cursor = this.quill.getSelection();

            if(!cursor)
                return;
            
            const last_index_of_p = cursor.index;

            const back_content = this.quill.getContents(0, last_index_of_p);
            let text_behind = this.getSelectionHtml(back_content);

            text_behind += '&mdash;'
            text_behind = text_behind.replace("--</p>&mdash;", "&mdash;</p>");
            this.quill.root.innerHTML = text_behind;

            // unfocus and focus the cursor to place it at the end after adding long dash
            this.quill.blur();
            setTimeout(() => {
                this.$refs.inlineEditor.quill.focus()
            }, 10);
        },

        colonClicked: function(id){
            this.colon_is_active = true;
            console.log("Colon clicked....");
        },

        pushEmoji: function(id, emoji){
            console.log("Pushing emoji: ", emoji);
            this.quill.focus();

            let el = this.element;

            const cursor = this.quill.getSelection();

            if(!cursor)
                return;
            
            const last_index_of_p = cursor.index;

            const back_content = this.quill.getContents(0, last_index_of_p);
            let text_behind = this.getSelectionHtml(back_content);

            text_behind += emoji;
            text_behind = text_behind.replace(`:${this.emojiFilter}</p>${emoji}`, emoji + "</p>");
            this.quill.root.innerHTML = text_behind;

            // unfocus and focus the cursor to place it at the end after adding long dash
            this.quill.blur();
            setTimeout(() => {
                this.$refs.inlineEditor.quill.focus();
                this.emojiFilter = "";
                this.colon_is_active = false;
            }, 10);
        },

        onKeyUp: function(event, id){
            if(this.colon_is_active){
                let el = _.cloneDeep(this.element);

                const old_html = el.options.text.replace(/(<([^>]+)>)/ig,"");
                const text = old_html.substr(old_html.lastIndexOf(':') + 1, old_html.length);

                // console.log("Text after colon", old_html.length, old_html.lastIndexOf(':'));

                if(old_html.lastIndexOf(':') == -1 || ( old_html.length - old_html.lastIndexOf(':') ) >= 16){
                    this.emojiFilter = "";
                    return;
                }
                else
                    this.emojiFilter = text;

                var range = this.quill.getSelection();
                if (range) {
                    if (text.length > 0 && range.length == 0) {
                        // console.log("positions", this.quill.getBounds(range.index));

                        const bounds = this.quill.getBounds(this.quill.getLength());
                        const editorWrapper = this.$refs.sectionWrapper;
                        const editor = this.$refs.inlineEditor.$el;
                        const editorRect = editor.getBoundingClientRect();
                        
                        let dx = 0;

                        const autocompletediff = bounds.left + 180 - editorRect.width;
                        if(autocompletediff > 0)
                            dx = autocompletediff / 2;

                        this.emojiPosition = { top: bounds.top + 36, left : bounds.left - dx}
                        // console.log("position: ", editorWrapper.offsetTop);
                    }
                }
            }
            else{
                let el = this.element;

                if(el){
                    el.has_text = el.options.text.length > 0;
                    // this.saveElement(el);
                }
            }
        },

        elementToggleFocus: function(ev, id, focused = true){
            const e = this.element;

            if(focused){
                e.active = focused;
                this.quill = ev;
            }
            else{
                e.active = this.colon_is_active
                if(!this.colon_is_active)
                    this.quill = {};
            }

            // this.saveElement(e);
        },

        textChanged: function(ev, id){
            const e = this.element;

            if(e.selected && this.quill){
                if(!this.quill.getSelection() || !this.quill.getSelection().length)
                    e.focused = false;
            }
            else
                e.focused = false;

            // Vue.set(this.elements, idx, e);
        },

        selectionChanged: function(id, ev){
            const e = this.element;
            var selected = ev && ev.length > 0;
            e.selected = selected;
            
            // Vue.set(this.elements, idx, e);
            const editor = this.$refs.inlineEditor.$el;
            const toolbar = editor.querySelector(".ql-toolbar");

            e.focused = selected;

            if(selected){
                const bounds = this.quill.getBounds(ev.index);
                // const dx = bounds.left >= 175 ? 175 : 0;
                var toolbarRect = toolbar.getBoundingClientRect();
                var editorRect = editor.getBoundingClientRect();
                
                let dx = 0;

                const toolbardiff = bounds.left + toolbarRect.width - editorRect.width;
                if(toolbardiff > 0)
                    dx = toolbardiff / 2;
                
                toolbar.style.top = bounds.top - 46 + "px";
                toolbar.style.left = bounds.left - dx + "px";
            }else{
                toolbar.style.top = "-36px";
                toolbar.style.left = 0;
            }
        },
    }
}
</script>