<style scoped>
    label{
        display: block;
        margin-bottom: 0.1em;
    }

    label:first-letter{
        text-transform: uppercase;
    }

    input, select, textarea{
        background: transparent;
        -webkit-appearance: none;
        box-sizing: border-box;
        padding: 0.3em 0.5em;
        font-size: 1.25em;
        width: 100%;
        border: 1px solid #ddd !important;
        resize: none;
    }

    select{
        background: #fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' fill='%23999'><polygon points='0,0 100,0 50,50'/></svg>") no-repeat scroll 96.5% 60%;
        background-size: 12px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }
</style>

<template>
    <div>
        <label v-if="!nolabel && field.type !== 'image' && field.type !== 'youtube'">{{field.name}}</label>
        
        <input v-if="field.type == 'number'" type="number" v-model="field.value">

        <select v-else-if="field.type == 'choice'" v-model="field.value">
            <option disabled value="">Choose {{field.name}}</option>

            <option v-for="(choice, index) in field.choices" :key="index" :value="choice">
                {{ choice }}
            </option>
        </select>

        <textarea v-else-if="field.type == 'long-text'" v-model="field.value" rows="5"></textarea>

        <vue-editor v-else-if="field.type == 'ws-text'" :editorToolbar="customToolbar" v-model="field.value"></vue-editor>
        
        <bc-image-field
            v-else-if="field.type == 'image'" 
            v-model="field.value"
            :url="field.value"/>
        
        <bc-youtube-field
            v-else-if="field.type == 'youtube'" v-model="field.value"
            :url="field.value"/>
        
        <textarea ref="input" v-else rows="1" :placeholder="field.default" v-model="field.value"></textarea>
    </div>
</template>

<script>
import { VueEditor } from "vue2-editor";
import autosize from 'autosize'
import BcImageField from "./BCImageField";
import BCYoutubeField from "./BCYoutubeField";

export default {
    props: {
        field : Object,
        nolabel: Boolean
    },
    mounted: function(){
        const input = this.$refs.input;
        if(input){
            autosize(input);
        }

        // const parent = this.$root.$children[0];
        // this.imageUploadUrl = parent.imageUploadUrl;
        // this.unsplashClientId = parent.unsplashClientId;
        // this.youtubeApiKey = parent.youtubeApiKey;
    },
    watch: {
        field: {
            immediate: true, 
            handler (val, oldVal) {
                
            }
        }
    },
    data() {
        return {
            blogHTML: "",
            customToolbar: [
                [{ header: [false, 1, 2, 3, 4, 5, 6] }],
                ['bold', 'italic', 'underline'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ indent: "-1" }, { indent: "+1" }], // outdent/indent
                [{ color: [] }, { background: [] }],
                ['link']
            ]
        };
    },
    components: {
      VueEditor,
      BcImageField,
      'bc-youtube-field' : BCYoutubeField
    }
}
</script>