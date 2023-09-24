<template>
    <section>
        <div class="container">        
            <h2>Hi, lets shorten that URL!</h2>
            <form action="">
                <input v-model="url" type="url" name="url" id="url" placeholder="Your URL goes here">
                <label for="url">{{ url }}</label>
            </form>
        </div>
    </section>
</template>

<script>

export default {
    data() {
        return {
            url: ''
        }
    }
}

</script>