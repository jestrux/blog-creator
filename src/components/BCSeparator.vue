<style>
    .separator-hr:before{
        content: '...';
        letter-spacing: 0.5em;
    }
</style>

<template>
    <hr class="separator-hr">
</template>

<script>
    import BcElement from './BcElement.vue';
    export default {
        extends: BcElement
    }
</script>