<style>
    *{
        box-sizing: border-box;
    }

    body{
        background: #ddd;
    }

    #insightBody{
        width: calc(var(--wrapper-width) + 140px);
        margin: 0 auto;
        padding: 8px 70px;
        background: #fff;
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
        margin-top: 40px;
        margin-bottom: 80px;
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
                        <bc-text
                            :ref="`textEditor${element.id}`"
                            v-if="element.component == 'bc-text'"
                            :key="index" 
                            v-model="elements[index]"
                            @showOptions="showOptions(...$event)"
                            @enterClicked="addAndFocusTextField(index)"
                            @deleteClicked="deleteClickedOnTextField(index)"
                            @upClicked="upClickedOnTextField(index)"
                            @downClicked="downClickedOnTextField(index)"
                        />

                        <bc-ui-element
                            v-else
                            :key="element.id"
                            :element="element"
                            @input="element.options.html = $event"
                            @editElement="editElement($event)"
                            @removeElement="removeElement($event)"
                        />
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

    Vue.filter('formatDate', function(value) {
        if (value) {
            return moment(String(value)).format('MMMM DD, YYYY')
        }
    });

    import { choices } from '../choices'

    import { db_blog } from '../blog'

    import autosize from 'autosize'

    import BCHeader from './BCHeader.vue'
    import BCAside from './BCAside.vue'
    import BCElementPicker from './BCElementPicker.vue'
    
    import BCUIElement from './BCUIElement'
    import BCText from './BCUIElement/BCText'
    import BCEditor from './BCEditor'

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
                choices : choices,
                elements : [],
                editting: false,
                curelement: {},
                arranging: false,
                handler: new Vue(),
                showChoices: {},
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
                }
                else
                    console.log("Creator json not found....");

                if(!this.elements.length || _.last(this.elements).component != "bc-text")
                    this.addBufferText();
            }catch(err){
                this.title = "";
                this.elements = [];

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

            showOptions(target, element){
                this.entry_idx = _.findIndex(this.elements, ['id', element.id]);

                const box = target.getBoundingClientRect();
                this.showChoices = {status: true, position : {left: box.left, top:box.top}}
            },

            addElement(el, auto_edit = true, add_pos){
                this.showChoices = {};

                if(el.component != 'cover' && (!el.label || !el.label.length)){
                    let len = _.filter(this.elements, ['name', el.name]).length;
                    el.label = el.name + " " + len;
                }

                if(!auto_edit || el.component == 'bc-separator')
                    return this.saveElement(el, true, add_pos);
                else
                    return this.editElement(el);
            },

            editElement: function(el){
                this.curelement = el;
                this.editting = true;
            },

            removeElement: function(id){
                var idx = _.findIndex(this.elements, ['id', id]);
                this.elements.splice(idx, 1);
                this.autosave();
            },
            
            upClickedOnTextField(index){
                const elementAbove = this.elements[index - 1];

                if(elementAbove && elementAbove.component === 'bc-text')
                    this.$refs[`textEditor${elementAbove.id}`][0].focus();
            },
            
            downClickedOnTextField(index){
                const elementBelow = this.elements[index + 1];

                if(elementBelow && elementBelow.component === 'bc-text')
                    this.$refs[`textEditor${elementBelow.id}`][0].focus();
            },
            
            deleteClickedOnTextField(index){
                const is_last = index == this.elements.length - 1;
                const elementAbove = this.elements[index - 1];

                if(index != 0 && (!is_last || elementAbove.component === 'bc-text')){
                    this.removeElement(this.elements[index].id);
                    this.$refs[`textEditor${elementAbove.id}`][0].focus();
                }
            },
            
            addAndFocusTextField(position){
                const newEditorId = this.addElement(
                    this.getEmptyTextElement('Continue writting here...'),
                    false,
                    position
                );

                setTimeout(() => {
                    const new_editor = this.$refs[`textEditor${newEditorId}`][0];
                    new_editor.focus();
                }, 5);
            },

            saveElement: function(e, not_edited, add_pos){
                this.editting = false;
                
                if(!e)
                    return;

                if(e.component === 'cover'){
                    this.cover = e;
                    this.curelement = {};

                    this.publish();
                    return;
                }
                
                var idx = _.findIndex(this.elements, ['id', e.id]);
                
                if(!not_edited && (!e.label || !e.label.length)){
                    let len = _.filter(this.elements, ['name', e.name]).length;
                    e.label = e.name + " " + len;
                }

                if(idx != -1){
                    this.elements = this.elements.map((elem, index) => {
                        if(index === idx){
                            return {
                                ...e,
                                id: (Math.random() * 1e32).toString(36)
                            };
                        }
                        return elem;
                    });
                    // Vue.set(this.elements, idx, e);
                }
                else{
                    const last_element = _.last(this.elements);

                    // remove auto added last empty text element
                    const newRandomId = (Math.random() * 1e32).toString(36);
                    e.id = newRandomId;
                    
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
                                    this.addAndFocusTextField(this.entry_idx + 1);
                                else
                                    this.addAndFocusTextField(this.entry_idx + 1);
                            }
                            else if(e.component === 'bc-separator')
                                this.addAndFocusTextField(this.elements.length);

                            this.autosave();
                        }

                        this.entry_idx = -1;
                    }

                    return newRandomId;
                }

                this.curelement = {};
                this.editting = false;
            },

            cancelEditting: function(){
                this.curelement = {};
                this.editting = false;
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
            'bc-editor': BCEditor,
            'bc-ui-element': BCUIElement,
            'bc-text': BCText
        },

        filters: {
            json: s => JSON.stringify(s)
        }
    }
</script>
