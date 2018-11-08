<style scoped>
    #fileUploader{
      position: relative;
    }

    img{
      width: 100%;
      max-height: 300px;
      object-fit: cover;
      object-position: center;
    }

    #audioDrop{
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 150px;
      background-color: #e8e8e8;
      border-bottom: 1px solid #eee;
      padding: 1em;
      text-align: center;
      font-size: 0.9em;
      border: 3px dashed transparent;
    }

    #audioDrop.hover{
      border-color: #ccc;
      margin: 2px;
    }

    #loader{
      background: rgba(255, 255, 255, 0.97);
      color: #854dfe;
    }

    #audioDrop:before{
      content: 'Drop your file here to upload.';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      margin: auto;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    #error{
      display: flex;
      flex-direction: column;
      justify-content: center;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      text-align: center;
      background: rgba(199, 76, 76, 0.97);
      color: #fff;
    }
</style>

<template>
  <div id="fileUploader">
    <img :src="src" alt="" width="100%" v-if="src">

    <div id="audioDrop" v-else></div>

    <div id="loader" v-if="uploading">
      <span></span>
      Uploading... {{progress}}%
    </div>
    
    <div id="error" v-if="upload_error != null">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z"/></svg>
      {{ upload_error }}
      <span id="errorCloser" @click="upload_error = null">Close</span>
    </div>
  </div>
</template>

<script>
  import {em, Init} from "../filedrag";

  // TODO: Fix second upload error

  var self;
  
  export default {
    props: {
      imageUploadUrl: String,
      location: String,
    },
    data: function() {
      return{
        uploading: false,
        upload_error: null,
        progress: 0,
        src: ""
      }
    },
    mounted: function() {
      self = this;
      Init(this.$el, this.imageUploadUrl);
      // console.log(this.imageUploadUrl);

      em.once('loaded', function(file, src) {
        self.src = src;
        self.uploading = true;
      });
      
      em.once('progressed', function(progress) {
        // console.log("Progress changed: ", progress);
        self.progress = progress;
      });
      
      em.once('complete', function(status, payload) {
        self.uploading = false;
        // console.log("Completed successfully: ", status, payload);

        if(status)
          self.$emit("input", src);
        else
          this.upload_error = payload;
      });
    },
    methods: {
      
    }
  }
</script>