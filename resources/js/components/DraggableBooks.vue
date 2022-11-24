<template>


    <draggable :list="booksNew" v-bind="{animation:300, handle:'.drag'}" :element="'div'" @change="update">

        <div v-for="(book, index) in booksNew" class="row mb-3 p-3 block_list" style="width:100%" :data-rowId="index">
            <div class="col-1 drag">
                <span style="font-size:20px;">{{ book.pivot.order }} <i class="bi bi-arrows-expand"></i></span>
            </div>
            <div class="col-10">
                <div style="float: left; margin: 0 10px">
                    <a :href='book.id'>
                    <img :src='book.image' style='max-width:150px'>
                    </a>
                </div>
                <a :href='book.id' class='h3' style='color:#000000'>{{ book.title }}</a> - {{ book.author }}
                <div>{{ 'Quote:' }} {{ book.pivot.quote }}</div>
                <div>{{ 'Review:' }} {{ book.pivot.review }}</div>
            </div>
            <div class="col-1">
                <a :href="book.id + '/edit'">
                    <button class="btn btn-primary">{{ 'EDIT' }}</button>
                </a>
            </div>
        </div>
    </draggable>


</template>
<script>
import draggable from 'vuedraggable'

export default {
    components: {
        draggable
    },
    props: ['books'],
    mounted() {
        console.log('Component mounted. ')
    },
    data() {
        return{
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            booksNew: this.books,
        }
    },
    methods: {
        update(){
            console.log('update!!!!!!!!!!!!!!!');
            this.booksNew.map((book, index) => {
                book.pivot.order = index + 1;
            })

            axios.patch(
                '/books/updateCustomerSort',
                {booksNew: this.booksNew})
                .then(response => {
                //this.data = response.data.items;
            })


        }

    }
}
</script>
