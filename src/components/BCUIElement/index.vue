<style>
    
</style>

<template>
    <component
        :is="element.component"
        :component="element.component"
        :options="element.options"
        v-model="element.options.html"/>
</template>

<script>
    import BCText from './BCText.vue'
    import BCAlert from './BCAlert.vue'
    import BCQuote from './BCQuote.vue'
    import BCYoutubeVideo from './BCYoutubeVideo.vue'
    import BCImage from './BCImage.vue'
    import BCSeparator from './BCSeparator.vue'

    export default {
        props:{
            element: Object
        },

        components : {
            'bc-text' : BCText,
            'bc-alert' : BCAlert,
            'bc-quote': BCQuote,
            'bc-youtube-video': BCYoutubeVideo,
            'bc-image': BCImage,
            'bc-separator': BCSeparator
        }
    }
</script>
