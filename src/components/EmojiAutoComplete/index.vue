<style>
    .emoji-autocomplete{
        position: absolute;
        z-index: 10;
    }

    .emoji-autocomplete-list{
        background: #fff;
        box-shadow: 1px 1px 5px 1px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        min-width: 150px;
        max-width: 220px;
        max-height: 200px;
        overflow-x: hidden;
    }

    .emoji-item{
        display: flex;
        align-items: center;
        padding: 0 1em;
        height: 50px;
    }

    .emoji-icon{
        flex-shrink: 0;
        font-size: 1.1em;
        min-width: 24px;
        text-align: center;
        margin-right: 0.75em;
    }
    
    .emoji-name{
        font-size: 0.8em;
        letter-spacing: 0.05em;
    }
</style>

<template>
    <div class="emoji-autocomplete" :style="styleObject">
        <div class="emoji-autocomplete-list">
            <div class="emoji-item" v-for="(value, key) in emojis" :key="key"
                @click="$emit('selected', value)">
                <span class="emoji-icon">{{value}}</span>
                <span class="emoji-name">:{{key}}</span>
            </div>
        </div>
    </div>
</template>

<script>
    import _ from "lodash";
    import rawEmojis from './emojis';
    export default {
        props: {
            filter: String,
            pos: Object
        },
        computed: {
            emojis: function(){
                if(!this.filter)
                    return rawEmojis;
                else
                    return _.pickBy(rawEmojis, (value, key) => key.indexOf(this.filter) != -1)
            },
            styleObject: function(){
                let top = this.pos ? this.pos.top : 200;
                let left = this.pos ? this.pos.left : 120;

                top+= 'px';
                left+= 'px';

                return {top,left}
            }
        }
    }
</script>