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
                placeholder: 'Your URL goes here',
                errors: {
                    notUrl: 'This is not a valid URL.'
                }
            }
        };
    },
    computed: {
        isFilled() {
            return this.url.length > 0;
        },
        showShortUrl() {
            return this.shortUrl.length > 0;
        },
        isUrl() {
            try {
                let u = new URL(this.url);
                return u.protocol === 'http:' || u.protocol === 'https:';
            }
            catch (error) {
                return false;
            }
        }
    },
    methods: {
        shortenTheUrl() {
            if (!this.isFilled) {
                return;
            }
            if (!this.isUrl) {
                this.showError = true;
                return;
            }
            var self = this;
            Axios.post('/shortenTheUrl', {
                url: this.url
            }).then((res) => {
                if (res.status === 200) {
                    self.shortUrl = res.data.shortUrl;
                }
                console.log(res);
            }).catch(e => console.log(e));
        }
    }
}

</script>

<template>
    <section>
        <div class="form">
            <h2>{{ tr.title }}</h2>
            <form v-on:submit.prevent="shortenTheUrl">
                <div class="row">
                    <input v-model="url" type="text" name="url" id="url" :placeholder="tr.placeholder" maxlength="1000" autofocus>
                    <input type="submit" :value="tr.submit" id="cta" :disabled="!isFilled">
                </div>
                <label for="url" v-if="showError" class="url-error">{{ tr.errors.notUrl }}</label>
                <p v-if="showShortUrl">{{ shortUrl }}</p>
            </form>
        </div>
    </section>
</template>

<style>
    section {
        display: block;
        color: var(--accent);
        background: var(--bg-color);
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
                background: var(--accent);
                padding: 4px;
                border-radius: var(--bor-rad-xl);

                #url {
                    width: 100%;
                    height: 50px;
                    border-radius: var(--bor-rad-sm);
                    outline: none;
                    padding: 25px 50px;
                    border: none;
                }
                #cta {
                    outline: none;
                    border-radius: var(--bor-rad-sm);
                    background: var(--cta);
                    background-color: var(--cta);
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

        @media screen and (min-width: 922px) {
            .form {
                margin: 0 20%;
            }
        }

        @media screen and (min-width: 1200px) {
            .form {
                margin: 0 30%;
            }
        }
    }


</style>