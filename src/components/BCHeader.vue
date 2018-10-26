<template>
    <header>
        <div id="headerWrapper">
            <h1>Create post</h1>

            <div class="layout center">
                <!-- <button class="white" @click="$emit('draft')">
                    SAVE DRAFT
                </button> -->
                <p id="saveMessage" :class="{'error': save.success === false}">
                    {{save.message}}
                </p>
                <button class="black" @click="$emit('publish')">
                    PUBLISH POST
                </button>
            </div>
        </div>
    </header>
</template>

<script>

export default {
    props: {
        save: Object
    }
}
</script>

<style scoped>
    header{
        z-index: 10;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        background: #fff;
        transition: all 0.35s ease-out;
    }

    h1{
        letter-spacing: 0.04em;
        font-family: 'Bariol Light' !important;
    }

    #headerWrapper{
        max-width: 1100px;
        margin: auto;
        padding: 0 2em;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #saveMessage{
        min-width:70px; margin-right: 2em;
    }
    
    #saveMessage.error{
        color: red;
    }

    button{
        font-size: 0.85em;
        line-height: 0;
        background: transparent;
        border-radius: 3px;
        background: orange;
        color: #fff8ec;
        color: #333;
        border: none;
        padding: 1.25em 1.5em;
    }

    button.white{
        background: white;
        border: 1px solid #999;
    }
    
    button.black{
        background: #333;
        color: #fff;
    }
</style>
