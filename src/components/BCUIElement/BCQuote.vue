<template>
    <blockquote :owner="owner">
        {{options.text}}
    </blockquote>
</template>

<script>
import BcElement from './BcElement.vue';
export default {
    extends: BcElement,
    computed: {
        owner: function(){
            return this.options.author && this.options.author.length ? this.options.year && this.options.year.length ? this.options.author + ' - ' + this.options.year : this.options.author : 'no-owner';
        }
    }
}
</script>