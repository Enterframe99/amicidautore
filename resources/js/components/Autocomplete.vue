<template>
    <div>
        <form :method='this.formMethod'  :action='this.actionForm' >
            <div class="form-group">
                <div class="mb-3">
                    <label>Titolo</label>
                    <input type="text" placeholder="Title" name="book_title" id="book_title" v-model="searchTitle" v-on:keyup="autoCompleteTitle" class="form-control" required>
                    <div class="panel-footer" v-if="resultsTitle.length">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="result in resultsTitle" :key="result.id">
                                <a href="#" v-on:click.prevent="findedBook(result)">{{ result.title }}  -  {{ result.author }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Autore</label>
                    <input type="text" placeholder="Author" name="book_author" id="book_author" v-model="searchAuthor" v-on:keyup="autoCompleteAuthor" class="form-control" required>
                    <div class="panel-footer" v-if="resultsAuthor.length">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="result in resultsAuthor" :key="result.id">
                                <a href="#" v-on:click.prevent="findedBook(result)">{{ result.author }}  -  {{ result.title }} </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mb-3">
                    <div v-if="this.related != 'none'">
                        <input type="radio" name="in-library" id="insert-in-library" value="1" v-model="picked">
                        <label class="mb-0" for="insert-in-library">Inserisci questo libro nella mia libreria (se non ancora presente)</label>
                        <br>
                        <input type="radio" name="in-library" id="already-in-library" value="-1" v-model="picked">
                        <label class="mb-0" for="already-in-library">Questo libro è già presente nella mia libreria</label>
                        <br>
                        <input type="radio" name="in-library" id="not-insert-in-library" value="0" v-model="picked">
                        <label for="not-insert-in-library">Non inserire questo libro nella mia libreria</label>
                    </div>
                </div>
                <!-- related book if present -->
                <input type="hidden" name="related_book" id="related_book" class="form-control" :value="this.related">
                <div class="panel-footer" v-if="bookSelected != true">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="panel-footer" v-else>
                    <button type="submit" class="btn btn-primary">Book already in the archive, click here!</button>
                </div>
                <input type="hidden" name="_token" :value="csrf">
            </div>
        </form>
    </div>
</template>
<script>
export default{
    data: function(){
        return {
            // https://stackoverflow.com/questions/45523101/how-to-refer-laravel-csrf-field-inside-a-vue-template
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            formMethod: '',
            searchTitle: '',
            searchAuthor: '',
            searchId: '',
            resultsTitle: [],
            resultsAuthor: [],
            bookSelected: '',
            actionForm: '',
            picked: '1', // radio default value
        }
    },
    props: ['action01', 'action02', 'related'],
    watch: {
        bookSelected: function(value){
            if(value == true){
                this.actionForm = this.action02 + '/' + this.searchId;
            }  else {
                this.actionForm = this.action01;
            }
        }
    },
    methods: {
        autoCompleteTitle(){
            this.bookSelected = false;
            this.formMethod = 'POST';
            this.results = [];
            if(this.searchTitle.length > 4){
                axios.get('/api/searchTitle',{params: {query: this.searchTitle}}).then(response => {       // routes/api.php
                    this.resultsTitle = response.data;
                })
            }
        },
        autoCompleteAuthor(){
            this.bookSelected = false;
            this.formMethod = 'POST';
            this.results = [];
            if(this.searchAuthor.length > 4){
                axios.get('/api/searchAuthor',{params: {query: this.searchAuthor}}).then(response => {       // routes/api.php
                    this.resultsAuthor = response.data;
                })
            }
        },
        findedBook(book){
            console.log(book); // correctly return the ID
            this.searchTitle = book.title;
            this.searchAuthor = book.author;
            this.searchId = book.id;
            this.resultsTitle = [];
            this.resultsAuthor = [];
            this.bookSelected = true;
            this.formMethod = 'GET';
        }
    }
}
</script>
