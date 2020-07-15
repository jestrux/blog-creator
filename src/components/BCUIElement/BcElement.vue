<script>
    export default {
        props: {
            options : Object,
            component : String,
            html: String
        },
        data: function(){
            return{
                useinner: false,
                editting: false
            }
        },
        mounted: function(){
            this._emitHTML();
        },
        watch: {
            component: {
                immediate: true,
                handler(val){
                    this._emitHTML();
                },
                deep: true
            },
            options: {
                immediate: true,
                deep: true,
                handler(){
                    this._emitHTML();
                }
            }
        },
        methods: {
            _emitHTML: function(){
                if(this.$el){
                    const html = this.useinner ? this.$el.innerHTML : this.$el.outerHTML;
                    const outerDiv = document.createElement("div");
                    outerDiv.classList.add('blogpost-section-wrapper');

                    if((this.component === 'bc-image' || this.component === 'bc-youtube-video') && this.options.width === 'wide')
                        outerDiv.classList.add('wide-image');
                    
                    else if((this.component === 'bc-image' || this.component === 'bc-youtube-video') && this.options.width === 'full')
                        outerDiv.classList.add('full-image');


                    outerDiv.innerHTML = html;
                    this.$emit('input', outerDiv.outerHTML);
                }
            }
        }
    }
</script>