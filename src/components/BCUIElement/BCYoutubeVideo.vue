<template>
    <div>
        <div :class="['video-iframe', options.width, {'playing': !options.type || options.type === 'simple' || playing}]">
            <iframe width="100%" height="100%" 
                :src="embed" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            <!-- <img v-if="options.type && options.type === 'wrapped'" :src="image"> -->
            <!-- <div class="cover layout center-center" v-if="options.type && options.type === 'wrapped''">
                <button class="layout center-center" @click="playing = true">
                    <svg fill="#fff" width="56" height="56" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                </button>
            </div> -->
        </div>
        <small v-if="options.caption && options.caption.length" v-text="options.caption"></small>
    </div>
</template>

<script>
import BcElement from './BcElement.vue';
export default {
    extends: BcElement,
    data: function(){
        return{
            playing: false
        }
    },
    computed: {
        id: function(){
            var reg = /^.*(youtu\.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/
            const src = this.options.url || this.options.source;
            var match = src.match(reg);
            return match[2];
        },
        image: function(){
            return `https://i.ytimg.com/vi/${this.id}/hqdefault.jpg`;
        },
        embed: function(){
            return `https://www.youtube.com/embed/${this.id}?rel=0&amp;autoplay=${this.playing ? 1 : 0}&amp;controls=${this.options.controls ? 1: 0}&amp;showinfo=0`;
        }
    }
}
</script>