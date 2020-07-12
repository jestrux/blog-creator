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
        position: relative;
        content: 'Press enter to add image';
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        color: #aaa;
        display: block;
        margin-top: 0.2em;
        font-size: 0.8em;
    }

    #linkInputWrapper:not(.typing):after{
        /* opacity: 0; */
        display: none;
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

            <div v-if="src === null && youtubeApiKey">
                <button :class="{'active' : source === 0}"
                    @click="source = 0">
                    <svg viewBox="0 0 24 24"><path d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z"/></svg>
                    Link
                </button>

                <button v-if="youtubeApiKey && youtubeApiKey.length" :class="{'active' : source === 1}"
                    @click="source = 1">
                    <svg version="1.1" id="Capa_1" viewBox="0 0 418.261 418.261" style="enable-background:new 0 0 418.261 418.261;" xml:space="preserve"><path d="M129.13,80v144l128-72L129.13,80z M145.13,107.358L224.494,152l-79.363,44.642V107.358z"/><path d="M353.13,181.58V48c0-26.51-21.492-48-48-48h-256c-26.508,0-48,21.49-48,48v208c0,26.51,21.492,48,48,48h181.578 c2.062,5.82,4.656,11.372,7.742,16.615l-58.789,59.044c-6.242,6.256-6.23,16.389,0.027,22.629l11.332,11.301 c3.121,3.115,7.211,4.672,11.297,4.672c4.102,0,8.203-1.566,11.328-4.699l58.718-58.974C286.67,363.054,303.302,368,321.13,368 c53.019,0,96-42.981,96-96C417.13,230.218,390.392,194.773,353.13,181.58z M225.13,272c0,5.464,0.562,10.786,1.438,16H49.13 c-17.645,0-32-14.355-32-32V48c0-17.646,14.355-32,32-32h256c17.645,0,32,14.354,32,32v129.439 c-5.215-0.877-10.535-1.439-16-1.439C268.111,176,225.13,218.981,225.13,272z M202.318,402.261l-11.32-11.313l56.809-57.052 c3.45,4.082,7.234,7.863,11.309,11.319L202.318,402.261z M321.13,352c-44.114,0-80-35.888-80-80s35.886-80,80-80s80,35.888,80,80 S365.244,352,321.13,352z"/><path d="M369.13,272.001c0,26.466-21.535,47.998-48,47.998v16c35.344,0,64-28.652,64-63.998H369.13z"/></svg>
                    Search
                </button>
            </div>

            <button v-if="src !== null"
                @click="src = null">Change
            </button>
        </label>

        <div v-if="src === null">
            <div id="linkInputWrapper" :class="{'typing': !src && enteringLink}" v-if="source === 0">
                <input type="text" placeholder="Enter video link and press enter" 
                @keyup.enter="src = $event.target.value"
                @keyup.ctrl.86="src = $event.target.value"
                @keyup.91.86="src = $event.target.value"
                @keyup.93.86="src = $event.target.value"
                @keyup="enteringLink = $event.target.value.length > 0">

                <button :class="{'clickable' : !enteringLink && clipboardText != null}"
                    @click="src = clipboardText">Paste</button>
            </div>
        
            <youtube-search
                :api-key="youtubeApiKey"
                per-page="4"
                v-else-if="youtubeApiKey && youtubeApiKey.length && source === 1" v-model="src"/>
        </div>

        <div id="imageWrapper">
            <iframe v-if="src !== null" width="100%" :height="videoHeight + 'px'" 
                :src="embed" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
    </div>
</template>

<script>

import YoutubeSearch from "./YoutubeSearch";
import Visibility from "visibilityjs";

export default {
    props: {
        url: String
    },
    mounted(){
        const parent = this.$root.$children[0];
        this.youtubeApiKey = parent.youtubeApiKey;

        // set dynamic height for youtube video
        this.videoHeight = this.$el.getBoundingClientRect().width * 9 / 16;

        this.src = this.url && this.url.length ? this.url : null;
        this._setupClipboard(this.source);
        Visibility.change((e, state) => {
            if(state === 'visible'){
                if(this.source === 0){
                    // Hack to reload clipboard text
                    this.source = -1;
                    setTimeout(() => {
                        this.source = 0;
                    });
                }
            }
        });
    },
    data() {
        return {
            youtubeApiKey: "",
            enteringLink: false,
            clipboardText: null,
            src: null,
            source: 0,
            embed: null,
            videoHeight: 0
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
                    const match = this._parseYoutubeUrl(val);
                    if(match)
                        this.embed = `https://www.youtube.com/embed/${match[2]}?rel=0&amp;showinfo=0`;
                }
            }
        }
    },
    methods: {
        _parseYoutubeUrl(url){
            var reg = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/
            return url.match(reg);
        },
        _setupClipboard: function(val){
            navigator.clipboard.readText()
                .then(text => {
                    if(text && text.length && this._isValidYoutubeURL(text)){
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
        },
        _isValidYoutubeURL : function(str){
            var pattern = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
            
            if(!pattern.test(str)) {
                return false;
            } else {
                return this._parseYoutubeUrl(str);
            }
        }
    },
    components: {
      YoutubeSearch
    }
}
</script>