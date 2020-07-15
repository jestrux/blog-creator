<template>
    <div :class="['blogpost-section-wrapper', 
        {'wide-image': (component === 'bc-image' || component === 'bc-youtube-video') && options.width === 'wide'},
        {'full-image': (component === 'bc-image' || component === 'bc-youtube-video') && options.width === 'full'}
        ]">
        <div class="component-wrapper" style="position: relative;">
            <div class="component-editor-buttons" :class="{'delete-only' : component === 'bc-separator'}">
                <button class="component-editor-button"
                    @click="$emit('editElement', element)">
                    <svg fill="#f18f16" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                </button>
                <button class="component-editor-button"
                    @click="$emit('removeElement', element.id)">
                    <!-- color: #e04b2a;color: #f18f16; -->
                    <svg fill="#e04b2a" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
                </button>
            </div>

            <component
                :is="component"
                :component="component"
                :options="options"
                @input="$emit('input', $event)" />
        </div>
    </div>
</template>

<script>
    import BCAlert from './BCAlert.vue'
    import BCQuote from './BCQuote.vue'
    import BCYoutubeVideo from './BCYoutubeVideo.vue'
    import BCImage from './BCImage.vue'
    import BCSeparator from './BCSeparator.vue'

    export default {
        props:{
            element: Object
        },

        data: function(){
            return{
                component: null,
                options: {}
            }
        },

        watch: {
            element:{
                immediate: true,
                deep: true,
                handler: function(newValue){
                    this.component = newValue.component;
                    this.options = newValue.options;
                }
            }
        },

        components : {
            'bc-alert' : BCAlert,
            'bc-quote': BCQuote,
            'bc-youtube-video': BCYoutubeVideo,
            'bc-image': BCImage,
            'bc-separator': BCSeparator
        }
    }
</script>
