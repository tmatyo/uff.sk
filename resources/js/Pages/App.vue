<template>
    <section>
        <div class="container">        
            <h2>Hi, lets shorten that URL!</h2>
            <form method="POST" v-on:submit.preven="shortenTheUrl">
                <input v-model="url" type="text" name="url" id="url" placeholder="Your URL goes here">
                <label for="url">{{ url }}</label>
                <span>{{ isFilled }}</span>

            </form>
        </div>
    </section>
</template>

<script>
import Axios from 'axios'
export default {
    data() {
        return {
            url: '',
            shortUrl: ''
        }
    },
    computed: {
        isFilled() {
            return this.url.length > 0;
        }
    },
    methods: {
        shortenTheUrl() {
            var self = this;
            Axios.post('/shortenTheUrl', { 
                url: this.url
            }).then((res) => {
                self.shortUrl = res.shortUrl
            }).catch( e => console.log(e))
        }
    }
}

</script>

<style>
    section {
        display: block;
        color: var(--navy);
        background: var(--beige);
        height:100vh;
        width:100vw;
        padding: 60px;
        margin: 0;
    }
    #url {
        width: 100%;
        height: 50px;        
        border-radius: 8px;
        border-color: var(--navy);
        outline: none;
        padding: 25px 50px;
    }
</style>