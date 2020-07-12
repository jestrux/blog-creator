<style scoped>
  #wrapper{
    border: 1px solid #ddd !important;
    padding: 0.3em 0.5em;
    position: relative;
  }

  #wrapper:after{
      position: absolute;
      top: 40px;
      content: 'Press enter to search';
      font-family: Verdana, Geneva, Tahoma, sans-serif;
      color: #aaa;
      display: block;
      margin-top: 0.2em;
      font-size: 0.8em;
  }

  #wrapper:not(.typing):after{
    opacity: 0;
  }
  
  #wrapper.typing{
    margin-bottom: 1.7em;
  }
  
  input{
    background: transparent;
    -webkit-appearance: none;
    box-sizing: border-box;
    font-size: 1.25em;
    width: 100%;
    border: none;
    resize: none;
    outline: none;
  }

  #results{
    margin-top: 0.8em;
    columns:3;
    column-gap: 0.2em;
  }

  #emptyMessage{
    padding-top: 0.5em;
    padding-bottom: 0.3em;
    color: #777;
    margin-left: 0.1em;
    font-size: 0.9em;
  }

  #results img{
    width: 100%;
    /* margin-bottom: -0.1em; */
    min-height: 83px;
    background-color: #eee;
	  display:inline-block;
    transition: opacity 0.25s ease-out;
    cursor: pointer;
  }
  
  #results img:hover{
    opacity: 0.7;
  }

  #movers{
    position: absolute;
    top: 0;
    height: 38px;
    right: 0;
    padding: 0 0.8em;
    display: flex;
    align-items: center;
  }

  button{
    text-transform: uppercase;
    letter-spacing: 0.15em;
    border: 1px solid #999;
    border-radius: 3px;
    padding: 0.25em 0.8em;
    background: transparent;
    outline: none;
  }

  button:not(.clickable){
    pointer-events: none;
    opacity: 0.4;
  }
</style>

<template>
  <div id="wrapper" :class="{'typing': !fetched && typing}">
    <input type="text" v-model="query" 
      placeholder="Enter keywords and press enter"
      @keyup="startedTyping($event.target.value)"
      @keyup.enter="searchUnsplash($event.target.value)"/>
    
    <div id="movers" v-if="fetched && results.length > perPage">
      <button :class="{'clickable' : page > 1}"
        @click="page = page - 1">Prev</button>
      &emsp;
      <button :class="{'clickable' : results.length > page * perPage}"
        @click="page = page+1">Next</button>
    </div>

    <div v-if="!typing && fetched && results.length" id="results">
      <img v-for="(image, index) in results" 
        v-if="index >= (page - 1) * perPage && index < page * perPage"
        :style="{ background: image.color }"
        :key="index" :src="image.urls.small" alt=""
        @click="selectImage(image.urls.full)">
    </div>

    <div id="emptyMessage" v-if="!typing && (fetching || fetch_error || (fetched && !results.length))">
      <span v-if="fetching">
        Fetching images....
      </span>
      <span v-else-if="fetch_error" style="color: #dd5555">
        An error occured fetching images, check your network connection and try again.
      </span>
      <span v-else-if="!results.length">
        No results found for <strong>{{query}}</strong>
      </span>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';
  import Unsplash, { toJson } from 'unsplash-js';

  var self;
  
  export default {
    props: {
      perPage: {
        type: String,
        default: 10
      },
      clientId: String
    },
    data: function() {
      return{
        fetching: false,
        fetched: false,
        fetch_error: false,
        query: "",
        page: 1,
        results: [],
        typing: false
      }
    },
    mounted: function() {
      self = this;

      
    },
    methods: {
      startedTyping(val){
        this.typing = val;
        this.fetched = false;
        this.results = [];
      },
      searchUnsplash(q){
        this.fetching = true;
        this.fetched = false;
        this.fetch_error = false;
        this.results = [];
        this.page = 1;
        this.typing = false;

        axios.get('https://api.unsplash.com/search/photos', {
          params: {
            query: q,
            per_page: 24,
            client_id: this.clientId
          }
        })
        .then(res => {
          const results = res.data.results.map( ({ color, description, urls, user }) => {
            return { color, description, urls, user };
          });
          this.fetched = true;
          this.results = results;
          this.fetching = false;
          // console.log("Api result", results);
        })
        .catch(err => {
          this.fetched = true;
          this.fetching = false;
          this.fetch_error = true;
          console.log("Api error", err);
        })
      },
      selectImage(url){
        this.$emit("input", url)
      }
    }
  }
</script>