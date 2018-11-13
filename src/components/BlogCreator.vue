<style>
    *{
        box-sizing: border-box;
    }

    #loader {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #333;
        color: #e9e9e9;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-family: 'Courier New', Courier, monospace;
        z-index: 10;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: opacity 0.35s ease-out;
    }

    #loader span {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 4px dashed #1ddc6a;
        border-left-width: 2px;
        border-bottom-width: 2px;
        margin-bottom: 2em;
        animation: roll 0.7s ease-out infinite alternate;
    }

    #loader.hide {
        opacity: 0;
        pointer-events: none
    }

    @keyframes roll {
        50% {
            transform: rotate(80deg);
        }
        100% {
            transform: rotate(160deg);
        }
    }

    #content{
        margin-top: 120px;
    }

    .blogpost-section-wrapper{
        position: relative;
    }

    .component-editor-buttons,
    .component-editor-button.show-options{
        position: absolute;
        top: 0;
        left: -50px;
        outline: none;
    }

    #insightTitle .component-editor-buttons,
    #insightTitle .component-editor-button.show-options{
        left: -27px;
        top: 3px;
    }

    #insightDate input{
        font-family: inherit;
        font-size: inherit;
        padding: 0;
        min-width: 250px;
        border: none;
        margin-left: 0.05em;
        outline: none;
    }

    #insightDate input::placeholder{
        color: #bbb;
    }

    .wide-image .component-editor-buttons,
    .cover-image-wide .component-editor-buttons{
        left: calc(((1000px - var(--wrapper-width)) / 2) - 50px);
    }
    
    .full-image .component-editor-buttons,
    .cover-image-full .component-editor-buttons{
        left: calc(((100vw - var(--wrapper-width)) / 2) - 50px);
    }

    /*link to avoid hover flicker*/
    .component-editor-buttons:after,
    .component-editor-button.show-options:after{
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: inherit;
        width: 50px;
    }

    .component-editor-buttons{
        display: flex;
        flex-direction: column;
        padding: 0.5em;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 3px;
        transition: opacity 0.3s ease-out;
        z-index: 2;
    }

    .component-editor-buttons.delete-only{
        padding: 0 0.5em;
        margin-top: -0.15em;
    }

    .component-editor-buttons.delete-only button:first-child{
        display: none;
    }

    .blogpost-section-wrapper:not(:hover) 
    .component-editor-buttons:not(:hover),
    .blogpost-section-wrapper:not(:hover) 
    .component-editor-button.show-options:not(:hover){
        opacity: 0;
    }

    .component-editor-button{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: transparent;
        color: #f18f16;
        border: 1px solid currentColor;
        margin-bottom: 8px;
        z-index: 1;
    }

    .component-editor-button:nth-of-type(2){
        color: #e04b2a;
        margin-bottom: 0;
    }
    
    .component-editor-button.show-options{
        color: #555;
        width: 30px;
        height: 30px;
    }
    
    .component-editor-button svg{
        width: 20px;
        height: 20px;
    }
    
    .component-editor-button.show-options svg{
        width: 26px;
        height: 26px;
    }

    #openArranger{
        z-index: 10;
        position: fixed;
        top: 120px;
        right: 3em;
        padding: 0.5em 1em;
        background: #fff;
        border-radius: 5px;
        border: 1px solid #888;
        font-size: 0.9em;
        line-height: 0;
        transition: opacity 0.2s ease-out;
    }

    #openArranger:not(:hover){
        opacity: 0.5;
    }

    .inline-editor{
        position: relative;
        margin-top: 1em;
    }
    
    .inline-editor p:first-child{
        margin-top: 0 !important;
    }

    .inline-editor .ql-container.ql-snow {
        border: none !important;
    }

    .inline-editor .ql-editor {
        min-height: 0 !important;
        padding: 0 !important
    }

    .inline-editor .ql-picker:not(.ql-background) {
        top: 0 !important;
    }

    .inline-editor .ql-snow.ql-toolbar {
        box-shadow: 0 1px 4px 1px rgba(0, 0, 0, 0.2);
        position: absolute;
        top: -36px;
        left: 0;
        background: #eee;
        border-radius: 3px;
        display: inline-flex !important;
        border: none !important;
        align-items: center;
        justify-content: space-between;
        z-index: 1;
        height: 40px;
        /* min-width: 260px; */

        transition: opacity 0.1s ease-out, transform 0.1s ease-out;
    }

    .inline-editor .ql-snow.ql-toolbar button{
        margin-left: 5px;
        margin-right: 5px;
    }

    .inline-editor:not(.focused) .ql-snow.ql-toolbar {
        opacity: 0;
        pointer-events: none;
        transition: none;
    }

    .inline-editor .ql-snow.ql-toolbar .ql-formats {
        margin: 0 !important;
        margin-right: 15px !important;
    }

    .inline-editor .ql-snow.ql-toolbar .ql-formats:last-child {
        margin-right: 8px !important;
    }

    .inline-editor .ql-snow.ql-toolbar .ql-formats:first-child {
        margin-left: 4px !important;
    }

    .inline-editor .ql-snow.ql-toolbar button svg,
    .inline-editor .ql-snow.ql-toolbar button svg {
        width: 18px !important;
        height: 18px !important;
    }

    .element svg{
        width: 28px;
        height: 28px;
    }
</style>

<template>
    <div>
        <bc-editor v-if="editting" 
            :editting="editting"
            :element="curelement"
            @save="saveElement"
            @cancel="cancelEditting"
            :image-upload-url="imageUploadUrl"
            :unsplash-client-id="unsplashClientId"/>

        <bc-header @publish="publish(true)" :save="saving_result"/>
        
        <bc-element-picker :show-elements="showChoices" 
            @cancel="showChoices = {}"
            @add="addElement" :elements="choices"/>

        <button title="Arrange Sections" id="openArranger" v-if="elements.length > 1 && !arranging" @click="arranging = true">
            <svg width="18" height="18" viewBox="0 0 24 24"><path d="M3 18h6v-2H3v2zM3 6v2h18V6H3zm0 7h12v-2H3v2z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
        </button>

        <bc-aside v-if="arranging" 
            @cancel="arranging = false"
            v-model="elements" :elements="elements"></bc-aside>

        <div id="content">
            <div id="insightBody">
                <div id="insightImage" v-if="cover != null" :class="['blogpost-section-wrapper', 'cover-image-' + cover.options.width]">
                    <div class="component-editor-buttons">
                        <button class="component-editor-button"
                            @click="editElement(cover)">
                            <svg fill="#f18f16" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                        </button>
                        <button class="component-editor-button"
                            @click="removeCoverImage()">
                            <svg fill="#e04b2a" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                        </button>
                    </div>

                    <img :src="cover.options.url" alt="">
                </div>

                <div class="blogpost-section-wrapper">
                    <div id="insightTitle">
                        <div class="component-editor-buttons" v-if="cover === null">
                            <button
                                class="component-editor-button show-options"
                                @click="addCoverImage()">
                                <svg width="24" height="24" viewBox="0 0 24 24"><path d="M19 7v2.99s-1.99.01-2 0V7h-3s.01-1.99 0-2h3V2h2v3h3v2h-3zm-3 4V8h-3V5H5c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8h-3zM5 19l3-4 2 3 3-4 4 5H5z"/></svg>
                            </button>
                        </div>
                        <textarea
                            id="blogTitle"
                            v-model="title" 
                            placeholder="Enter post title here"
                            rows="1"/>

                        <!-- <h5><span class="taggy-item">BUSINESS GROWTH</span><span class="taggy-item">TECHNOLOGY</span></h5> -->
                    </div>
                    <span id="insightDate">
                        <!-- Published {{date | formatDate}} -->
                        By <input type="text" 
                            placeholder="Enter author's name here" 
                            v-model="author"
                            @keyup="autosave()">
                    </span>
                </div>

                <div ref="content" class="blog-content" style="min-height: calc(100vh - 330px)">
                    <template v-for="(element, index) in elements">
                        <div :ref="'sectionWrapper' + element.id" :key="index" :class="['blogpost-section-wrapper', 
                            {'wide-image': (element.component === 'bc-image' || element.component === 'bc-youtube-video') && element.options.width === 'wide'},
                            {'full-image': (element.component === 'bc-image' || element.component === 'bc-youtube-video') && element.options.width === 'full'}
                            ]">
                            <div class="component-wrapper" style="position: relative;">
                                <button v-if="element.component == 'bc-text' && !element.options.text.length" 
                                    class="component-editor-button show-options"
                                    @click="showOptions($event.target, element)">
                                    <svg viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9h-4v4h-2v-4H9V9h4V5h2v4h4v2z"/></svg>
                                </button>

                                <div class="component-editor-buttons" :class="{'delete-only' : element.component === 'bc-separator'}"
                                    v-if="element.component != 'bc-text'">
                                    <button class="component-editor-button"
                                        @click="editElement(element)">
                                        <svg fill="#f18f16" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                                    </button>
                                    <button class="component-editor-button"
                                        @click="removeElement(element.id)">
                                        <!-- color: #e04b2a;color: #f18f16; -->
                                        <svg fill="#e04b2a" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                                    </button>
                                </div>

                                <emoji-autocomplete 
                                    v-if="element.component == 'bc-text' && colon_is_active && element.active && emojiFilter && emojiFilter.length > 0"
                                    :filter="emojiFilter"
                                    :pos="emojiPosition"
                                    @selected="pushEmoji(element.id, $event)"/>

                                <vue-editor
                                    :placeholder="element.options.default" 
                                    :ref="'inlineEditor' + element.id"
                                    :key="index" class="inline-editor" :class="{'focused' : element.focused}"
                                    v-if="element.component == 'bc-text'" 
                                    v-model="element.options.text"
                                    :value="element.options.text"
                                    :editorToolbar="customToolbar"
                                    @focus="elementToggleFocus($event, element.id)"
                                    @blur="elementToggleFocus($event, element.id, false)"
                                    @text-change="textChanged($event, element.id)"
                                    @selection-change="selectionChanged(element.id, $event)"
                                    @keyup.native.delete="deleteClicked(element.id)"
                                    @keyup.native.189="dashClicked(element.id)"
                                    @keyup.native.shift.186="colonClicked(element.id)"
                                    @keyup.native.enter="enterClicked(element.id)"
                                    @keyup.native="onKeyUp($event, element.id)"/>

                                    <!-- @keyup.native.shift.enter="enterClicked(element.id)" -->
                                <component
                                    v-else
                                    :is="element.component"
                                    :component="element.component"
                                    :options="element.options"
                                    v-model="element.options.html"/>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import axios from 'axios'
    import _ from 'lodash'
    import moment from 'moment'
    import FileUploader from "./FileUploader";

    Vue.filter('formatDate', function(value) {
        if (value) {
            return moment(String(value)).format('MMMM DD, YYYY')
        }
    });

    import { choices } from '../choices'

    import { db_blog } from '../blog'

    import { VueEditor, Quill } from 'vue2-editor'

    import autosize from 'autosize'

    import BCHeader from './BCHeader.vue'
    import BCAside from './BCAside.vue'
    import BCElementPicker from './BCElementPicker.vue'
    
    import BCText from './BCText.vue'
    import BCAlert from './BCAlert.vue'
    import BCQuote from './BCQuote.vue'
    import BCYoutubeVideo from './BCYoutubeVideo.vue'
    import BCImage from './BCImage.vue'
    import BCSeparator from './BCSeparator.vue'
    
    import BCEditor from './BCEditor.vue'
    import EmojiAutoComplete from './EmojiAutoComplete'

    export default {
        props:{
            blog: Object,
            saveUrl: String,
            imageUploadUrl: String,
            unsplashClientId: String,
            youtubeApiKey: String
        },

        // provide: {
        //     imageUploadUrl: this.imageUploadUrl,
        //     unsplashClientId: this.unsplashClientId
        // },

        data(){
            return {
                blogId: null,
                title: "",
                cover: null,
                author: null,
                date: moment(new Date()).format("YYYY-MM-DDTHH:mm:ssZ"),
                entry_idx: -1,
                html_text: "",
                quill: {},
                choices : choices,
                elements : [],
                editting: false,
                colon_is_active: false,
                emojiFilter: null,
                emojiPosition: null,
                curelement: {},
                arranging: false,
                handler: new Vue(),
                showChoices: {},
                customToolbar: [
                    { 'header': '1' },
                    { 'header': '2' },
                    'bold', 'italic', 
                    // 'underline',
                    // { 'list': 'ordered'}, 
                    // { 'list': 'bullet' },
                    'link'
                ],
                coverImageElement: {
                    name: 'Cover Image',
                    label: 'Cover Image',
                    component: 'cover',
                    skeleton: {
                        url: {
                            default: null,
                            type: 'image'
                        },
                        width: {
                            default: "wide",
                            type: 'choice',
                            choices: ['normal', 'wide', 'full']
                        }
                    }
                },
                saving: false,
                saving_result: {
                    message: ""
                }
            }
        },

        mounted: function() {
            autosize(this.$el.querySelector("#blogTitle"));
        },

        created: function(){
            try{
                this.blogId = this.dbId;
            }catch(err){
                this.blogId = undefined;
            }
            
            try{
                const blog = JSON.parse(this.blog);

                this.title = blog.title.replace(/\\'/g, "'");
                this.blogId = blog.id;
                this.author = blog.author.replace(/\\'/g, "'");;

                const creator_json = JSON.parse(blog.creator_json);
                
                if(creator_json){
                    console.log("creator_json found....");
                    this.elements = creator_json.elements;
                    this.cover = creator_json.cover;
                }else{
                    console.log("Creator json not found....");
                }

                if(!this.elements.length || _.last(this.elements).component != "bc-text")
                    this.addBufferText();
            }catch(err){
                this.title = "";
                this.elements = [];
                // console.log("Error parsing blog:", err);
                console.log("Error parsing blog:");

                //when creating new blogpost
                this.addBufferText();
            }
        },
        
        methods: {
            getEmptyTextElement: function(){
                const default_text = (this.elements.length > 0) ? "Continue writting here..." 
                    : "Enter your post content here...";
                const text = text || default_text;
                
                // simple text element
                return {name: 'Text', component: 'bc-text', options: {text: '', default: text}};
            },
            
            addBufferText(text, idx = -1){
                this.addElement(this.getEmptyTextElement(text), false, idx);
            },
            
            addCoverImage(){
                this.addElement(_.cloneDeep(this.coverImageElement));
            },
            
            removeCoverImage(){
                this.cover = null;
                this.publish();
            },

            getSelectionHtml: function(selectedContent) {
                var tempContainer = document.createElement('div')
                var tempQuill = new Quill(tempContainer);
                tempQuill.setContents(selectedContent);

                return tempContainer.querySelector('.ql-editor').innerHTML;
            },

            enterClicked: function(id){
                const cursor = this.quill.getSelection();

                if(!cursor)
                    return;
                
                const last_index_of_p = cursor.index;
                    
                const idx = _.findIndex(this.elements, ['id', id]);
                let el = this.elements[idx];
                // let clean_text = el.options.text.replace(/<(.|\n)*?>/g, '').replace(/&nbsp;/g, ' ');

                const quill = this.$refs[`inlineEditor${id}`][0].quill;

                const back_content = quill.getContents(0, last_index_of_p);
                const forward_content = quill.getContents(last_index_of_p, quill.getLength());

                const text_behind = this.getSelectionHtml(back_content);
                const text_forward = this.getSelectionHtml(forward_content).replace("<p><br></p>", "");

                if(text_forward.length > 0)
                    return;

                // console.log("Text behind:", text_behind);
                // console.log("Text forward:", text_forward);

                quill.blur();

                quill.root.innerHTML = text_behind;
                
                let textnode = this.getEmptyTextElement("Continue right here");
                this.addElement(textnode, false, idx + 1);

                if(text_forward.length){ //not just the empty new line
                    console.log("Adding forward text....");
                    let textnode = this.getEmptyTextElement("Continue right here");
                    textnode.options.text = text_forward;

                    this.addElement(textnode, false, idx + 2);
                }

                setTimeout(() => {
                    const new_editor = this.$refs[`inlineEditor${this.elements[idx + 1].id}`];
                    console.log(new_editor);
                    new_editor[0].quill.focus();
                }, 5);
            },
            dashClicked: function(id){
                const idx = _.findIndex(this.elements, ['id', id]);
                let el = this.elements[idx];

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
                    this.$refs[`inlineEditor${id}`][0].quill.focus()
                }, 10);
            },
            colonClicked: function(id){
                this.colon_is_active = true;
                console.log("Colon clicked....");
            },
            pushEmoji: function(id, emoji){
                console.log("Pushing emoji: ", emoji);
                this.quill.focus();

                const idx = _.findIndex(this.elements, ['id', id]);
                let el = this.elements[idx];

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
                    this.$refs[`inlineEditor${id}`][0].quill.focus();
                    this.emojiFilter = "";
                    this.colon_is_active = false;
                }, 10);
            },
            deleteClicked: function(id){
                const idx = _.findIndex(this.elements, ['id', id]);
                const is_last = idx == this.elements.length - 1;
                let el = this.elements[idx];

                if(el && el.has_text){
                    return;
                }

                if(el.options.text.length < 1 && idx != 0 && (!is_last || this.elements[idx - 1].component === 'bc-text')){
                    this.removeElement(id);
                    this.$refs[`inlineEditor${this.elements[idx - 1].id}`][0].quill.focus();
                }else{
                    this.saveElement(el);
                }
            },
            onKeyUp: function(event, id){
                // return console.log(event);
                if(this.colon_is_active){
                    const idx = _.findIndex(this.elements, ['id', id]);
                    let el = _.cloneDeep(this.elements[idx]);

                    const old_html = el.options.text.replace(/(<([^>]+)>)/ig,"");
                    const text = old_html.substr(old_html.lastIndexOf(':') + 1, old_html.length);

                    // console.log("Text after colon", old_html.length, old_html.lastIndexOf(':'));

                    if(old_html.lastIndexOf(':') == -1 || ( old_html.length - old_html.lastIndexOf(':') ) >= 16){
                        this.emojiFilter = "";
                        return;
                    }else{
                        this.emojiFilter = text;
                    }

                    var range = this.quill.getSelection();
                    if (range) {
                        if (text.length > 0 && range.length == 0) {
                            // console.log("positions", this.quill.getBounds(range.index));

                            const bounds = this.quill.getBounds(this.quill.getLength());
                            const editorWrapper = this.$refs[`sectionWrapper${id}`][0];
                            const editor = this.$refs[`inlineEditor${id}`][0].$el;
                            const editorRect = editor.getBoundingClientRect();
                            
                            let dx = 0;

                            const autocompletediff = bounds.left + 180 - editorRect.width;
                            if(autocompletediff > 0){
                                dx = autocompletediff / 2;
                            }

                            this.emojiPosition = { top: bounds.top + 36, left : bounds.left - dx}
                            // console.log("position: ", editorWrapper.offsetTop);
                        }
                    }
                }else{
                    const idx = _.findIndex(this.elements, ['id', id]);
                    let el = this.elements[idx];

                    if(el){
                        el.has_text = el.options.text.length > 0;
                        this.saveElement(el);
                    }
                }
            },
            showOptions(target, element){
                this.entry_idx = _.findIndex(this.elements, ['id', element.id]);

                const box = target.getBoundingClientRect();
                this.showChoices = {status: true, position : {left: box.left, top:box.top}}
            },
            addElement(el, auto_edit = true, add_pos){
                this.showChoices = {};
                if(!auto_edit || el.component == 'bc-separator'){
                    this.saveElement(el, true, add_pos);
                }
                else{
                    this.editElement(el);
                }
            },
            editElement: function(el){
                if(el.component != 'cover' && (!el.label || !el.label.length)){
                    let len = _.filter(this.elements, ['name', el.name]).length;
                    el.label = el.name + " " + len;
                }

                this.curelement = el;
                this.editting = true;
            },
            removeElement: function(id){
                var idx = _.findIndex(this.elements, ['id', id]);
                this.elements.splice(idx, 1);
                this.autosave();
            },
            saveElement: function(e, not_edited, add_pos){
                if(!e)
                    return;

                if(e.component === 'cover'){
                    this.cover = e;
                    this.curelement = {};
                    this.editting = false;

                    this.publish();
                    return;
                }
                
                var idx = _.findIndex(this.elements, ['id', e.id]);
                
                if(!not_edited && (!e.label || !e.label.length)){
                    let len = _.filter(this.elements, ['name', e.name]).length;
                    e.label = e.name + " " + len;
                }

                if(idx != -1){
                    Vue.set(this.elements, idx, e);
                }
                else{
                    const last_element = _.last(this.elements);

                    // remove auto added last empty text element
                    e.id = (Math.random() * 1e32).toString(36);
                    
                    if(add_pos && add_pos != -1){
                        console.log("Saving at position....");
                        this.elements.splice(add_pos, 0, e);
                    }else{
                        console.log("Saving at the end....");
                        if(!not_edited && last_element && last_element.component == "bc-text" && last_element.options.text == ""){
                            this.elements.pop();
                        }
                        else{
                            this.saveElement(last_element);
                        }

                        if(this.entry_idx != -1){
                            this.elements.splice(this.entry_idx, 1, e);
                        }else{
                            this.elements.push(e);
                        }

                        if(e.component != "bc-text"){
                            console.log("Save idx: ", idx, this.elements.length - 1);

                            if(!not_edited){
                                if(this.entry_idx != -1)
                                    this.addBufferText("Continue writting here...", this.entry_idx + 1);
                                else
                                    this.addBufferText();

                                setTimeout(() => { //focus added buffer text
                                    var cur_editor = this.$refs[`inlineEditor${e.id}`];
                                    if(cur_editor){
                                        var quill = cur_editor[0].quill;
                                        quill.focus();
                                    }
                                }, 5);
                            }else if(e.component === 'bc-separator'){
                                this.addBufferText("Continue writting here...", this.elements.length);
                                
                                setTimeout(() => {
                                    const new_editor = this.$refs[`inlineEditor${this.elements[this.elements.length - 1].id}`];
                                    new_editor[0].quill.focus();
                                }, 5);
                            }

                            this.autosave();
                        }

                        this.entry_idx = -1;
                    }
                }

                this.curelement = {};
                this.editting = false;
            },
            cancelEditting: function(){
                this.curelement = {};
                this.editting = false;
            },
            elementToggleFocus: function(ev, id, focused = true){
                const idx = _.findIndex(this.elements, ['id', id]);
                const e = this.elements[idx];

                if(focused){
                    e.active = focused;
                    this.quill = ev;
                }
                else{
                    e.active = this.colon_is_active
                    if(!this.colon_is_active)
                        this.quill = {};
                }

                this.saveElement(e);
            },
            textChanged: function(ev, id){
                const idx = _.findIndex(this.elements, ['id', id]);
                const e = this.elements[idx];

                if(e.selected && this.quill){
                    if(!this.quill.getSelection() || !this.quill.getSelection().length)
                        e.focused = false;
                }else{
                    e.focused = false;
                }

                Vue.set(this.elements, idx, e);
            },
            selectionChanged: function(id, ev){
                const idx = _.findIndex(this.elements, ['id', id]);
                const e = this.elements[idx];
                var selected = ev && ev.length > 0;
                e.selected = selected;
                
                Vue.set(this.elements, idx, e);

                const editor = this.$refs[`inlineEditor${id}`][0].$el;
                const toolbar = editor.querySelector(".ql-toolbar");

                e.focused = selected;

                if(selected){
                    const bounds = this.quill.getBounds(ev.index);
                    // const dx = bounds.left >= 175 ? 175 : 0;
                    var toolbarRect = toolbar.getBoundingClientRect();
                    var editorRect = editor.getBoundingClientRect();
                    
                    let dx = 0;

                    const toolbardiff = bounds.left + toolbarRect.width - editorRect.width;
                    if(toolbardiff > 0){
                        dx = toolbardiff / 2;
                    }
                    
                    toolbar.style.top = bounds.top - 46 + "px";
                    toolbar.style.left = bounds.left - dx + "px";
                }else{
                    toolbar.style.top = "-36px";
                    toolbar.style.left = 0;
                }
            },

            autosave: _.debounce(function(){
                this.publish()
            }, 2000),

            setHtml: function(){
                let html = _.reduce(this.elements, function(html_string, el) {
                    
                    if(el.component == "bc-text"){
                        const outerDiv = document.createElement("div");
                        outerDiv.classList.add('blogpost-section-wrapper');
                        outerDiv.innerHTML = el.options.text;

                        return html_string + outerDiv.outerHTML;
                    }
                    else
                        return html_string + el.options.html;
                }, "");

                this.html_text = html;
            },

            publish: function(with_date){
                this.saving_result = {};

                this.setHtml();
                let elements = _.cloneDeep(this.elements);
                let cover = _.cloneDeep(this.cover);
                const last_element = _.last(elements);
                if(last_element.component == "bc-text" && last_element.options.text == ""){
                    elements.pop();
                }

                const creator_json = {
                    cover,
                    elements
                }

                let data = {
                    title: this.title ? this.title.replace(/'/g, "\\'") : "",
                    author: this.author ? this.author.replace(/'/g, "\\'") : "",
                    cover_url: cover ? cover.options.url : '',
                    body: this.html_text,
                    creator_json: JSON.stringify(creator_json),
                    published_at: with_date ? moment(new Date()).format("YYYY-MM-DD HH:mm:ss") : null
                    //,'_token':   this.token
                }

                if(this.blogId)
                    data.id = this.blogId;

                console.log("current id: ", this.blogId);

                this.saving = true;
                this.saving_result = {message: 'Saving...'};
                
                axios.post(this.saveUrl, data)
                    .then(response => {
                        const res = response.data;

                        this.saving = false;
                        this.saving_result = {success: res.status};

                        if(!res.status)
                            this.saving_result.message = res.message ? res.message : 'Failed to saved changes!';

                        setTimeout(() => {
                            this.saving_result = {};
                        }, 1000);

                        console.log("Saved", res);

                        if(res.new_id){
                            this.blogId = res.new_id;
                        }

                        if(res.redirect_url)
                            history.pushState({}, "editting", res.redirect_url);
                    }, error => {
                        this.saving = false;
                        this.saving_result = {success: false, message: 'Failed to save, please check your network.'};
                        console.log('Save error', error);
                    });
            }
        },

        watch: {
            elements:{
                deep: true,
                handler: function(new_elements){
                    this.setHtml();
                    this.autosave;
                    // const was_empty = this.html_text.length < 1;
                    // if(!was_empty){
                    //     this.autosave();
                    // }
                }
            },
            title:{
                deep: true,
                handler: function(new_title, old_title){
                    if(!old_title && new_title && new_title.length)
                        this.autosave();
                    else if(old_title && old_title.length && old_title != new_title)
                        this.autosave();
                }
            }
        },

        components : {
            'bc-header' : BCHeader,
            'bc-aside' : BCAside,
            'bc-element-picker' : BCElementPicker,
            'bc-text' : BCText,
            'bc-alert' : BCAlert,
            'bc-editor': BCEditor,
            'bc-quote': BCQuote,
            'bc-youtube-video': BCYoutubeVideo,
            'file-uploader': FileUploader,
            'bc-image': BCImage,
            'bc-separator': BCSeparator,
            'vue-editor': VueEditor,
            'emoji-autocomplete': EmojiAutoComplete
        },

        filters: {
            json: s => JSON.stringify(s)
        }
    }
</script>
