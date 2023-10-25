<script>
import Axios from 'axios'
import Link from '@/Components/Icons/Link.vue'
import Create from '@/Components/Icons/Create.vue'
import Copy from '@/Components/Icons/Copy.vue'
import Copied from '@/Components/Icons/Copied.vue'
import Forward from '@/Components/Icons/Forward.vue'

export default {
    data() {
        return {
            url: '',
            shortUrl: '',
            showError: false,
            isCopied: false,
            tr: {
                title: 'Hi, lets shorten that URL!',
                done: 'done!',
                submit: 'Create',
                copy: 'Copy',
                copied: 'Copied!',
                new: 'New',
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
        formToggle() {
            return this.shortUrl.length == 0;
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
                    self.url = res.data.shortUrl;
                }
                console.log(res);
            }).catch(e => console.log(e));
        },
        copyToClipboard() {
            let txt = document.getElementById('url');

            txt.select();
            txt.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(txt.value);

            this.isCopied = !this.isCopied;
        },
        createNextUrl() {
            this.url = '';
            this.shortUrl = '';
            this.isCopied = false;
        }
    },
    components: { Link, Create, Copy, Copied, Forward }
}

</script>

<template>
    <section>
        <div class="form">
            <h2>{{ tr.title }}</h2>
            <form v-on:submit.prevent="shortenTheUrl">
                <div class="row url-input items-stretch">
                    <Link class="icon-link" />
                    <input v-model="url" type="url" name="url" id="url" :placeholder="tr.placeholder" :disabled="!formToggle" maxlength="1000" autofocus>
                    <button type="submit" class="cta" :disabled="!isFilled" v-if="formToggle"><Create />  {{ tr.submit }} </button>
                    <button type="button" class="cta" v-if="!formToggle" @click="this.copyToClipboard">
                        <span v-if="!isCopied"><Copy />{{ tr.copy }}</span>
                        <span v-if="isCopied"><Copied />{{ tr.copied }}</span>
                    </button>
                    <button type="button" class="cta" v-if="!formToggle" @click="this.createNextUrl"><Forward class="icon icon-forward" />{{ tr.new}}</button>
                </div>
                <label for="url" v-if="showError" class="url-error">{{ tr.errors.notUrl }}</label>
            </form>
        </div>
    </section>
</template>

<style>
    section {
        display: block;
        color: var(--accent);
        /* background: var(--bg-color); */
        height:calc(100vh - 65px);
        margin: 0;
    
        .form {
            height: 100%;
            padding: 0;
            margin: 0 10%;
            display: flex;
            /* align-items: center; */
            justify-content: center;
            flex-direction: column;
        
            .url-input {
                display: flex;
                flex-direction: row;
                gap: 4px;
                background: var(--accent);
                padding: 4px;
                border-radius: var(--bor-rad-xl);
                position: relative;

                .icon-link {
                    position: absolute;
                    margin: 9px 10px;
                }

                #url {
                    width: 100%;
                    height: 50px;
                    border-radius: var(--bor-rad-sm);
                    outline: none;
                    padding: 25px 15px 25px 50px;
                    border: none;
                }

                #short-url {
                    width: 100%;
                    height: 50px;
                    border-radius: var(--bor-rad-sm);
                    outline: none;
                    border: none;
                    background-color: var(--bg-color);
                    display: flex;
                    align-items: center;
                    padding-left: 50px;
                }

                .cta {
                    outline: none;
                    border-radius: var(--bor-rad-sm);
                    background: var(--cta);
                    background-color: var(--cta);
                    color: var(--base);
                    border: none;
                    padding: 0 20px;
                    display: flex;
                    justify-content: center;
                    align-items: center;

                    &:hover:enabled{
                        cursor: pointer;
                        filter: brightness(110%);
                    }

                    &[disabled] {
                        /* background: var(--grey);
                        background-color: var(--grey); */
                        display: none;
                    }

                    &:focus {
                        outline: none;
                    }

                    span {
                        display: flex;
                        justify-content: center;
                        align-items: center;
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