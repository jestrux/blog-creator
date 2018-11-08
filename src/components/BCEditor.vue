<style scoped>
    #editorWrapper:not(.inline){
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 20;
        background: rgba(255, 255, 255, 0.975);
    }

    #closer{
        position: absolute;
        top: 2em;
        right: 2em;
        border: none;
        background: transparent;
    }

    #editorWrapper.inline #closer{
        display: none;
    }

    #label{
        font-size: 1.1em;
    }

    #editorWrapper:not(.inline) #bcEditor{
        width: 500px;
    }

    #bcEditor{
        background: #fff;
        box-shadow: 0 1px 8px 0.5px rgba(0, 0, 0, 0.2);
    }

    #bcEditor.text-only{
        border: none;
    }

    #label, #buttons{
        display: flex;
        align-items: center;
        background: #eee;
        padding: 0.8em 1em;
    }

    #buttons{
        border-top: 1px solid #eee;
        background: #f8f8f8;
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    #bcEditor.text-only{
        border-top: none;
    }

    #form{
        padding: 1em;
    }

    #bcEditor.text-only #form{
        padding: 0;
    }

    .editor-item + .editor-item{
        margin-top: 0.8em;
    }

    button{
        border: 1px solid #000;
        background: #333;
        color: #fff;
        font-size: 0.85em;
        padding: 0.31em 1.5em;
        border-radius: 5px;
        min-width: 90px;
        text-transform: uppercase;
    }

    button:first-child{
        background: transparent;
        color: #555;
        border-color: #999;
        margin-right: 0.5em;
    }
</style>

<template>
    <div id="editorWrapper" :class="{'open' : editting, 'inline': inline}">
        <button id="closer" @click="cancelEditting(element.id)">
            <svg enable-background="new 0 0 100 100" id="Layer_1" version="1.1" viewBox="0 0 100 100" xml:space="preserve"><polygon fill="#010101" points="77.6,21.1 49.6,49.2 21.5,21.1 19.6,23 47.6,51.1 19.6,79.2 21.5,81.1 49.6,53 77.6,81.1 79.6,79.2   51.5,51.1 79.6,23 "/></svg>
        </button>

        <div id="bcEditor" v-if="element" :class="{'text-only': element.component === 'bc-text'}">
            <div id="label">
                {{element.label}}
            </div>
            
            <div id="form">
                <div class="editor-item" v-for="(field, index) in fields" 
                    :key="index">

                    <bc-editor-field
                        :field="field" :nolabel="element.component === 'bc-text'"
                        ></bc-editor-field>

                </div>
            </div>

            <div id="buttons">
                <button @click="cancelEditting()">Cancel</button>
                <button @click="saveElement(element)">Save</button>
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'
import BCEditorField from './BCEditorField';

export default {
    methods: {
        cancelEditting: function(){
            this.$emit('cancel');
        },
        saveElement: function(element){
            const options = {};
            _.each(this.fields, function (val, key) {
                options[key] = val.value;
            });
            element.options = options;

            this.$emit('save', element);
        }
    },
    props: {
        element: Object,
        editting: Boolean,
        inline: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        fields: function(){
            return _.forIn(this.element.skeleton, (value, key) => {
                const obj = {};
                obj[key] = value;

                if(!this.element.options && value.type == "choice" && (!obj[key].value || !obj[key].value.length)){
                    obj[key].value = _.clone(value.default);
                }

                obj[key].name = key;

                return obj;
            });
        }
    },
    components: {
      'bc-editor-field': BCEditorField
    }
}
</script>