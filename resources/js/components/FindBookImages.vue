<template>

    <div class="row justify-content-center mb-3">
        <div class="col-md-12 nopadding-inline-start">
            <ul>
                <li v-for="item in data" class="col-md-4 text-center mt-3 mb-3 d-flex align-items-start flex-column">
                    <div class="shwimg"><img :src="item.link" style="max-width:100%"></div>
                    <div class="border-bottom mt-auto">
                        <input type="radio" name="book_cover" id="book_cover" :id="item.link" v-on:change="call(item.link);" :value="item.link">
                        <input type="text" name="book_title" id="book_title"  :value="title">
                        <input type="text" name="book_author" id="book_author"  :value="author">
                    </div>
                </li>
            </ul>
        </div>
    </div>

</template>

<script>
export default {
    name: 'find-book-images',
    props: ['searchBook', 'author', 'title'],
    data() {
        return {
            theUrl : "",
            data : ""
        };
    },
    beforeMount() {
        //this.getImages();
    },
    methods: {
        call(link)
        {
            this.theUrl = link;
            console.log(this.theUrl);
        }

    },
    mounted() {
        this.theUrl = 'https://customsearch.googleapis.com/customsearch/v1?key=AIzaSyAMjD_gajfq7GVeRXCFWsQhAIxw4hTwnMk&cx=009864086180255169656%3Abislxiibo84&q='+this.searchBook+'&searchType=image&num=9&siteSearch=https%3A%2F%2Flookaside.fbsbx.com%2F&siteSearchFilter=e';
        axios.get(this.theUrl)
            .then(response => {
                this.data = response.data.items;
                //console.log(this.data)
            })

    }
}
</script>

<style>
ul {
    display: flex;
    flex-direction: row; /*not needed as this is the default behavior*/
    flex-wrap: wrap;
}

li {
    list-style-type: none;
}

.border-bottom {
    width: 100%;
}

</style>
