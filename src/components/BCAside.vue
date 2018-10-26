<style scoped>
    aside{
        position: fixed;
        top: 120px;
        right: 3em;
        display: flex;
        flex-direction: column;
        width: 340px;
        display: block;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 1.5em;
        z-index: 10;
    }

    aide > h1 {
        font-family: Bariol;
        margin-top: 0;
        margin-bottom: -0.3em;
    }

    aside > p{
        font-size: 1em;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        line-height: 1.4em !important;
    }

    #elementsWrapper{
        margin-top: 1em;
        padding-top: 1em;
        border-top: 1px solid #ddd;
        flex: 1;
    }

    .element{
        font-size: 0.95em;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        border-radius: 5px;
        background: #eee;
        padding: 1.2em 1em;
        margin-bottom: 0.5em;
    }

    .element > p {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
        max-height: 40px;
        min-height: 12px;
        margin: 0;
        /* background: #00f; */
    }

    .element p:not(:first-child){
        display: none !important;
    }

    #closer{
        background: transparent;
        border: none;
        margin-top: -10px;
    }

    #closer svg{
        width: 30px;
        height: 30px;
    }

    .layout{
        display: flex;
    }

    .flex{
        flex: 1
    }
</style>

<template>
    <aside>
        <div class="layout">
            <h1 class="flex">Arrange Sections</h1>
            <button id="closer" @click="$emit('cancel')">
                <svg enable-background="new 0 0 100 100" id="Layer_1" version="1.1" viewBox="0 0 100 100" xml:space="preserve"><polygon fill="#010101" points="77.6,21.1 49.6,49.2 21.5,21.1 19.6,23 47.6,51.1 19.6,79.2 21.5,81.1 49.6,53 77.6,81.1 79.6,79.2   51.5,51.1 79.6,23 "/></svg>
            </button>
        </div>
        <p>Drag sections to sort them in order that you want them to appear in.</p>
        
        <div id="elementsWrapper">
            <draggable v-model="els">
                <transition-group>
                    <div class="element" v-for="(element, index) in els" :key="index">
                        <p v-html="element.component === 'bc-text' ? element.options.text : element.label.toUpperCase()"></p>
                    </div>
                </transition-group>
            </draggable>
        </div>
    </aside>
</template>

<script>
import draggable from 'vuedraggable'

export default {
    props: {
        elements: Array
    },
    components: {
        draggable
    },
    
    computed: {
        els: {
            get: function(){
                return this.elements;
            },
            set: function(new_elements){
                this.$emit('input', new_elements);
            }
        }
    }
}
</script>