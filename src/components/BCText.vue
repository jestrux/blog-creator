<template>
    <p v-html="options.text"></p>
</template>

<script>
import BcElement from './BcElement.vue';
export default {
    extends: BcElement
}
</script>