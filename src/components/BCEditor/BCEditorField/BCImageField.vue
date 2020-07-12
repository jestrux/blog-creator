<style scoped>
    #bcImageWrapper{
    }

    label{
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.7em;
    }

    label:first-letter{
        text-transform: uppercase;
    }

    input{
        background: transparent;
        -webkit-appearance: none;
        box-sizing: border-box;
        padding: 0.3em 0.5em;
        font-size: 1.25em;
        width: 100%;
        border: 1px solid #ddd !important;
        resize: none;
    }

    button{
        display: inline-flex;
        align-items: center;
        border-radius: 30px;
        padding: 0.5em 1em;
        padding-right: 1.3em;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        margin-right: 0.2em;
        outline: none;
        letter-spacing: 0.15em;
        font-size: 0.65em;
    }

    button:not(.active):hover{
        /* background: #e0e0e0; */
    }
    
    button.active{
        cursor: default;
        background: #eaeaea;
    }

    button svg{
        width: 18px;
        height: 18px;
        margin-right: 0.7em;
        margin-left: 0.2em;
    }

    #imageWrapper{
        position: relative;
        /* display: flex;
        justify-content: center; */
        background: #f5f5f5;
        text-align: center;
    }

    #imageWrapper img{
        display: inline-block;
        max-width: 100%;
        min-height: 200px;
        max-height: 450px;
        object-fit: cover;
    }

    #linkInputWrapper{
        position: relative;
    }
    
    #linkInputWrapper:after{
        position: absolute;
        content: 'Press enter to add image';
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        color: #aaa;
        display: block;
        margin-top: 0.2em;
        font-size: 0.8em;
    }

    #linkInputWrapper:not(.typing):after{
        opacity: 0;
    }
    
    #linkInputWrapper button{
        text-transform: uppercase;
        letter-spacing: 0.15em;
        border: 1px solid #999;
        border-radius: 3px;
        padding: 0.25em 0.8em;
        background: transparent;
        outline: none;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        right: 0;
        margin: 0 0.8em;
    }

    #linkInputWrapper button:not(.clickable){
        pointer-events: none;
        opacity: 0;
    }
</style>

<template>
    <div id="bcImageWrapper">
        <label>
            Source
            &nbsp;

            <div v-if="src === null && (imageUploadUrl || unsplashClientId)">
                <button v-if="imageUploadUrl && imageUploadUrl.length" :class="{'active' : source === 0}"
                    @click="source = 0">
                    <svg viewBox="0 0 24 24"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
                    Upload
                </button>

                <button :class="{'active' : source === 1}"
                    @click="source = 1">
                    <svg viewBox="0 0 24 24"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                    Link
                </button>

                <button v-if="unsplashClientId && unsplashClientId.length" :class="{'active' : source === 2}"
                    @click="source = 2">
                    <svg viewBox="0 0 24 24"><path fill="none" d="M0 0h24v24H0V0z"/><path d="M18 13v7H4V6h5.02c.05-.71.22-1.38.48-2H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-5l-2-2zm-1.5 5h-11l2.75-3.53 1.96 2.36 2.75-3.54zm2.8-9.11c.44-.7.7-1.51.7-2.39C20 4.01 17.99 2 15.5 2S11 4.01 11 6.5s2.01 4.5 4.49 4.5c.88 0 1.7-.26 2.39-.7L21 13.42 22.42 12 19.3 8.89zM15.5 9C14.12 9 13 7.88 13 6.5S14.12 4 15.5 4 18 5.12 18 6.5 16.88 9 15.5 9z"/></svg>
                    Search
                </button>
            </div>

            <button v-if="src !== null"
                @click="src = null">Change
            </button>
        </label>

        <div v-if="src === null">
            <div id="linkInputWrapper" :class="{'typing': !src && enteringLink}" v-if="source === 1">
                <input type="text" placeholder="Enter image link and press enter" 
                @keyup.enter="src = $event.target.value"
                @keyup.ctrl.86="src = $event.target.value"
                @keyup.91.86="src = $event.target.value"
                @keyup.93.86="src = $event.target.value"
                @keyup="enteringLink = $event.target.value.length > 0">

                <button :class="{'clickable' : !enteringLink && clipboardText != null}"
                    @click="src = clipboardText">Paste</button>
            </div>
        
            <unsplash-search
                :client-id="unsplashClientId"
                per-page="6"
                v-else-if="unsplashClientId && unsplashClientId.length && source === 2" v-model="src"/>

            <file-uploader 
                v-else-if="source === 0 && imageUploadUrl && imageUploadUrl.length" v-model="src"
                :image-upload-url="imageUploadUrl"/>
        </div>

        <div id="imageWrapper">
            <img v-if="src !== null" :src="src" alt="">
        </div>
    </div>
</template>

<script>
import FileUploader from "./FileUploader";
import UnsplashSearch from "./UnsplashSearch";
import Visibility from "visibilityjs";

export default {
    props: {
        url: String
    },
    mounted(){
        const parent = this.$root.$children[0];
        this.imageUploadUrl = parent.imageUploadUrl;
        this.unsplashClientId = parent.unsplashClientId;

        this.source = this.imageUploadUrl && this.imageUploadUrl.length ? 0 : 1;
        this.src = this.url && this.url.length ? this.url : null;
        Visibility.change((e, state) => {
            if(state === 'visible'){
                if(this.source === 1){
                    // Hack to reload clipboard text
                    this.source = -1;
                    setTimeout(() => {
                        this.source = 1;
                    });
                }
            }
        });
    },
    data() {
        return {
            enteringLink: false,
            clipboardText: null,
            imageUploadUrl: "",
            unsplashClientId: "",
            src: null,
            source: 2
        }
    },
    watch: {
        source: {
            immediate: true, 
            handler (val, oldVal) {
                this._setupClipboard(val);
            }
        },
        src: {
            immediate: true, 
            handler (val, oldVal) {
                this._setupClipboard(this.source);

                if(val != null){
                    this.$emit("input", val);
                }
            }
        }
    },
    methods: {
        _setupClipboard: function(val){
            if(val === 1){
                navigator.clipboard.readText()
                    .then(text => {
                        if(text && text.length && this._isValidURL(text)){
                            this.clipboardText = text;
                            // console.log('Pasted content: ', text);
                        }else{
                            this.clipboardText = null;
                        }
                    })
                    .catch(err => {
                        this.clipboardText = null;
                        console.error('Failed to read clipboard contents: ', err);
                    });
            }
        },
        _isValidURL : function(str){
            var pattern = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
            
            if(!pattern.test(str)) {
                return false;
            } else {
                return true;
            }
        }
    },
    components: {
      FileUploader,
      UnsplashSearch
    }
}
</script>