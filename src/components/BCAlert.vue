<template>
    <div class="alert-box" :class="options.type">
        <span class="alert-name">Note:</span>
        {{options.text}}
    </div>
</template>

<script>
import BcElement from './BcElement.vue';
export default {
    extends: BcElement
}
</script>