<template>
    <section>
        <div class="container form">
            <h2>{{ tr.title }}</h2>
            <form v-on:submit.prevent="shortenTheUrl">
                <div class="row">
                    <input v-model="url" type="text" name="url" id="url" placeholder="Your URL goes here">
                    <input type="submit" :value="tr.submit" id="cta" :disabled="!isFilled">
                </div>
                <label for="url" v-if="showError" class="url-error">{{ tr.errors.notUrl }}</label>
                <p v-if="showShortUrl">{{ shortUrl }}</p>
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
            shortUrl: '',
            showError: false,
            tr: {
                title: 'Hi, lets shorten that URL!',
                submit: 'Submitttt',
                errors: {
                    notUrl: 'This is not a valid URL.'
                }
            }
        }
    },
    computed: {
        isFilled() {
            return this.url.length > 0
        },
        showShortUrl() {
            return this.shortUrl.length > 0
        },
        isUrl() {
            try {
                let u = new URL(this.url)
                return true && (u.protocol === 'http:' || u.protocol === 'https:')
            } catch (error) {
                return false
            }
        }
    },
    methods: {
        shortenTheUrl() {
            if(!this.isFilled) {
                return
            }

            if(!this.isUrl) {
                this.showError = true
                return
            }

            var self = this;
            Axios.post('/shortenTheUrl', { 
                url: this.url
            }).then((res) => {
                if(res.status === 200) {
                    self.shortUrl = res.data.shortUrl
                }
                console.log(res)
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
        margin: 0;
    
        .form {
            height: 100%;
            padding: 0;
            margin: 0 10%;
            display: flex;
            /* align-items: center; */
            justify-content: center;
            flex-direction: column;
        
            .row {
                display: flex;
                flex-direction: row;
                gap: 4px;
                background: var(--navy);
                padding: 4px;
                border-radius: var(--bor-rad-xl);

                #url {
                    width: 100%;
                    height: 50px;
                    border-radius: var(--bor-rad-xl);
                    outline: none;
                    padding: 25px 50px;
                    border: none;
                }
                #cta {
                    outline: none;
                    border-radius: var(--bor-rad-xl);
                    background: var(--orange);
                    background-color: var(--orange);
                    color: var(--base);
                    border: none;

                    &:hover:enabled{
                        cursor: pointer;
                        filter: brightness(110%);
                    }

                    &[disabled] {
                        /* background: var(--grey);
                        background-color: var(--grey); */
                        display: none;
                    }
                }
            }

            .url-error {
                margin: 15px;
                display: block;
            }
        }
    }
</style>