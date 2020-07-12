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

  #emptyMessage{
    padding-top: 0.5em;
    padding-bottom: 0.3em;
    color: #777;
    margin-left: 0.1em;
    font-size: 0.9em;
  }

  #results{
    margin-top: 0.8em;
    margin-right: -0.5em;
    /* columns:3;
    column-gap: 0.2em; */
    /* padding-bottom: 2em; */
  }

  #results > div{
    display: flex;
    align-items: flex-start;
    justify-content: center;
    flex-wrap: wrap;
    position: relative;
  }

  .video-list-item{
    position: relative;
    flex-shrink: 0;
    flex-basis: 50%;
    position: relative;
    cursor: pointer;
    transition: transform 0.15s ease-out;
    z-index: 2;
    position: relative;
    margin-bottom: 0.5em;
  }

  .video-list-item:hover{
    /* transform: scale(1.1); */
  }

  .video-list-item-thumb{
    width: 95%;
    width: calc(100% - 0.5em);
    height: 150px;
    overflow: hidden;
    display: flex;
    align-items: center;
    background: #333;
    border-radius: 2px;
  }

  .video-list-item img{
    width: 100%;
    height: 200px;
    object-fit: cover;
    object-position: center;
  }

  .video-list-item:before{
    /* content: ''; */
    /* box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); */
  }

  .video-list-item-caption{
    /* padding: 1em; */
    padding: 0.6em 0;
    background: rgba(255, 255, 255, 0.95);
    overflow: hidden;
    line-height: 1.1em;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
  }

  .video-list-item-caption span{
    font-size: 0.9em;
  }

  /* #results img{
    width: 100%;
    min-height: 83px;
    background-color: #eee;
	  display:inline-block;
    transition: opacity 0.25s ease-out;
    cursor: pointer;
  }
  
  #results img:hover{
    opacity: 0.7;
  } */

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
      @keyup.enter="searchYoutube($event.target.value)"/>
    
    <div id="movers" v-if="fetched && results.length > perPage">
      <button :class="{'clickable' : page > 1}"
        @click="page = page - 1">Prev</button>
      &emsp;
      <button :class="{'clickable' : results.length > page * perPage}"
        @click="page = page+1">Next</button>
    </div>

    <div id="results" v-if="!typing && fetched && results.length">
      <div>
        <div :title="video.title" class="video-list-item" v-for="(video, index) in results"
          v-if="index >= (page - 1) * perPage && index < page * perPage"
          :key="index"
          @click="selectVideo(video.url)">
          <div class="video-list-item-thumb">
              <img :src="video.image" :alt="video.title" />
          </div>
          <div class="video-list-item-caption">
            <span>{{video.title.substr(0, 30) + (video.title.length > 30 ? '...' : '')}}</span>
          </div>
        </div>
      </div>
    </div>

    <div id="emptyMessage" v-if="!typing && (fetching || fetch_error || (fetched && !results.length))">
      <span v-if="fetching">
        Fetching videos....
      </span>
      <span v-else-if="fetch_error" style="color: #dd5555">
        An error occured fetching videos, check your network connection and try again.
      </span>
      <span v-else-if="!results.length">
        No results found for <strong>{{query}}</strong>
      </span>
    </div>
  </div>
</template>

<script>
  import axios from 'axios';
  import YTSearch from './Search'
  import results from './results'

  var self;
  
  export default {
    props: {
      perPage: {
        type: String,
        default: 10
      },
      apiKey: String
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
    methods: {
      startedTyping(val){
        this.typing = val;
        this.fetched = false;
        this.results = [];
      },
      searchYoutube(q){
        this.fetching = true;
        this.fetched = false;
        this.fetch_error = false;
        this.results = [];
        this.page = 1;
        this.typing = false;

        YTSearch({key: this.apiKey, term: q, maxResults: 16}, 
          videos => {
            this.fetched = true;
            this.results = videos;
            this.fetching = false;
            // console.log("Api result", videos);
          },
          err => {
            this.fetched = true;
            this.fetching = false;
            this.fetch_error = true;
            console.log("Api error", err);
          })
      },
      selectVideo(url){
        this.$emit("input", url)
      }
    }
  }
</script>