<style scoped>
    #elementPicker{
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        pointer-events: none;
        z-index: 11;
    }

    #elementsWrapper{
        position: fixed;
        top: 120px;
        left: 120px;
        border-radius: 3px;
        background: #fff;
        box-shadow: 0 1px 3px 2px rgba(0, 0, 0, 0.1);
        pointer-events: auto;
    }

    #title{
        display: block;
        display: none;
        padding: 1em 0.5em;
    }

    #closer{
        position: absolute;
        right: -6px;
        top: -6px;
        background: #000;
        border: none;
        display: block;
        padding: 0;
        height: 24px;
        width: 24px;
        border-radius: 50%;
        line-height: 1;
        z-index: 1;
        outline: none;
    }

    #closer svg{
        fill: #fff;
        width: 12px;
        height: 12px;
    }
    
    #elements{
        cursor: pointer;
        display: flex;
        flex-wrap: wrap;
    }

    .element{
        position: relative;
        text-align: center;
        padding: 0.9em 1.1em;
        padding-bottom: 0.4em;
    }

    .element i{
        display: block;
        margin-bottom: 0.1em;
    }

    .element label{
        display: none;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size: 0.7em;
        position: absolute;
        background: #333;
        color: #fff;
        padding: 0.3em 1em;
        border-radius: 3px;
        left: 50%;
        transform: translate3d(-50%, 0, 0);
        transition: all 0.25s ease-out;
    }

    .element:not(:hover) label{
        transform: translate3d(-50%, 50%, 0);
        opacity: 0;
    }

    #elementPickerBg{
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        pointer-events: auto;
    }
</style>

<template>
    <div id="elementPicker">
        <div id="elementPickerBg" @click="$emit('cancel')" v-show="show"></div>
        <transition @before-enter="beforeEnter" @enter="enter" @leave="leave" :css="true">
            <div id="elementsWrapper" v-show="show">
                <label id="title">Add Element</label>

                <button id="closer" @click="$emit('cancel')">
                    <svg viewBox="0 0 24 24"><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/></svg>
                </button>

                <div id="elements">
                    <div class="element" v-for="(element, index) in elements" 
                        :title="element.name"
                        :key="index"
                        @click="addElement(index)">

                        <i v-html="element.icon"></i>

                        <label>{{element.name}}</label>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>

import _ from 'lodash'

export default {
    props: {
        elements: Array,
        showElements: Object
    },

    methods: {
        addElement: function(idx){
            var el = _.cloneDeep(this.elements[idx]);
            this.$emit('add', el);
        },

        beforeEnter: function(el){
            el.style.left = this.positionStyle.left;
            el.style.top = this.positionStyle.top;
        },

        enter: function (el, done) {
            const slideIn = el.animate([
				{opacity: 0, transform: "translateX(-20%)"},
				{opacity: 1, transform: "none"}
            ], {duration: 100, easing: 'ease-out'});
            
            slideIn.onfinish = function(){
                done();
            };
        },

        leave: function (el, done) {
            const slideOut = el.animate([
                {transform: "none"},
				{transform: "translateX(-20%)"}
			], {duration: 100, easing: 'ease-in'});

            slideOut.onfinish = function(){
                done();
            };
        }
    },
    computed: {
        show: function(){
            return this.showElements && this.showElements.status;
        },
        positionStyle: function(){
            if(!this.showElements || !this.showElements.position)
                return {};

            const pos = this.showElements.position;
            return { left: pos.left + 'px', top: pos.top + 'px' }
        }
    }
}
</script>