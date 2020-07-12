<template>
    <div>
        <img :class="[options.width]" :src="options.source" :alt="options.caption">
        <small v-if="options.caption && options.caption.length" v-text="options.caption"></small>
    </div>
</template>

<script>
import BcElement from './BcElement.vue';
export default {
    extends: BcElement,
    data: function(){
        return{
            useinner: true
        }
    },
}
</script>