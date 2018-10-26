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
</style>

<template>
  <div id="fileUploader">
    <img :src="src" alt="" width="100%" v-if="src">

    <div id="audioDrop" v-else></div>

    <div id="loader" v-if="uploading">
      <span></span>
      Uploading... {{progress}}%
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
      
      em.once('complete', function(status, src) {
        self.uploading = false;
        // console.log("Completed successfully: ", status, src);

        if(status)
          self.$emit("input", src);
      });
    },
    methods: {
      
    }
  }
</script>